<?php

use Config\Config;

class App
{
    public function bindPaths($paths)
    {
        \Config\Paths::setPaths($paths);
    }

    public function start()
    {
        $this->parseRoute();
    }

    private function parseRoute()
    {
        Config::loadRoutes();

        $routeCompiler = new \Routes\RouteCompiler();
        $router = new \Routing\Router($routeCompiler);
        $router->ParseRoute();
    }
}
