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

        $expenseManager = new ExpenseManager();
        $reimbursementManager = new ReimbursementManager();

        $expenses = $expenseManager->findAll();
        $reimbursements = $reimbursementManager->findAll();

        $this->render('home/dashboard', [
            'expenses' => $expenses,
            'reimbursements' => $reimbursements
        ]);
    }
}