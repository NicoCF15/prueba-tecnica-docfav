# Prueba Técnica Docfav

Este es un proyecto utilizado como postulación para el puesto de desarrollador fullstack en Docfav

## Requisitos

- **Docker**

## Instalación

### 1. Clonar el repositorio

Primero, clona el repositorio en tu máquina local:

```bash
git clone https://github.com/NicoCF15/prueba-tecnica-docfav.git
```
Una vez clonado el proyecto renombra el archivo .env.example a .env

2. Ejecuta el script de instalación con el siguiente comando

```bash
./init-script.sh
```

3. Pruebas con PhpUnit
Para realizar las pruebas unitarias y de integración ejecuta el siguiente comando

```bash
docker compose exec php ./vendor/bin/phpunit --testdox -v Tests
```