<?php

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/env.config.php';

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
    'port' => '3306',         // Puerto (por defecto para MySQL) getenv('DB_PORT')
];

// Configuración de los metadatos de Doctrine (puede estar en archivos YAML, XML o Annotations)
$paths = [__DIR__ . '/../Domain/Model/Entity/'];  // Ruta donde se encuentran tus entidades
$isDevMode = true;  // Si estás en modo de desarrollo o producción

$cache = new FilesystemAdapter();

// Configura el tipo de metadatos que usarás (annotations es muy común)
$config = ORMSetup::createAttributeMetadataConfiguration(    
    paths: $paths,
    isDevMode: $isDevMode,
    cache: $cache
);

// configuring the database connection
$connection = DriverManager::getConnection($connectionOptions, $config);

// Crear el EntityManager
$entityManager = new EntityManager($connection, $config);

return $entityManager;
