<?php

namespace App\Manager;

use App\Core\Db;
use App\Model\User;
use PDO;

class UserManager
{
    public function findByEmail(string $email): ?User
    {
        $db = Db::getInstance();
        $stmt = $db->prepare("SELECT * FROM user WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, User::class);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function create(User $user): void
    {
        $db = Db::getInstance();
        $stmt = $db->prepare("INSERT INTO user (first_name, last_name, email, password) VALUES (:first_name, :last_name, :email, :password)");
        $stmt->execute([
            'first_name' => $user->getFirstName(),
            'last_name' => $user->getLastName(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),
        ]);
    }
    
    public function findAll(): array
    {
        $db = Db::getInstance();
        $stmt = $db->query("SELECT * FROM user");
        return $stmt->fetchAll(PDO::FETCH_CLASS, User::class);
    }
}