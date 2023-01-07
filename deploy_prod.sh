#!/bin/sh -l

composer install --optimize-autoloader --no-dev

npm install
npm run build

php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan migrate
php artisan queue:restart
