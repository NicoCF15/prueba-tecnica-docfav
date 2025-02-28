<?php

require_once '/var/www/html/vendor/autoload.php';
require_once '/var/www/html/src/config/env.config.php';

//__DIR__ .
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Doctrine\DBAL\DriverManager;

use Symfony\Component\Cache\Adapter\FilesystemAdapter;

// Configuración de la conexión a la base de datos
(new DotEnvEnvironment)->load(__DIR__ . '/../../');

$connectionOptions = [
    'driver' => getenv('DB_DRIVER'),
    'host' => getenv('DB_HOST'),    // Dirección de la base de datos
    'dbname' => getenv('DB_DATABASE'),  // Nombre de la base de datos
    'user' => getenv('DB_USERNAME'),      // Nombre de usuario
    'password' => getenv('DB_PASSWORD'),  // Contraseña de la base de datos
    'port' => getenv('DB_PORT'),         // Puerto (por defecto para MySQL) getenv('DB_PORT')
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
