<?php

namespace Controllers;


class ErrorController extends BaseController
{

    public function notFound(){
        $user = $this->getLoggedUser();
        $this->view("errors/not-found.twig" , compact('user'));
    }
}