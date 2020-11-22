start-dev: stop-dev
	docker-compose up -d
	docker-compose exec homescreen ln -f -s ../../app/assets api/public/assets
	docker-compose exec homescreen yarn --cwd app/ encore dev --watch

stop-dev:
	docker-compose down

start-prod:
	docker run -d --restart always --name=homescreen -e APP_ENV=prod -p 5000:80 stijink/homescreen:prod
	docker exec homescreen api/bin/console calendars:load --env=prod

stop-prod:
	docker stop homescreen
	docker rm homescreen

build-dev:
	docker-compose build
	docker-compose run --rm homescreen composer install --no-suggest --working-dir=api/
	docker-compose run --rm homescreen yarn --cwd app/ install

build-prod:
	docker-compose -f docker-compose.yml -f docker-compose.prod.yml build

calendars:
	docker exec homescreen api/bin/console calendars:load --env=prod

update:
	docker-compose run --rm homescreen composer update -o --no-suggest --with-dependencies --working-dir=api/
	docker-compose run --rm homescreen npm update --cwd app/ --prefix app/

logs:
	docker-compose logs --follow

lint:
	docker-compose run --rm homescreen composer validate --working-dir=api/
	docker-compose run --rm homescreen api/bin/console lint:container
	docker-compose run --rm homescreen api/bin/console lint:yaml api/config

clean-dev: stop-dev
	docker-compose run --rm homescreen rm -rf api/vendor/ api/var/ app/node_modules/
	docker rmi stijink/homescreen:dev

clean-prod:
	docker stop homescreen
	docker system prune -f
	docker rmi stijink/homescreen:prod

rebuild-prod:
	git pull
	sudo make clean-prod
	sudo make build-prod
