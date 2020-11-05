ifndef u
u:=sotatek
endif

ifndef env
env:=dev
endif

OS:=$(shell uname)

docker-restart:
	docker-compose down
	make docker-start
	make docker-init-db-full
	make docker-link-storage

docker-start:
	docker-compose up -d

docker-connect: 
	docker exec -it nekoringo-api ash

docker-init-db-full:
	docker exec -it nekoringo-api make init-db-full

docker-link-storage:
	docker exec -it nekoringo-api php artisan storage:link

init-db-full:
	make autoload
	php artisan migrate:fresh
	make update-master
	php artisan db:seed

init-app:
	cp .env.example .env
	composer install
	php artisan key:generate
	php artisan jwt:secret
	php artisan migrate
	php artisan db:seed
	php artisan storage:link
	npm install && npm run dev

build:
	npm run dev

watch:
	npm run watch

autoload:
	composer dump-autoload

route:
	php artisan route:list
