<?php

namespace View;

use Config\Paths;
use Twig_Environment;
use Twig_Loader_Filesystem;
use Twig_SimpleFunction;

class View
{
    private $loader;
    public $twig;

    public function __construct()
    {
        $this->loader = new Twig_Loader_Filesystem(Paths::get('app') . '/views/');
        $this->twig = new Twig_Environment($this->loader);

        $this->twig->addFunction(new Twig_SimpleFunction('asset', '\URL\URL::asset'));
        $this->twig->addFunction(new Twig_SimpleFunction('url', '\URL\URL::url'));
    }

    public function make($templateURI, $variables)
    {
        $template = $this->twig->loadTemplate($templateURI);
        echo $template->render($variables);
    }

}
