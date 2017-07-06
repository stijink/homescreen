<?php

require_once __DIR__.'/../../vendor/autoload.php';

$app = require __DIR__.'/../../src/Api/api.php';
$app['debug'] = true;

$app->run();
