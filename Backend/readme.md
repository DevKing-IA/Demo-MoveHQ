# Demo-MoveHQ application backend
This is the backend package for the demo application
It is using Laravel 8 and PHP 8.

## Setup
1) First, you need to create the application database. In this project, I am using MySQL database. So please create the database named `movehq_demo`.
In case you want to create the database for phpunit testing, maybe you will need to create one more database named `movehq_demo_test`.
2) Copy `.env.example` to `.env` & `.env.testing` and edit as needed (add DB connection details etc)
2) Run `composer install --ignore-platform-reqs`
3) Run `php artisan db:seed` - This will insert some test data to the database
4) Run `PHP artisan server` or `composer serve:app`
5) Backend should be available here: http://localhost:3005/

## Tests
- In backend root directory run `.\vendor\bin\phpunit --testdox` - This will run the test cases
- You can run each test case using like this `.\vendor\bin\phpunit --testdox .\tests\Controllers\AdminApi\ProductTest.php`