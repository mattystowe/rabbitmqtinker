#!/bin/bash

echo "Building Services"
docker-compose build
docker-compose up -d
#
echo "API Service Composer Install"
docker exec -ti rabbitmqtinker_app_1 sh -c "php composer.phar install --prefer-source --no-interaction"
#
echo "User Service Composer Install"
docker exec -ti rabbitmqtinker_userservice_1 sh -c "php composer.phar install --prefer-source --no-interaction"
#
echo "Copy ENV to projects"
cp apiservice/.env.example apiservice/.env
cp userservice/.env.example userservice/.env
#
echo "SetupDB and Run Migrations"
docker exec -ti rabbitmqtinker_userservice_1 sh -c "php artisan migrate:install"
docker exec -ti rabbitmqtinker_userservice_1 sh -c "php artisan migrate --seed"
#
echo "==============================="
echo "==============================="
echo "==============================="
echo "STARTED - Visit http://localhost:3000/getUser/1"

docker exec -ti rabbitmqtinker_userservice_1 sh -c "php artisan rabbitmq:listen"
