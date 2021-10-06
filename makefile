.PHONY: build

start: stop
	docker-compose up -d
	docker-compose exec homescreen ln -f -s ../../app/assets api/public/assets
	docker-compose exec homescreen yarn --cwd app/ encore dev --watch

stop:
	docker-compose down

build:
	docker-compose build
	docker-compose run --rm homescreen composer install --working-dir=api/
	docker-compose run --rm homescreen yarn --cwd app/ install

calendars:
	docker exec homescreen api/bin/console calendars:load --env=prod

update:
	docker-compose run --rm homescreen composer update -o --with-dependencies --working-dir=api/
	docker-compose run --rm homescreen yarn upgrade --cwd app/ --prefix app/

logs:
	docker-compose logs --follow

lint:
	docker-compose run --rm homescreen composer validate --working-dir=api/
	docker-compose run --rm homescreen api/bin/console lint:container
	docker-compose run --rm homescreen api/bin/console lint:yaml api/config

ractor:
	docker-compose run --rm homescreen vendor/bin/rector process src/ --debug

clean: stop
	docker-compose run --rm homescreen rm -rf api/vendor/ api/var/ app/node_modules/
	docker rmi stijink/homescreen:dev
