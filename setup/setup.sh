#!/bin/bash

echo "API Service Composer Install"
cd apiservice
composer install
#
echo "User Service Composer Install"
cd ../userservice
composer install
cd ../
#
echo "Copy ENV to projects"
cp apiservice/.env.example apiservice/.env
cp userservice/.env.example userservice/.env
#
echo "Building Services"
docker-compose build
docker-compose up -d
#
echo "SetupDB and Run Migrations"
#docker exec -ti rabbitmqtinker_userservice_1 sh -c "php artisan migrate:install"
docker exec -ti rabbitmqtinker_userservice_1 sh -c "php artisan migrate --seed"
