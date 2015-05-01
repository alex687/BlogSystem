<?php
namespace Routing;

class Route
{
    private static $routeTemplates = array();

    public static function create($route, $defaults)
    {
        self::$routeTemplates[$route] = $defaults;
    }

    public static function getAllRoutes()
    {
        return self::$routeTemplates;
    }
}
