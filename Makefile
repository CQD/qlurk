.PHONY: e2e

-include config.mk

e2e: vendor/autoload.php
	./vendor/bin/phpunit -c e2e-test/phpunit.xml

vendor/autoload.php:
	composer install

