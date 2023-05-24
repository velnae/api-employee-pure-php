#!/bin/bash
DOCKER_COMPOSE_PATH = .docker
DOCKER_COMPOSE_FILE = ${DOCKER_COMPOSE_PATH}/docker-compose.yml

 ifneq (,$(wildcard ${DOCKER_COMPOSE_PATH}/.env))
    include ${DOCKER_COMPOSE_PATH}/.env
    export
endif

DOCKER_PHP = ${APP_NAME}-php

UID = $(shell id -u)

help: ## Show this help message
	@echo 'Welcome to ${APP_NAME} make'
	@echo 'usage: make [target]'
	@echo
	@echo 'targets:'
	@egrep '^(.+)\:\ ##\ (.+)' ${MAKEFILE_LIST} | column -t -c 2 -s ':#'

run: ## Start the containers
	docker network create default-network || true
	U_ID=${UID} docker compose --project-directory=${DOCKER_COMPOSE_PATH} --file ${DOCKER_COMPOSE_FILE} up
	@echo 'GO TO : http://localhost:8080/person.php'

stop: ## Stop the containers
	U_ID=${UID} docker compose --project-directory=${DOCKER_COMPOSE_PATH} --file ${DOCKER_COMPOSE_FILE} stop

restart: ## Restart the containers
	$(MAKE) stop && $(MAKE) run

rebuild: ## Rebuilds all the containers
	U_ID=${UID} docker compose --project-directory=${DOCKER_COMPOSE_PATH} --file ${DOCKER_COMPOSE_FILE} build

prepare: ## Runs backend commands
	cd ${DOCKER_PATH}/ && $(MAKE) composer-install

# Backend commands
composer-install: ## Installs composer dependencies
	U_ID=${UID} docker exec --user ${UID} -it ${DOCKER_PHP} composer install --no-scripts --no-interaction --optimize-autoloader

be-logs: ## Tails the Symfony dev log
	U_ID=${UID} docker exec -it --user ${UID} ${DOCKER_PHP} tail -f var/log/dev.log
# End backend commands

ssh-php: ## ssh's into the be container
	U_ID=${UID} docker exec -it --user ${UID} ${DOCKER_PHP} bash

code-style: ## Runs php-cs to fix code styling following Symfony rules
	cd ${DOCKER_PATH}/ && U_ID=${UID} docker exec -it --user ${UID} ${DOCKER_PHP} php-cs-fixer fix src --rules=@Symfony