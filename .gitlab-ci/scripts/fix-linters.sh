#!/bin/bash
set -euo pipefail
IFS=$'\n\t'

echo "################################################################################"
echo "# PHP CBF                                                                      #"
echo "################################################################################"

./vendor/bin/phpcbf --colors --standard=phpcs.xml app/ routes/ config/ database/