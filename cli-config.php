<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;

require_once 'vendor/autoload.php';  

use Orojaso\PhpTechnicalTest\Infrastructure\DoctrineSetup;

$entityManager = DoctrineSetup::setup();

// Devuelve el helper set para la consola
return ConsoleRunner::createHelperSet($entityManager);
