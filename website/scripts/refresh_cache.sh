#!/usr/bin/env bash

php -d memory_limit=-1 artisan cache:clear
php -d memory_limit=-1 artisan config:clear
php -d memory_limit=-1 artisan config:cache
php -d memory_limit=-1 artisan route:clear
php -d memory_limit=-1 artisan route:cache

APP_URL=$(grep APP_URL .env | cut -d '=' -f2)
APP_ENV=$(grep APP_ENV .env | cut -d '=' -f2)
