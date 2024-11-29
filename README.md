# README #
This repository contains the source code for Laravel 10 with Docker. It includes running the source code by Nginx, using Cronjob, and using pre-commit to automatically check code syntax and formatting and more [features](#features).

## Note for GIT
* Please help apply GitFlow for this repository (https://danielkummer.github.io/git-flow-cheatsheet).
* Example:
  - Name for any features -> `feature/xxx-yyy`. Ex: `feature/implement-login-ui`
  - Name for any bugs -> `bug-fixes/xxx-yyy`. Ex: `bug-fixes/wrong-message-when-login`

* When you create a name for the Pull Request, please help set a meaningful name and set description if needed. Should capitalize the first letter and do not use special characters.

## Tech stacks
- PHP 8.2.x
- Laravel 10.x

## Your machine's prerequisites

- Docker
- Docker compose
- Node.js 20.18.x or other Node.js version

## Getting started

### Setting environment
```
cp .env.example .env
```

### Installation
```
docker-compose build
```

### Running
```
docker-compose up
```

- Host: http://localhost:8000

### Steps build
_Make sure the laravel10-app service is running_

#### Start bash shell
```
docker exec -it laravel10-app sh
```

#### Installation PHP's dependencies
```
composer install
```

#### Generation APP_KEY
```
php artisan key:generate
```

#### Migration DB
```
php artisan migrate
```

#### Exit bash shell
```
exit
```

### To use pre-commit
_Make sure you have Node.js installed on your machine_

#### Installation Node's modules. _(This is necessary to use pre-commit and more)_
```
npm install
```

## Features
* Export Excel file by template
  - Endpoint: http://localhost:8000/exports/excel
  - Controller: `app/Http/Controllers/Web/ExportController.php`

## Author
* Name: Tuan Le
* Email: tuanle29.dev@gmail.com
