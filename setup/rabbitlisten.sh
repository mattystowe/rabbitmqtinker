#!/bin/bash

echo "Starting RabbitMQ Listener"
docker exec -ti rabbitmqtinker_userservice_1 sh -c "php artisan rabbitmq:listen"
