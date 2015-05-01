<?php

namespace Controllers;


use Database\FilterException;
use Models\User;
use URL\URL;

class UserController extends BaseController
{
    public function login()
    {
        $user = $this->getLoggedUser();
        if ($user) {
            URL::redirect('home');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user = $this->entityManager->getRepository("Models\User")->findOneBy(array(
                "password" => md5($_POST['password']),
                "username" => $_POST['username']
            ));

            $_SESSION['username'] = $user->getUsername();
            $_SESSION['id'] = $user->getId();

            URL::redirect('');
        } else {
            $this->view("login.twig");
        }
    }

    public function registration()
    {
        $user = $this->getLoggedUser();
        if ($user) {
            URL::redirect('/');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                $user = new User();

                $user->setUsername($_POST['username']);
                $user->setEmail($_POST['email']);
                $user->setPassword($_POST['password']);
                $user->setFirstName($_POST['firstName']);
                $user->setLastName($_POST['lastName']);

                $this->entityManager->persist($user);
                $this->entityManager->flush();

                URL::redirect('user/login');

            } catch (FilterException $e) {
                $error = $e->getMessage();
                $oldInput = $_POST;

                $this->view("registration.twig", compact("error", "oldInput"));
            }
        } else {
            $this->view("registration.twig");
        }
    }

    public function logout()
    {
        $user = $this->getLoggedUser();
        if ($user) {
            session_destroy();
        }

        URL::redirect('');
    }
}