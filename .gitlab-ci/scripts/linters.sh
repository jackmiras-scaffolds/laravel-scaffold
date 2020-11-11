#!/bin/bash
set -euo pipefail
IFS=$'\n\t'

echo "################################################################################"
echo "# PHP_CodeSniffer                                                              #"
echo "################################################################################"

./vendor/bin/phpcs \
	--colors \
	--runtime-set ignore_warnings_on_exit true \
	--standard=phpcs.xml app/ routes/ config/ database/

echo "################################################################################"
echo "# PHP Mess Detector                                                            #"
echo "################################################################################"

./vendor/bin/phpmd app/ ansi phpmd.xml
./vendor/bin/phpmd config/ ansi phpmd.xml
./vendor/bin/phpmd routes/ ansi phpmd.xml
./vendor/bin/phpmd database/ ansi phpmd.xml

echo "################################################################################"
echo "# Larastan                                                                     #"
echo "################################################################################"

./vendor/bin/phpstan analyse --memory-limit=2G