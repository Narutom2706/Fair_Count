<?php

namespace App\Manager;

use App\Core\Db;
use App\Model\Expense;
use PDO;

class ExpenseManager
{
    public function create(Expense $expense, array $participantIds): void
    {
        $db = Db::getInstance();
        
        $stmt = $db->prepare("INSERT INTO expense (title, amount, date, user_id, category_id) VALUES (:title, :amount, :date, :user_id, :category_id)");
        $stmt->execute([
            'title' => $expense->getTitle(),
            'amount' => $expense->getAmount(),
            'date' => $expense->getDate(),
            'user_id' => $expense->getUserId(),
            'category_id' => $expense->getCategoryId(),
        ]);

        $expenseId = $db->lastInsertId();

        $sql = "INSERT INTO expense_participant (expense_id, user_id) VALUES (:expense_id, :user_id)";
        $stmtPart = $db->prepare($sql);

        foreach ($participantIds as $userId) {
            $stmtPart->execute([
                'expense_id' => $expenseId,
                'user_id' => $userId
            ]);
        }
    }

    public function findAllByUser(int $userId): array
    {
        $db = Db::getInstance();
        
        $sql = "SELECT 
                    e.*, 
                    u.first_name, 
                    u.last_name, 
                    c.label as category_label,
                    (
                        SELECT GROUP_CONCAT(u2.first_name SEPARATOR ', ')
                        FROM expense_participant ep2
                        JOIN user u2 ON ep2.user_id = u2.id
                        WHERE ep2.expense_id = e.id
                    ) as participants_names
                FROM expense e
                JOIN user u ON e.user_id = u.id
                JOIN category c ON e.category_id = c.id
                LEFT JOIN expense_participant ep ON e.id = ep.expense_id
                WHERE e.user_id = :userId OR ep.user_id = :userId
                GROUP BY e.id
                ORDER BY e.date DESC";
        
        $stmt = $db->prepare($sql);
        $stmt->execute(['userId' => $userId]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function calculateBalance(int $userId): float
    {
        $db = Db::getInstance();
        $balance = 0.0;

        // On ne compte QUE ce qui sort réellement de la poche (Payer)
        $sql = "SELECT amount, user_id as payer_id FROM expense WHERE user_id = :userId";
        $stmt = $db->prepare($sql);
        $stmt->execute(['userId' => $userId]);
        $expensesPaid = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($expensesPaid as $expense) {
            $balance -= (float) $expense['amount'];
        }

        // Ajout des remboursements reçus (+)
        $stmt = $db->prepare("SELECT SUM(amount) FROM reimbursement WHERE user_id_to = ?");
        $stmt->execute([$userId]);
        $received = (float) $stmt->fetchColumn();
        $balance += $received; 

        // Retrait des remboursements donnés (-)
        $stmt = $db->prepare("SELECT SUM(amount) FROM reimbursement WHERE user_id_from = ?");
        $stmt->execute([$userId]);
        $sent = (float) $stmt->fetchColumn();
        $balance -= $sent;

        return $balance;
    }
}