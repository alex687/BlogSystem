<?php

namespace Config;

class Paths
{
    private static $paths;

    public static function get($name)
    {
        return self::$paths[$name];
    }

    public static function setPaths($paths)
    {
        self::$paths = $paths;
    }
}
