#!/bin/bash

echo "API Service Tests"
cd apiservice
vendor/bin/phpunit
#
echo "User Service Tests"
cd ../userservice
vendor/bin/phpunit
cd ../
#
