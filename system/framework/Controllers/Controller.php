<?php
namespace Controllers;

use Config\Config;
use Database\DatabaseSetup;
use View\View;

abstract class Controller
{
    public $entityManager;
    private $view;

    public function __construct()
    {
        $this->view = new View();
        $database = new DatabaseSetup();
        $this->entityManager = $database->setupDoctrineOrm(Config::loadDatabaseConfig());
    }

    protected function view($templateURI, $variables = array())
    {
        $this->view->make($templateURI, $variables);
    }
}
