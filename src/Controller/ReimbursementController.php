<?php

namespace App\Controller;

use App\Core\AbstractController;
use App\Manager\ReimbursementManager;
use App\Manager\UserManager;
use App\Model\Reimbursement;

class ReimbursementController extends AbstractController
{
    public function add()
    {
        if (!isset($_SESSION['user'])) {
            $this->redirect('index.php?page=login');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $amount = (float) $_POST['amount'];
            $userToId = (int) $_POST['user_to'];
            $date = $_POST['date'];

            $reimbursement = new Reimbursement();
            $reimbursement->setAmount((int)($amount * 100)); // Centimes
            $reimbursement->setDate($date);
            $reimbursement->setUserIdFrom($_SESSION['user']->getId());
            $reimbursement->setUserIdTo($userToId);

            $manager = new ReimbursementManager();
            $manager->create($reimbursement);

            $this->redirect('index.php?page=home&success=Remboursement_enregistré');
        }

        $userManager = new UserManager();
        $users = $userManager->findAll();

        $this->render('reimbursement/add', ['users' => $users]);
    }
}