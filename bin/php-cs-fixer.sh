
#!/usr/bin/env bash

docker-compose run homescreen-api \
    php-cs-fixer fix --config=php-cs-fixer-config.php --verbose
