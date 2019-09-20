up:
	sudo docker-compose up

down:
	sudo docker-compose down

ps:
	sudo docker ps

build: perm
	sudo docker-compose up --build

php:
	sudo docker-compose exec php-fpm bash

perm:
	sudo chown ${USER}:${USER} bootstrap/cache -R
	sudo chown ${USER}:${USER} storage -R  && sudo chmod 777 -R storage

test:
	sudo docker-compose exec php-fpm vendor/bin/phpunit --colors=always

assets-install:
	sudo docker-compose exec node yarn install

assets-rebuild:
	sudo docker-compose exec node npm rebuild node-sass --force

assets-dev:
	sudo docker-compose exec node bash -c "cd /var/www && yarn run dev"

assets-prod:
	sudo docker-compose exec node bash -c "cd /var/www && yarn run prod"

assets-watch:
	sudo docker-compose exec node yarn run watch

assets-watch:
	sudo docker-compose exec node yarn run watch