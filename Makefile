# Nama file docker-compose default
COMPOSE_FILE=docker-compose.yml
SERVICE=app

up:
	docker compose -f $(COMPOSE_FILE) up -d

stop:
	docker compose -f $(COMPOSE_FILE) stop 

down:
	docker compose -f $(COMPOSE_FILE) down

restart:
	docker compose -f $(COMPOSE_FILE) down
	docker compose -f $(COMPOSE_FILE) up -d

build:
	docker compose -f $(COMPOSE_FILE) build

logs:
	docker compose -f $(COMPOSE_FILE) logs -f

ps:
	docker compose -f $(COMPOSE_FILE) ps

bash:
	docker compose -f $(COMPOSE_FILE) exec $(SERVICE) bash

sh:
	docker compose -f $(COMPOSE_FILE) exec $(SERVICE) sh

composer-install:
	docker compose -f $(COMPOSE_FILE) exec $(SERVICE) composer install

artisan:
	docker compose -f $(COMPOSE_FILE) exec $(SERVICE) php artisan

migrate:
	docker compose -f $(COMPOSE_FILE) exec $(SERVICE) php artisan migrate

seed:
	docker compose -f $(COMPOSE_FILE) exec $(SERVICE) php artisan db:seed

key-generate:
	docker compose -f $(COMPOSE_FILE) exec $(SERVICE) php artisan key:generate

fresh:
	docker compose -f $(COMPOSE_FILE) exec $(SERVICE) php artisan migrate:fresh --seed

