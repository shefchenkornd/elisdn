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
	sudo docker exec app_php-fpm_1 vendor/bin/phpunit --colors=always

assets-install:
	sudo docker exec app_node_1 yarn install

assets-dev:
	sudo docker exec app_node_1 bash -c "cd /var/www && yarn run dev"

assets-watch:
	sudo docker exec app_node_1 yarn run watch