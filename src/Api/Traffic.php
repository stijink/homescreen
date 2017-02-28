<?php

namespace Api;

use Api\Exception\ApiKeyException;
use GuzzleHttp\Client;

class Traffic implements ApiInterface
{
    private $httpClient;
    private $config;

    public function __construct(Client $httpClient, array $config)
    {
        if ($config['api_key'] === null) {
            throw new ApiKeyException();
        }

        $this->httpClient = $httpClient;
        $this->config = $config;
    }

    public function load(): array
    {
        $traffic = [];

        foreach ($this->config['routes'] as $route) {
            $traffic[] = $this->loadRoute($route['origin'], $route['destination']);
        }

        return $traffic;
    }

    private function loadRoute(string $origin, string $destination)
    {
        $response = $this->httpClient->get($this->config['api_url'], [
            'query' => [
                'key' => $this->config['api_key'],
                'language' => $this->config['locale'],
                'origin' => $origin,
                'destination' => $destination,
            ],
        ]);

        $traffic = json_decode((string) $response->getBody(), true);

        return [
            'origin' => $origin,
            'destination' => $destination,
            'distance' => $traffic['routes'][0]['legs'][0]['distance']['text'],
            'duration' => $traffic['routes'][0]['legs'][0]['duration']['text'],
        ];
    }
}
