<?php

namespace App\Manager;

use App\Core\Db;
use App\Model\Reimbursement;
use PDO;

class ReimbursementManager
{
    public function create(Reimbursement $reimb): void
    {
        $db = Db::getInstance();
        $stmt = $db->prepare("INSERT INTO reimbursement (amount, date, user_id_from, user_id_to) VALUES (:amount, :date, :from_id, :to_id)");
        $stmt->execute([
            'amount' => $reimb->getAmount(),
            'date' => $reimb->getDate(),
            'from_id' => $reimb->getUserIdFrom(),
            'to_id' => $reimb->getUserIdTo()
        ]);
    }

    public function findAllByUser(int $userId): array
    {
        $db = Db::getInstance();
        
        $sql = "SELECT r.*, u1.first_name as from_name, u2.first_name as to_name 
                FROM reimbursement r
                JOIN user u1 ON r.user_id_from = u1.id
                JOIN user u2 ON r.user_id_to = u2.id
                WHERE r.user_id_from = :userId OR r.user_id_to = :userId
                ORDER BY r.date DESC";
        
        $stmt = $db->prepare($sql);
        $stmt->execute(['userId' => $userId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}