<?php

namespace Controllers;


use Security\FormToken;
use URL\URL;

abstract class BaseController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        @session_start();
        if (empty($_SESSION["formToken"])) {
            $_SESSION["formToken"] = FormToken::generateToken();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (empty($_POST['formToken']) || $_SESSION["formToken"] != $_POST['formToken']) {
                $this->notFound();
            }
        }
    }

    protected function getLoggedUser()
    {
        if (isset($_SESSION['username'])) {
            $username = $_SESSION['username'];

            return $this->entityManager->getRepository("Models\User")->findOneBy(array('username' => $username));
        }

        return false;
    }

    protected function view($templateURI, $variables = array())
    {
        $categories = $this
            ->entityManager
            ->createQuery("SELECT c.name, c.id FROM Models\Category c ")
            ->getArrayResult();

        $token = $_SESSION["formToken"];
        $variables['categories'] = $categories;
        $variables['token'] = $token;
        parent::view($templateURI, $variables);
    }

    protected function notFound()
    {
        URL::redirect('error/notFound');
    }

    protected function login()
    {
        URL::redirect('user/login');
    }

    protected function checkIsAdmin()
    {
        $user = $this->getLoggedUser();
        if (empty($user) || !$user->getIsAdmin()) {
            $this->notFound();
        }
    }
}