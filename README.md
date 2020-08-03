![CI](https://github.com/stijink/homescreen/workflows/CI/badge.svg)

## About

This is my personal smart mirror implementation. This project was mainly build to improve my knowledge and just for the fun of doing it :-)

The frontend of the smart mirror was build using [Vue.js](https://vuejs.org/). It makes use of the single file components of the framework.

The backend was build using the PHP Framework [Symfony](https://symfony.com/).

## Requirements

* Node.js
* PHP 7+

## Configuration

The API requires a configuration file called `config.json` which is located in api/config/.
This is not included with this repository. But to get started you can copy the existing template `api/config/config.dist.json` over to `api/config/config.json`.
From there on you can start to modify the configuration to your needs.

## Development Setup

This repository comes with Docker containers for development. You can build the containers by running:

```
make build-dev
```

You can start the development stack by running the following script:

```
make start-dev
```

Now you should be able to access the magic mirror at the following url:

```
http://localhost:5000
```

## Production Setup

To install all the required libraries for Node.js and PHP you can use the following script. This will **NOT** include the development requirements.

```
make build-prod
```

## License

This project is licensed under the MIT license.
