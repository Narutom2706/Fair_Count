<?php

namespace App\Core;

use PDO;
use PDOException;

class Db extends PDO
{
    private static $instance;

    private function __construct()
    {
        $port = $_ENV['DB_PORT'] ?? 3306;
        
        $_dsn = 'mysql:dbname=' . $_ENV['DB_NAME'] . ';host=' . $_ENV['DB_HOST'] . ';port=' . $port;

        try {
            parent::__construct($_dsn, $_ENV['DB_USER'], $_ENV['DB_PASS']);
            $this->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');
            $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Erreur SQL : ' . $e->getMessage());
        }
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}