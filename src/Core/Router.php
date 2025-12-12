<?php

namespace App\Core;

use App\Controller\HomeController;
use App\Controller\AuthController;
use App\Controller\ExpenseController; // <--- AJOUTE ÇA

class Router
{
    public function run()
    {
        $page = $_GET['page'] ?? 'home';

        switch ($page) {
            case 'home':
                $controller = new HomeController();
                $controller->index();
                break;

            case 'register':
                $controller = new AuthController();
                $controller->register();
                break;

            case 'login':
                $controller = new AuthController();
                $controller->login();
                break;
                
            case 'logout':
                $controller = new AuthController();
                $controller->logout();
                break;

            case 'add_expense':
                $controller = new ExpenseController();
                $controller->add();
                break;

            default:
                echo "Page introuvable";
                break;
        }
    }
}