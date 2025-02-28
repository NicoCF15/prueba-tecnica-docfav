#!/bin/bash

# Verify if the system have docker and docker-compose
if  ! command -v docker &> /dev/null || ! (command -v docker-compose &> /dev/null || command -v docker compose &> /dev/null)
then
    echo "Docker y/o Docker Compose no están instalados. Instala ambos para continuar."
    exit 1
fi

# Cargar variables desde el archivo .env
if [ -f .env ]; then
    source .env
else
    echo "Archivo .env no encontrado"
    exit 1
fi

# docker-compose.yml path
DOCKER_COMPOSE_FILE="docker-compose.yml"

# Verify if docker-compose.yml exists
if [ -f "$DOCKER_COMPOSE_FILE" ]; then    
    # Execute docker compose in detached mode
    docker compose up -d
    
    # Verify command execution
    if [ $? -eq 0 ]; then
        echo ${DB_HOST}
        # Nombre del contenedor MySQL
        DB_CONTAINER="db"
        # Nombre del contenedor PHP
        PHP_CONTAINER="php"

        # Verificar si el contenedor MySQL está corriendo
        if ! docker compose ps -q $DB_CONTAINER > /dev/null; then
        echo "El contenedor MySQL no está corriendo. Por favor, asegúrate de que Docker Compose esté activo."
        exit 1
        fi

        # Esperar a que MySQL esté listo para aceptar conexiones
        echo "Esperando a que MySQL esté listo para aceptar conexiones..."
        until docker compose exec $DB_CONTAINER mysql -u root -p'MKdjWl$29#MD4&l5kw2?' -e "SELECT 1" > /dev/null 2>&1; do
        echo "Esperando..."
        sleep 2
        done

        #Create database schema
        docker compose exec php vendor/bin/doctrine orm:schema-tool:update --force --complete

        #create test db
        docker compose exec db mysql -u root -p'MKdjWl$29#MD4&l5kw2?' -e "CREATE DATABASE IF NOT EXISTS prueba_tecnica_docfav_test"

        echo "Los contenedores se han levantado correctamente."
        echo "Accede al servidor PHP en http://localhost:8000"

    else
        echo "Hubo un error al levantar los contenedores."
        exit 1
    fi
else
    echo "El archivo docker-compose.yml no se encuentra en este directorio."
    exit 1
fi
