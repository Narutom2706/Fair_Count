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

    public function findAll(): array
    {
        $db = Db::getInstance();
        $sql = "SELECT e.*, u.first_name, u.last_name, c.label as category_label 
                FROM expense e
                JOIN user u ON e.user_id = u.id
                JOIN category c ON e.category_id = c.id
                ORDER BY e.date DESC";
        
        $stmt = $db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}