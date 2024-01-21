COLOR_RESET = \033[0m
COLOR_INFO = \033[32m
COLOR_COMMENT = \033[33m
COLOR_HELP = \033[1;34m
COLOR_BOLD = \033[1m

CONTAINER_APP_NAME = php

PROJECT_NAME = Frankentest
PROJECT_DESCRIPTION = Frankentest

SHELL := /bin/bash
CWD := $(shell cd -P -- '$(shell dirname -- "$0")' && pwd -P)
AWS_PROFILE := default
AWS_REPOSITORY := 946241444896.dkr.ecr.eu-west-1.amazonaws.com
UID := $(shell id -u)
GID := $(shell id -g)

.DEFAULT_GOAL := help

##@ Helpers

.PHONY: help
help: ## Display help
	@awk 'BEGIN {FS = ":.*##"; printf "${COLOR_HELP}${PROJECT_NAME}${COLOR_RESET}\n${PROJECT_DESCRIPTION}\n\nUsage:\n make ${COLOR_HELP}<target>${COLOR_RESET}\n"} /^[a-zA-Z_-]+:.*?##/ { printf " ${COLOR_HELP}%-30s${COLOR_RESET} %s\n", $$1, $$2 } /^##@/ { printf "\n${COLOR_BOLD}%s${COLOR_RESET}\n", substr($$0, 5) } ' $(MAKEFILE_LIST)

.PHONY: initialize
initialize: ## Initialize this project
	docker compose build $(CONTAINER_APP_NAME) --build-arg UID=$(UID) --build-arg GID=$(GID) --no-cache

.PHONY: start
start: ## Start this project
	docker compose up $(CONTAINER_APP_NAME) --pull always -d --wait

.PHONY: down
down: ## Stop this project
	docker compose down $(CONTAINER_APP_NAME) --remove-orphans

.PHONY: stop
stop: ## Stop this project
	docker compose stop $(CONTAINER_APP_NAME)

.PHONY: sh
sh: ## Takes you inside the container
	docker compose exec $(CONTAINER_APP_NAME) sh

##@ Packages

.PHONY: composer-install
composer-install: ## Install Composer dependencies
	docker compose exec -e "COMPOSER_MEMORY_LIMIT=-1" $(CONTAINER_APP_NAME) composer install

.PHONY: composer-update
composer-update: ## Update Composer dependencies
	docker compose exec -e "COMPOSER_MEMORY_LIMIT=-1" $(CONTAINER_APP_NAME) composer update

.PHONY: composer-validate
composer-validate: ## Validate composer.json and composer.lock
	docker compose exec -e "COMPOSER_MEMORY_LIMIT=-1" $(CONTAINER_APP_NAME) composer validate --no-check-lock --strict composer.json
