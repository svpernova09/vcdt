REGISTRY := registry.phparch.com
CONTAINER := phparch/awesome-php
HASH := $(shell git rev-parse HEAD)
BUILD = DOCKER_BUILDKIT=1 docker build --build-arg HASH=$(HASH)

ifndef GITHUB_RUN
GITHUB_RUN=latest
endif

.DEFAULT_GOAL := setup

.PHONY: setup
setup:
	composer install # must be tab indent
	npm install
	npm run development
	mysql -u root -e "CREATE DATABASE IF NOT EXISTS app;"
	php artisan key:generate
	php artisan migrate

.PHONY: clean
clean:
	rm -rf vendor/
	rm -rf node_modules/

.PHONY: clean_db
clean_db:
	php artisan migrate:fresh
	php artisan db:seed

.PHONY: test
test:
	php vendor/bin/phpunit
	php vendor/bin/phpstan

.PHONY: deploy
deploy:
	php vendor/bin/envoy run deploy

.PHONY: cicd-setup
cicd-setup:
	composer install
	php artisan key:generate --ansi
	php artisan migrate --force
	php artisan db:seed --force
