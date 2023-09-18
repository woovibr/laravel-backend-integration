# laravel-backend-integration

Pix integration example using the [OpenPix](https://openpix.com.br/) platform and Laravel framework. Check our documentation at [OpenPix Developers](https://developers.openpix.com.br/).

This is a simple donation application that demonstrates the process of creating charges, updating donation statuses in real-time via webhooks when a charge is paid, integration with our [PHP SDK](https://github.com/Open-Pix/php-sdk), and more.

## Pre-requisites

- Generate a [App ID](https://developers.openpix.com.br/docs/plugin/app-id) in your OpenPix Account.
- Have Docker or Composer and MySQL installed.

## How to run

### Laravel Sail / Docker (recommended way)

Our application has a [Laravel Sail](https://laravel.com/docs/10.x/sail) configuration available, providing an interface to interact seamlessly with Docker in Laravel applications.

Follow the steps below to use Docker via Sail:

- Have [Docker Compose](https://docs.docker.com/compose/install/) installed.
- Clone the repository: `git clone https://github.com/Open-Pix/laravel-backend-integration`
- Go to repository directory: `cd laravel-backend-integration`
- [Install Composer dependencies with Sail](https://laravel.com/docs/10.x/sail#installing-composer-dependencies-for-existing-projects):
```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs
```
- Copy `.env.example` to `.env`: `cp .env.example .env`
- Configure your AppID in `.env` file.
- Start the services (server, database and so on.): `./vendor/bin/sail up -d`
- Generate a key: `./vendor/bin/sail art key:generate`
- Run the migrations: `./vendor/bin/sail art migrate`
- [Make sure changes to the `.env` file take effect by clearing the cache:](https://laravel.com/docs/10.x/configuration#configuration-caching): `php artisan config:clear`

### PHP

Having [Composer](https://getcomposer.org) and PHP `>=8.2.0` installed directly on your machine, follow the steps:

- Clone the repository: `git clone https://github.com/Open-Pix/laravel-backend-integration`
- Go to repository directory: `cd laravel-backend-integration`
- Install Composer dependencies: `composer install`
- Copy `.env.example` to `.env`: `cp .env.example .env`
- Generate a key: `php artisan key:generate`
- Run the migrations: `php artisan migrate`
- Start the server: `php artisan serve`
- Configure your AppID in `.env` file.

## How to access the web app

By default, web app runs at http://0.0.0.0
