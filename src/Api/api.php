<?php

namespace Api;

use Api\Component\Calendar;
use Api\Component\News;
use Api\Component\Petrol;
use Api\Component\Presence;
use Api\Component\Raspberries;
use Api\Component\RoomTemperature;
use Api\Component\Temperature;
use Api\Component\Traffic;
use Api\Component\Weather;
use Api\Component\WeatherForcast;
use Api\Exception\ApiException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use PicoFeed\Reader\Reader;
use Silex\Application;
use Silex\Provider\MonologServiceProvider;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

$config = require __DIR__.'/../../config.php';
setlocale(LC_ALL, $config['locale']);

$app = new Application();

// --- Service definitions ---

$app->register(new MonologServiceProvider(), [
    'monolog.name' => 'api',
    'monolog.level' => 'error',
    'monolog.logfile' => __DIR__.'/../../logs/api.log',
]);

$app['http_client'] = function () {
    return new Client(['timeout' => 2]);
};

$app['feed_reader'] = function () {
    return new Reader();
};

$app['room_temperature'] = function () use ($app, $config) {
    return new RoomTemperature($app['http_client'], $config['room_temperature']);
};

$app['weather'] = function () use ($app, $config) {
    return new Weather($app['http_client'], $config['weather']);
};

$app['temperature'] = function () use ($app) {
    return new Temperature($app['weather'], $app['room_temperature']);
};

$app['weather_forcast'] = function () use ($app, $config) {
    return new WeatherForcast($app['http_client'], $config['weather_forcast']);
};

$app['traffic'] = function () use ($app, $config) {
    return new Traffic($app['http_client'], $config['traffic']);
};

$app['news'] = function () use ($app, $config) {
    return new News($app['feed_reader'], $config['news']);
};

$app['petrol'] = function () use ($app, $config) {
    return new Petrol($app['http_client'], $config['petrol']);
};

$app['calendar'] = function () use ($config) {
    return new Calendar($config['calendar'], $config['persons']);
};

$app['presence'] = function () use ($app, $config) {
    return new Presence($app['http_client'], $config['presence'], $config['persons']);
};

$app['raspberries'] = function () use ($app, $config) {
    return new Raspberries($app['http_client'], $config['raspberries']);
};

// --- Route definitions ---

$app->get('/weather', function (Request $request) use ($app) {
    $response = $app['weather']->load();

    return new JsonResponse($response);
});

$app->get('/weather-forcast', function (Request $request) use ($app) {
    $response = $app['weather_forcast']->load();

    return new JsonResponse($response);
});

$app->get('/traffic', function (Request $request) use ($app) {
    $response = $app['traffic']->load();

    return new JsonResponse($response);
});

$app->get('/news', function () use ($app) {
    $response = $app['news']->load();

    return new JsonResponse($response);
});

$app->get('/petrol', function () use ($app, $config) {
    $response = $app['petrol']->load();

    return new JsonResponse($response);
});

$app->get('/calendar', function () use ($app) {
    $response = $app['calendar']->load();

    return new JsonResponse($response);
});

$app->get('/presence', function () use ($app) {
    $response = $app['presence']->load();

    return new JsonResponse($response);
});

$app->get('/room-temperature', function () use ($app) {
    $response = $app['room_temperature']->load();

    return new JsonResponse($response);
});

$app->get('/temperature', function () use ($app) {
    $response = $app['temperature']->load();

    return new JsonResponse($response);
});

$app->get('/raspberries', function () use ($app) {
    $response = $app['raspberries']->load();

    return new JsonResponse($response);
});

$app->error(function (\Exception $exception, Request $request, $code) use ($app) {
    $app['monolog']->error($exception->getMessage());

    $message = 'Unbekannter Fehler';
    $description = '
        Ein unbekannter Fehler ist aufgetreten. 
        Die Anwendung muss neu gestartet werden.';

    if ($exception instanceof ConnectException) {
        $message = 'Keine Internetverbindung';
        $description = '
            Es besteht keine Verbindung zum Internet. 
            Sobald die Verbindung wieder da ist, werden die Inhalte automatisch neu geladen.';
    }

    if ($exception instanceof ApiException) {
        $message = $exception->getMessage();
        $description = $exception->getDescription();
    }

    return new JsonResponse(['message' => $message, 'description' => $description], 500);
});

return $app;
