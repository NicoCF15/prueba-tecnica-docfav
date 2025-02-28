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

        echo "Los contenedores se han levantado correctamente."
        echo "Accede al servidor PHP en http://localhost:8000"

    else
        echo "Hubo un error al levantar los contenedores."
        exit 1
    fi

    echo "Esperando a los contenedores"
    sleep 15;

    # Esperar hasta que la base de datos esté accesible
    #docker-compose exec -T php bash -c "until mysql -h db -u ${DB_USERNAME} -p${DB_PASSWORD} -e 'select 1'; do echo 'Esperando MySQL...'; sleep 5; done"

    #create test db
    docker compose exec db mysql -uroot  -p"$DB_ROOT_PASSWORD" -e "CREATE DATABASE IF NOT EXISTS $DB_TEST_DATABASE"
    
    #Create database schema
    docker compose exec php vendor/bin/doctrine orm:schema-tool:update --force --complete

else
    echo "El archivo docker-compose.yml no se encuentra en este directorio."
    exit 1
fi
