composer_bin = /usr/local/bin/composer
phpunit_bin = /usr/local/bin/phpunit

composer:
	curl -L http://getcomposer.org/composer.phar -o composer && chmod +x composer && mv composer $(composer_bin)

install: composer
	composer install --dev

phpunit:
	curl -L https://phar.phpunit.de/phpunit.phar -o phpunit && chmod +x phpunit && mv phpunit $(phpunit_bin)

test: install phpunit
	phpunit --coverage-clover=coverage.xml

cache-clear:
	@test -f bin/console && bin/console cache:clear --no-warmup || rm -rf var/cache/*
.PHONY: cache-clear

cache-warmup: cache-clear
	@test -f bin/console && bin/console cache:warmup || echo "cannot warmup the cache (needs symfony/console)"

default_target: test
.PHONY: cache-warmup test composer install phpunit
