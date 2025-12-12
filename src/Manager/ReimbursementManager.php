<?php

namespace App\Manager;

use App\Core\Db;
use App\Model\Reimbursement;

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

    public function findAll(): array
    {
        $db = Db::getInstance();
        // On joint deux fois la table user : une pour l'émetteur (u1), une pour le receveur (u2)
        $sql = "SELECT r.*, u1.first_name as from_name, u2.first_name as to_name 
                FROM reimbursement r
                JOIN user u1 ON r.user_id_from = u1.id
                JOIN user u2 ON r.user_id_to = u2.id
                ORDER BY r.date DESC";
        return $db->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
    }
}