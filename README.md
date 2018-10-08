# otravo-tickets4sale

# setup:

Install dependencies: `composer install`

Run tests with: `./vendor/bin/simple-phpunit tests/ --bootstrap vendor/autoload.php`


CSV file uploads for input should be placed in `uploads` directory.

----
US-1: CLI command run: `php bin/console app:list_shows 'shows.csv' '2017-01-01' '2017-07-01'`

Arguments in order are: filename, query date, show date.