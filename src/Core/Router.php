<?php

namespace App\Core;

use App\Controller\AuthController;
use App\Controller\HomeController;

class Router
{
    public function run()
    {
        $page = $_GET['page'] ?? 'home';

        // --- ROUTING ---
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

            default:
                echo "Page 404 : Introuvable";
                break;
        }
    }
}