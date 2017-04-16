[![Build Status](https://travis-ci.org/stijink/homescreen.svg?branch=master)](https://travis-ci.org/stijink/homescreen) &nbsp; [![Code Climate](https://codeclimate.com/github/stijink/homescreen/badges/gpa.svg)](https://codeclimate.com/github/stijink/homescreen) &nbsp; [![Test Coverage](https://codeclimate.com/github/stijink/homescreen/badges/coverage.svg)](https://codeclimate.com/github/stijink/homescreen/coverage)

## About

This is my personal smart mirror implementation. This project was mainly build to improve my knowledge and just for the fun of doing it :-)

The frontend of the smart mirror was build using [Vue.js](https://vuejs.org/). It makes use of the single file components of the framework.

The backend was build using the PHP Framework [Silex](https://silex.sensiolabs.org/).

## Requirements

* Node.js
* PHP 7+

## Development Setup

This repository comes with a Docker Container for development. You can setup the container by running:

```
bin/setup_dev.sh
``` 

You can start the webserver and `webpatch --watch` by running the following script:

```
bin/run_dev.sh
``` 

Now you should be able to access the magic mirror at the following url:

```
http://localhost:8000
```

## Production Setup

If not already installed you can install `yarn` und `composer` using the following script:

```
bin/install_tools.sh
```

To install all the required libraries for Node.js and PHP you can use the following script. This will **NOT** include the development requirements.

```
bin/setup_prod.sh
``` 

## License

This project is licensed under the MIT license.
