#!/usr/bin/env bash

# Install the latest version of yarn
curl -o- -L https://yarnpkg.com/install.sh | bash

# install composer if not already installed
if [ ! -f /usr/local/bin/composer ]
  then
	curl -sS https://getcomposer.org/installer | php
	mv composer.phar /usr/local/bin/composer
  else
	composer self-update
fi
