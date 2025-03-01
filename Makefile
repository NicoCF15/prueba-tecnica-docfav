up:
	docker-compose up -d

down:
	docker-compose down

migrate:
	docker-compose exec php vendor/bin/doctrine orm:schema-tool:update --force

test:
	docker-compose exec php vendor/bin/phpunit