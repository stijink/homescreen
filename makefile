start: stop
	docker-compose up -d

stop:
	docker-compose down

start-prod: stop-prod
	docker run -d --restart always --name=homescreen -e APP_ENV=prod -p 5000:80 stijink/homescreen:prod

stop-prod:
	docker stop homescreen
	docker rm homescreen

build-dev:
	docker-compose build
	docker-compose run --rm homescreen composer install --no-suggest --working-dir=api/
	docker-compose run --rm homescreen npm install --cwd app/ --prefix app/

build-prod:
	docker-compose -f docker-compose.yml -f docker-compose.prod.yml build

calendars:
	docker exec homescreen api/bin/console calendars:load --env=prod

update:
	docker-compose run --rm homescreen composer update -o --no-suggest --with-dependencies --working-dir=api/
	docker-compose run --rm homescreen npm update --cwd app/ --prefix app/

logs:
	docker-compose logs --follow

clean: stop
	docker-compose run --rm homescreen rm -rf api/vendor/ api/var/ app/node_modules/