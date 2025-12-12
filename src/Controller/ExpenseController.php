<?php

namespace App\Controller;

use App\Core\AbstractController;
use App\Manager\CategoryManager;
use App\Manager\ExpenseManager;
use App\Manager\UserManager;
use App\Model\Expense;

class ExpenseController extends AbstractController
{
    public function add()
    {
        if (!isset($_SESSION['user'])) {
            $this->redirect('index.php?page=login');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $title = $_POST['title'];
            $amount = (float) $_POST['amount']; 
            $date = $_POST['date'];
            $categoryId = (int) $_POST['category'];
            $payerId = (int) $_POST['payer']; 
            $participantIds = $_POST['participants'] ?? [];

            if (empty($title) || $amount <= 0 || empty($date) || empty($participantIds)) {
                $this->redirect('index.php?page=add_expense&error=Champs_manquants');
                return;
            }

            $expense = new Expense();
            $expense->setTitle($title);
            $expense->setAmount((int)($amount * 100)); 
            $expense->setDate($date);
            $expense->setCategoryId($categoryId);
            $expense->setUserId($payerId);

            $manager = new ExpenseManager();
            $manager->create($expense, $participantIds);

            $this->redirect('index.php?page=home');
        }

        $categoryManager = new CategoryManager();
        $categories = $categoryManager->findAll();

        $userManager = new UserManager();
        $users = $userManager->findAll();

        $this->render('expense/add', [
            'categories' => $categories,
            'users' => $users
        ]);
    }
}