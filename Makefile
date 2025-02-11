#run this command to install everything from the scratch.
install: up composer-install db-reset db-test

init: down up db-reset db-test

up:
	docker compose up -d
	symfony console cache:clear

down:
	docker compose down

db-reset: up
	symfony console doctrine:database:drop --force
	symfony console doctrine:database:create
	symfony console doctrine:migrations:migrate --no-interaction
	symfony console app:persist-json-file

db-test:
	symfony console doctrine:database:drop --force --env=test
	symfony console doctrine:database:create --env=test
	symfony console doctrine:schema:create --env=test
	symfony php vendor/bin/phpunit --testdox

composer-install:
	composer install