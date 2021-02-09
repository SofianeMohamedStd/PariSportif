.PHONY: start stop ps prepare test cache-clear

prepare:
	php bin/console cache:clear --env=test
	php bin/console doctrine:database:drop --if-exists -f --env=test
	php bin/console doctrine:database:create --env=test
	php bin/console doctrine:schema:update -f --env=test

stan: ## Run PHPStan
	${CURDIR}/vendor/bin/phpstan analyse  -c phpstan.neon

phpcs: ## Run Codesniffer
	${CURDIR}/vendor/bin/phpcs

test:
	${CURDIR}\vendor\bin\simple-phpunit

dbDev:
	docker-compose exec php7.4 php bin/console doctrine:cache:clear-metadata
	docker-compose exec php7.4 php bin/console doctrine:database:create --if-not-exists
	docker-compose exec php7.4 php bin/console doctrine:schema:drop --force
	docker-compose exec php7.4 php bin/console doctrine:schema:create
	docker-compose exec php7.4 php bin/console doctrine:schema:validate
	docker-compose exec php7.4 php bin/console doctrine:fixtures:load -n

cache-clear:
	docker-compose exec php7.4 php bin/console cache:clear

clean:
	rm -f *.dat


