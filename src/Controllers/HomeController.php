<?php
namespace App\Controller;

use App\Core\AbstractController;

class HomeController extends AbstractController {
    public function index() {
        echo "<h1>Bienvenue sur FairCount !</h1>";
    }
}