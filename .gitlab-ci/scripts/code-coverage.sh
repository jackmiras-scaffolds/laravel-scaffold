#!/bin/bash
set -euo pipefail
IFS=$'\n\t'

echo "################################################################################"
echo "# Generating Code Coverage                                                     #"
echo "################################################################################"

./vendor/bin/phpunit --coverage-html tests/Coverage/

readonly CODE_COVERAGE="$(cat tests/Coverage/index.html | grep -A 2 Total | tail -1 | awk '{print substr($0,80,8)}')"

printf "\nCode coverage percentage: "
echo ${CODE_COVERAGE//[!0-9.]/}