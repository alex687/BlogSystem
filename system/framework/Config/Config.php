<?php
namespace Config;

use Filesystem\FileSystem;

class Config
{
    private static $config = array();

    public static function loadAppConfig()
    {
        return self::loadConfigurationFile("app.php");
    }

    public static function loadDatabaseConfig()
    {
        return self::loadConfigurationFile("database.php");
    }

    public static function loadRoutes()
    {
        FileSystem::getRequireOnce(Paths::get("app") . '/config/' . "routes.php");
    }

    public static function loadConfigurationFile($fileName)
    {
        if (empty(self::$config[$fileName])) {
            self::$config[$fileName] = FileSystem::getRequire(Paths::get("app") . '/config/' . $fileName);
        }

        return self::$config[$fileName];
    }
}
