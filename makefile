build-dev: stop config docker-build install-dev start-dev

build-prod: stop config docker-build install-prod build-app start-prod calendars

docker-build:
	docker-compose build

docker-rebuild:
	docker pull php:7.3-apache
	docker pull node:9
	docker-compose build --nocache

start-dev: stop
	docker-compose up -d

start-prod: start-dev
	# We do not need a running instance of the app
	docker-compose stop app

stop:
	docker-compose down --remove-orphans
	docker-compose rm --force

clean: stop
	rm -rf api/var/*
	rm -rf api/vendor
	rm -rf app/node_modules

config:
	-cp -n .env.dist .env
	-cp -n api/config/config.dist.json api/config/config.json

build-app:
	docker-compose run --rm app node_modules/webpack/bin/webpack.js -p

tail-logs:
	docker-compose logs --follow

install-dev:
	docker-compose run --rm api composer install --no-suggest
	docker-compose run --rm app yarn install

install-prod:
	docker-compose run --rm -e APP_ENV=prod api composer install --classmap-authoritative --no-dev --no-suggest
	docker-compose run --rm app yarn install

update:
	docker-compose run --rm api composer update --with-dependencies
	docker-compose run --rm app yarn update

require:
	docker-compose run --rm api composer require

require-dev:
	docker-compose run --rm api composer require --dev

calendars:
	docker-compose run --rm -e APP_ENV=prod api bin/console calendars:load

php-cs-fixer:
	docker-compose run --rm api vendor/bin/php-cs-fixer fix --verbose

php-stan:
	docker-compose run api vendor/bin/phpstan analyse src/ --level 7

test:
	docker-compose run --rm -e APP_ENV=test api vendor/bin/phpunit --debug
