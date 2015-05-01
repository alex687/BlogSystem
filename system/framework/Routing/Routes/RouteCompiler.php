<?php
namespace Routes;

class RouteCompiler implements RouteCompilerInterface
{
    const GET_PARAMETERS_ROUTE_TEMPLATE_REGEX = '#({[^ ]+})#';

    const ROUTE_PARAMETERS_REGEX = '([\d\w%]+){0,1}[/]{0,1}';

    public function compileTemplate($route, $frameworkParameters)
    {
        $routeParts = explode('/', $route);
        $regexArr = array();
        $templateParameters = array();
        foreach ($routeParts as $index => $r) {
            if (preg_match(self::GET_PARAMETERS_ROUTE_TEMPLATE_REGEX, $r)) {
                $regexArr[] = self::ROUTE_PARAMETERS_REGEX;

                $parameterName = substr($r, 1, strlen($r) - 2);
                $isRequired = $this->checkIsParameterRequired($parameterName, $frameworkParameters);
                $parameterInfo = array("name" => $parameterName, "isRequired" => $isRequired, "index" => $index);

                $templateParameters[] = $parameterInfo;
            } else {
                $regexArr[] = $r;
            }
        }

        $regex = "^";
        foreach ($regexArr as $r) {
            $regex .= $r;
            if ($r != '([\d\w%]+){0,1}[/]{0,1}' && $r != '([\d\w%]+){1}[/]{0,1}') {
                $regex .= '/';
            }
        }

        $routeTemplate = new RouteCompiled($regex, $templateParameters);
        return $routeTemplate;
    }

    private function checkIsParameterRequired($parameterName, $frameworkParameters)
    {
        if (substr($parameterName, -1) !== '?' && !in_array($parameterName, $frameworkParameters)) {
            return true;
        }

        return false;
    }
}
