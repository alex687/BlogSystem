<?php

namespace Database;

use Config\Paths;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

class DatabaseSetup
{
    public function setupDoctrineOrm($dbConfiguration)
    {
        $config = Setup::createAnnotationMetadataConfiguration(array(Paths::get("app") . "models/"), true);
        $entityManager = EntityManager::create($dbConfiguration, $config);

        return $entityManager;
    }
}
