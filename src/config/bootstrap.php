<?php

require_once '/var/www/html/vendor/autoload.php';
//__DIR__ .
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Doctrine\DBAL\DriverManager;

use Symfony\Component\Cache\Adapter\FilesystemAdapter;

// Configuración de la conexión a la base de datos
$connectionOptions = [
    'driver' => 'pdo_mysql',
    'host' => 'localhost',    // Dirección de la base de datos
    'dbname' => 'prueba_tecnica_docfav',  // Nombre de la base de datos
    'user' => 'usuario',      // Nombre de usuario
    'password' => 'MKdjWl$29#MD4&l5kw2?',  // Contraseña de la base de datos
    'port' => '7300',         // Puerto (por defecto para MySQL)
];

// Configuración de los metadatos de Doctrine (puede estar en archivos YAML, XML o Annotations)
$paths = ['/var/www/html/src/domain/model/entity'];  // Ruta donde se encuentran tus entidades
$isDevMode = true;  // Si estás en modo de desarrollo o producción

$cache = new FilesystemAdapter();

// Configura el tipo de metadatos que usarás (annotations es muy común)
$config = ORMSetup::createAttributeMetadataConfiguration(    
    paths: $paths,
    isDevMode: $isDevMode,
    cache: $cache
);

// configuring the database connection
$connection = DriverManager::getConnection([
    'driver' => 'pdo_mysql',
    'host' => 'mysql_db',    // Dirección de la base de datos (nombre del contenedor)
    'dbname' => 'prueba_tecnica_docfav',  // Nombre de la base de datos
    'user' => 'usuario_docfav',      // Nombre de usuario
    'password' => 'MKdjWl$29#MD4&l5kw2?',  // Contraseña de la base de datos
    'port' => '3306',         // Puerto (por defecto para MySQL)
], $config);

// Crear el EntityManager
$entityManager = new EntityManager($connection, $config);

return $entityManager;
