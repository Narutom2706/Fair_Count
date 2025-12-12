<?php

namespace App\Controller;

use App\Core\AbstractController;
use App\Manager\UserManager;
use App\Model\User;

class AuthController extends AbstractController
{
public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $manager = new UserManager();
            $user = $manager->findByEmail($email);

            if ($user && password_verify($password, $user->getPassword())) {
                $_SESSION['user'] = $user;
                $this->redirect('index.php?page=home');
            } else {
                $this->render('auth/login', ['error' => 'Identifiants incorrects']);
            }
            return;
        }
        $this->render('auth/login');
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $firstName = $_POST['first_name'];
            $lastName = $_POST['last_name'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            $user = new User();
            $user->setFirstName($firstName);
            $user->setLastName($lastName);
            $user->setEmail($email);
            $user->setPassword(password_hash($password, PASSWORD_DEFAULT));

            $manager = new UserManager();
            $manager->create($user);

            $this->redirect('index.php?page=login');
        }

        $this->render('auth/register');
    }

    public function logout()
    {
        session_destroy();
        $this->redirect('index.php?page=home');
    }
}