<?php

namespace Controllers;


use Security\FormToken;

abstract class BaseController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        session_start();
        if (empty($_SESSION["formToken"])) {
            $_SESSION["formToken"] = FormToken::generateToken();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (empty($_POST['formToken']) || $_SESSION["formToken"] != $_POST['formToken']) {
                die; // Todo fix this
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

    public function view($templateURI, $variables = array())
    {
        $categories = $this->entityManager->createQuery("SELECT c.name FROM Models\Category c ")->getArrayResult();
        $token = $_SESSION["formToken"];

        $variables['categories'] = $categories;
        $variables['token'] = $token;
        parent::view($templateURI, $variables);
    }
}