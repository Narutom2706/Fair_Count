<?php

namespace App\Manager;

use App\Core\Db;
use App\Model\Expense;

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
}