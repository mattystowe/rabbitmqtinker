#!/bin/bash

echo "API Service Composer Install"
cd apiservice
php composer install
#
echo "User Service Composer Install"
cd ../userservice
php composer install
cd ../
#
echo "Copy ENV to projects"
cp apiservice/.env.example apiservice/.env
cp userservice/.env.example userservice/.env
#
echo "Building Services"
docker-compose build
docker-compose up -d
