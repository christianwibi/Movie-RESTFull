# Introduction
This application is created using laravel 9 and database mySQL, so make sure to install php version ^7.3 and prepare the setup below.

# Requirements
PHP ^7.3
composer
mySQL

# Setup
composer install
cp .env.example .env
php artisan migrate
php artisan serve (to run server)

# Tests
php artisan test

# Notes
Note for POST, PATCH, and DELETE methods require X-CSRF-TOKEN.
So if you hit it from external, need to add X-CSRF-TOKEN the in the header
add key X-CSRF-TOKEN
add value {TOKEN}
You can get TOKEN from API: 
GET http://127.0.0.1:8000/token