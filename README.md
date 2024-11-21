# README #
This repository contains the source code for Laravel 10 with Docker. It includes running the source code by Nginx, using Cronjob, and using pre-commit to automatically check code syntax and formatting.

## Note for GIT
* Please help apply GitFlow for this repository (https://danielkummer.github.io/git-flow-cheatsheet).
* Example:
  - Name for any features -> `feature/xxx-yyy`. Ex: `feature/implement-login-ui`
  - Name for any bugs -> `bug-fixes/xxx-yyy`. Ex: `bug-fixes/wrong-message-when-login`

* When you create a name for the Pull Request, please help set a meaningful name and set description if needed. Should capitalize the first letter and do not use special characters.

## Tech stacks
- PHP 8.2.x
- Laravel 10.x

## Prerequisite

- Docker
- Docker compose

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
_Make sure the web service is running_

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

## Author
* Name: Tuan Le
* Email: tuanle29.dev@gmail.com
