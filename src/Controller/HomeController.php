<?php

namespace App\Controller;

use App\Core\AbstractController;
use App\Manager\ExpenseManager;
use App\Manager\ReimbursementManager;

class HomeController extends AbstractController
{
    public function index()
    {
        if (!isset($_SESSION['user'])) {
            $this->render('home/index');
            return;
        }

        $userId = $_SESSION['user']->getId();

        $expenseManager = new ExpenseManager();
        $reimbursementManager = new ReimbursementManager();

        $expenses = $expenseManager->findAllByUser($userId);
        $reimbursements = $reimbursementManager->findAllByUser($userId);
        
        $totalBalance = $expenseManager->calculateBalance($userId);

        $this->render('home/dashboard', [
            'expenses' => $expenses,
            'reimbursements' => $reimbursements,
            'totalBalance' => $totalBalance 
        ]);
    }
}