# Introduction
This application is created using laravel 8.75 and database mySQL, so make sure to install php version ^7.3 and prepare the setup below.

# Requirements
PHP ^7.3<br/>
composer<br/>
mySQL (with db name xsis)

# Setup
git clone https://github.com/christianwibi/Movie-RESTFull.git<br/>
cd Movie-RESTFull<br/>
composer install<br/>
cp .env.example .env<br/>
php artisan migrate<br/>
php artisan serve (to run server)

# Tests
php artisan test

# Notes
Note for POST, PATCH, and DELETE methods require X-CSRF-TOKEN.
So if you hit it from external, need to add X-CSRF-TOKEN the in the header: <br/>
add key X-CSRF-TOKEN<br/>
add value {TOKEN}<br/>
You can get TOKEN by hit API: 
GET http://127.0.0.1:8000/token