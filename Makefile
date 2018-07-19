docker-up:
	sudo docker-compose up

docker-down:
	sudo docker-compose down

docker-build: perm
	sudo docker-compose up --build

perm:
	sudo chown ${USER}:${USER} bootstrap/cache -R
	sudo chown ${USER}:${USER} storage -R

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