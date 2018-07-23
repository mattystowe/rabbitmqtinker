#!/bin/bash

echo "API Service Tests"
docker exec -ti rabbitmqtinker_app_1 sh -c "vendor/bin/phpunit"
#
echo "User Service Tests"
docker exec -ti rabbitmqtinker_userservice_1 sh -c "vendor/bin/phpunit"
#cd ../
#
