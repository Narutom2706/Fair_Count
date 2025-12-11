<?php
namespace App\Controller;

use App\Core\AbstractController;

class AuthController extends AbstractController {
    public function register() {
        echo "<h1>Page Inscription</h1>";
    }

    public function login() {
        echo "<h1>Page Connexion</h1>";
    }
    
    public function logout() {
        echo "Déconnexion...";
    }
}