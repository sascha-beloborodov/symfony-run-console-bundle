#!/usr/bin/env bash

php_tag='8.1.10-cli'

sudo docker run --rm -it \
    --user $(id -u):$(id -g) \
    --volume $PWD:/app \
    -w "/app" \
    php:${php_tag} vendor/bin/phpunit --bootstrap vendor/autoload.php --testdox tests/
