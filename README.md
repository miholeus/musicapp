Music App
=========

Installation
===
Run docker
* `docker-compose up -d`

Go to container `docker-compose exec php bash` and run commands:
* Apply migrations
`bin/console doctrine:migrations:migrate`
* Run fixtures command
`bin/console doctrine:fixtures:load`
* Generate api key for rest clients
`bin/console api:keys:generate rest`

Testing
===

* Create user `createuser musicapp_test`
* Set permissions to user
`psql -c "alter role musicapp_test with createdb" -d test`
* Run command 
`bin/console doctrine:database:create --env=test`
* Apply migrations
`bin/console doctrine:migrations:migrate --env=test`
* Run fixtures command
`bin/console doctrine:fixtures:load --env=test`
* Run unit tests
`phpunit -c .`
