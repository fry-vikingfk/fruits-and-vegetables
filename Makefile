#run this command to install everything from the scratch.
install: up db-reset db-test

init: up db-reset

up:
	docker compose up -d

down:
	symfony server:stop
	docker compose down

db-reset:
	symfony console doctrine:database:drop --force
	symfony console doctrine:database:create
	symfony console doctrine:migrations:migrate --no-interaction
	symfony console app:create-admin-user
	symfony console doctrine:fixtures:load --append

db-test:
	symfony console doctrine:database:create --env=test
	symfony console doctrine:schema:create --env=test