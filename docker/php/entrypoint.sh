#!/bin/sh
set -e

composer install

bin/console d:s:d --force
bin/console d:s:c
bin/console app:load-fixtures

exec "$@"
