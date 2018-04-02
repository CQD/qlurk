.PHONY: installNoDev installWithDev e2e

installNoDev:
	composer install -o --prefer-dist --no-dev

installWithDev:
	composer install -o --prefer-dist

e2e: installWithDev
	./vendor/bin/phpunit -c e2e-test/phpunit.xml --coverage-text
