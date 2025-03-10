<?php

require_once "vendor/autoload.php";
use Orojaso\PhpTechnicalTest\Infrastructure\DoctrineSetup;

try {
    $entityManager = DoctrineSetup::setup();
    echo "Conexión exitosa a la base de datos";
} catch (Exception $e) {
    echo "Error de conexión: " . $e->getMessage();
}
