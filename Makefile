install-n-start:
	make install
	make start
install:
	#запуск контейнера
	docker-compose up -d
	#установка зависимостей composer
	docker exec -it php-fpm-discount /bin/sh -c 'composer install'
	#остановка контейнера
	docker-compose stop
start:
	#запуск контейнера
	docker-compose up -d
stop:
	#остановка контейнера
	docker-compose stop