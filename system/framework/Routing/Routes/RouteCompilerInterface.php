<?php
namespace Routes;

interface RouteCompilerInterface
{
    public function compileTemplate($route, $frameworkParameters);
}
