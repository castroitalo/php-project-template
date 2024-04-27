# App

App description

### Creating development environment

- Pre-requisites:
  - [Docker](https://www.docker.com/) installed.
- Building the project's docker image:
  - `docker build . -t app:v1.0`
- Creating a development container:
  - `docker compose up -d`
- Installing dependencies:
  - `docker container exec -it app-app-1 bash`
  - Go the the root directory (**/var/www/html**) and type: `composer install`
  - Create a **.env** file based on **.env.template** file.
- Now it's already possible to run the development version: `https://localhost`

### Project template overview

Pre installed packages:
- [vlucas/phpdotenv](https://packagist.org/packages/vlucas/phpdotenv)
- [league/plates](https://packagist.org/packages/league/plates)
- [castroitalo/echoquery](https://packagist.org/packages/castroitalo/echoquery)

### Testing

To run tests use the composer scripts:

```shell
composer run tests
```

To run individual test we also use the composer scripts:

```shell
composer run route_tests
```
