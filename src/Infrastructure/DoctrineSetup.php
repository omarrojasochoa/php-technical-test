<?php

namespace Orojaso\PhpTechnicalTest\Infrastructure;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\DriverManager;

 class DoctrineSetup
{
    public static function setup(): EntityManager
    {
        $paths = [__DIR__ . '/../Domain/Entities'];
        $isDevMode = true;
        $dbParams = [
            'driver' => 'pdo_mysql',
            'user' => 'cvphwudi_docfav',
            'password' => '!Docfav2025',
            'dbname' => 'cvphwudi_docfav',
            'host' => '204.93.224.158'
        ];

        $config = Setup::createAnnotationMetadataConfiguration(
            $paths, $isDevMode, null, null, false
        );
        $config->setQueryCacheImpl(new \Doctrine\Common\Cache\ArrayCache()); #optimizar consultas
        $entityManager = EntityManager::create($dbParams, $config);

        $platform = $entityManager->getConnection()->getDatabasePlatform();
        $platform->registerDoctrineTypeMapping('enum', 'string');

        return $entityManager;
    }
} 

