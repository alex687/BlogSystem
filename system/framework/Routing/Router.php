<?php
namespace Routing;

use Routes\RouteCompilerInterface;

class Router
{
    private $frameworkAttributes = array("controller", "action");
    private $compiler;

    public function __construct(RouteCompilerInterface $compiler)
    {
        $this->compiler = $compiler;
    }

    public function parseRoute()
    {
        $routeTemplates = Route::getAllRoutes();
        $request = $this->getRequestUrl();

        foreach ($routeTemplates as $routeTemplate => $defaultParamValues) {
            $compiledRoute = $this->compiler->compileTemplate($routeTemplate, $this->frameworkAttributes);

            if (preg_match('#' . $compiledRoute->getRegex() . '#', $request, $matches)) {
                $routeParamsValues = [];

                foreach ($compiledRoute->getTemplateParameters() as $key => $parameterInfo) {
                    $paramName = $parameterInfo["name"];
                    if (array_key_exists($key + 1, $matches)) {
                        $routeParamsValues[$paramName] = $matches[$key + 1];
                    } elseif (isset($defaultParamValues[$paramName])) {
                        $routeParamsValues[$paramName] = $defaultParamValues[$paramName];
                    } elseif ($parameterInfo["isRequired"]) {
                        //TODO : Not Found 404 Response
                    }
                }
                if (empty($routeParamsValues["controller"])) {
                    if (isset($defaultParamValues["controller"])) {
                        $routeParamsValues["controller"] = $defaultParamValues["controller"];
                    } else {
                        continue;
                    }
                }
                $controller = $this->getController($routeParamsValues["controller"]);
                $methodParameters = $routeParamsValues;
                unset($methodParameters["controller"]);
                unset($methodParameters["action"]);

                $this->callFunction($controller, $routeParamsValues["action"], $methodParameters);

                break;
            }
        }

        //TODO : Not Found 404 Response
    }

    private function getController($controllerName)
    {
        $controllerFullName = "\Controllers\\" . ucfirst($controllerName) . "Controller";

        if (class_exists($controllerFullName)) {
            return new $controllerFullName();
        } else {
            throw new ControllerNotFoundException("The $controllerName was not found");
        }
    }

    private function callFunction($controller, $functionName, $parameters)
    {
        call_user_func_array(array($controller, $functionName), $parameters);
    }

    private function getRequestUrl()
    {
        global $_SERVER;
        if (isset($_SERVER['PATH_INFO'])) {
            $request = $_SERVER['PATH_INFO'];
        } else {
            $request = $_SERVER['REQUEST_URI'];
            $requestHome = dirname($_SERVER['PHP_SELF']);
            $request = substr($request, strlen($requestHome) + 1);
        }

        if ($request[strlen($request) - 1] != '/') {
            $request .= '/';
        }

        return $request;
    }
}
