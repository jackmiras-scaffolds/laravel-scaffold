#!/bin/bash
set -euo pipefail
IFS=$'\n\t'

echo "################################################################################"
echo "# PHP_CodeSniffer                                                              #"
echo "################################################################################"

echo "" && ./vendor/bin/phpcs \
	--cache \
	--colors \
	--extensions=php \
	--warning-severity=0 \
	--runtime-set ignore_warnings_on_exit true \
	--standard=phpcs.xml app/ routes/ config/ database/

echo $'\n################################################################################'
echo "# PHP Mess Detector                                                            #"
echo "################################################################################"

./vendor/bin/phpmd app/ ansi phpmd.xml
./vendor/bin/phpmd config/ ansi phpmd.xml
./vendor/bin/phpmd routes/ ansi phpmd.xml
./vendor/bin/phpmd database/ ansi phpmd.xml && echo ""