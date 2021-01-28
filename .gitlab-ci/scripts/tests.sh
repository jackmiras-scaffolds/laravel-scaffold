#!/bin/bash
set -euo pipefail
IFS=$'\n\t'

echo "################################################################################"
echo "# Running tests with coverage                                                  #"
echo "################################################################################"

./vendor/bin/pest --coverage --min=15
