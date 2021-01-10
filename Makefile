.PHONY: installNoDev installWithDev e2e

-include config.mk

installNoDev:
	composer install -o --prefer-dist --no-dev

installWithDev:
	composer install -o --prefer-dist

e2e: installWithDev
	XDEBUG_MODE=coverage ./vendor/bin/phpunit -c e2e-test/phpunit.xml --coverage-text
