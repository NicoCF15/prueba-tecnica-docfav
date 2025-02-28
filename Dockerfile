# Usar la imagen base de PHP
FROM php:8.1-cli

# Instalar dependencias para Composer y Doctrine
RUN apt-get update && apt-get install -y \
    libxml2-dev \
    libzip-dev \
    unzip \
    git \
    curl \
    && rm -rf /var/lib/apt/lists/*

# Instalar las extensiones de PHP necesarias
RUN docker-php-ext-install pdo pdo_mysql zip

WORKDIR /var/www/html

# Exponer el puerto 80 para servir PHP (si usas un servidor web como Apache o Nginx)
EXPOSE 80

# Comando predeterminado para ejecutar PHP
#CMD ["php", "-S", "0.0.0.0:80", "-t", "/var/www/html"]
