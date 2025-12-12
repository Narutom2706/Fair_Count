<?php

namespace App\Manager;

use App\Core\Db;
use App\Model\Category;
use PDO;

class CategoryManager
{
    public function findAll(): array
    {
        $db = Db::getInstance();
        $stmt = $db->query("SELECT * FROM category");
        return $stmt->fetchAll(PDO::FETCH_CLASS, Category::class);
    }
}