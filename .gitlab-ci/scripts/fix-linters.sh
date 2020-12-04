#!/bin/bash
set -euo pipefail
IFS=$'\n\t'

echo "################################################################################"
echo "# PHP CS Fixer                                                                 #"
echo "################################################################################"

./vendor/bin/php-cs-fixer fix app
./vendor/bin/php-cs-fixer fix routes
./vendor/bin/php-cs-fixer fix config
./vendor/bin/php-cs-fixer fix database