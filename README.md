# README #
This repository contains the source code for Laravel 10 with Docker.

## Note for GIT
* Please help apply GitFlow for this repository (https://danielkummer.github.io/git-flow-cheatsheet).
* Example:
  - Name for any features -> `feature/xxx-yyy`. Ex: `feature/implement-login-ui`
  - Name for any bugs -> `bug-fixes/xxx-yyy`. Ex: `bug-fixes/wrong-message-when-login`

* When you create a name for the Pull Request, please help set a meaningful name and set description if needed. Should capitalize the first letter and do not use special characters.

## Tech stacks
- PHP 8.1.x
- Laravel 10.x
- NodeJS 16.20.x
- NPM 8.19.x

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

- Host: http://localhost

### PHP scripts
_Make sure the web service is running_

#### Start bash shell in the specified directory
```
docker-compose exec web bash -c "cd /var/www/html/ && bash"
```

#### Installation dependencies
```
composer install
```

#### Generation APP_KEY
```
php artisan key:generate
```

#### Re-configuring cache
```
php artisan config:cache
```

#### Migration DB
```
php artisan migrate
```

## Author
* Name: Tuan Le
* Email: tuanle29.dev@gmail.com
