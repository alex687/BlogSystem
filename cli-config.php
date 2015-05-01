<?php
use Doctrine\ORM\Tools\Console\ConsoleRunner;
$app = new App($fileLoader);

$app->bindPaths(require_once 'system/paths.php');

$db = new \Database\DatabaseSetup();
$entityManager = $db->setupDoctrineOrm(\Config\Config::loadDatabaseConfig());

return ConsoleRunner::createHelperSet($entityManager);
