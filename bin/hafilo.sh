#!/bin/bash

php bin/console do:da:dr --force
php bin/console do:da:cr
php bin/console do:mi:mi --no-interaction
php bin/console ha:fi:lo --no-interaction
