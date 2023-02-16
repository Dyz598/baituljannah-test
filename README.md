# Baituljannah Test Solution

Postman is in the root folder.

## Requirements

- PHP 8.1
- PostgreSQL for database connection.
- Redis for queue but can also use database connection.

## How to install

- Install dependencies `composer install`.
- Copy `.env.example` to `.env` and setup database and queue connection.
- Migrate tables to database `php artisan migrate`.

## How to run

- Run locally using `php artisan serve`.
- Run queue worker `php artisan queue:work`.
- Run `php artisan test --coverage-html reports/` to get latest unit test coverage.
