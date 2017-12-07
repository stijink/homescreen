<?php

namespace Api\Component;

use Api\Exception\ApiComponentException;
use Api\Exception\ApiKeyException;
use GuzzleHttp\Client;

class Traffic implements ComponentInterface
{
    private $httpClient;
    private $config;

    /**
     * @param   Client $httpClient
     * @param   array $config
     * @throws  ApiKeyException
     */
    public function __construct(Client $httpClient, array $config)
    {
        if ($config['api_key'] === null) {
            throw new ApiKeyException();
        }

        $this->httpClient = $httpClient;
        $this->config = $config;
    }

    /**
     * @return array
     * @throws ApiComponentException
     */
    public function load(): array
    {
        try {
            $traffic = [];

            foreach ($this->config['routes'] as $route) {
                $traffic[] = $this->loadRoute($route['origin'], $route['destination']);
            }

            return $traffic;
        } catch (\Exception $e) {
            throw new ApiComponentException('Verkehrsinformationen konnten nicht bestimmt werden');
        }
    }

    private function loadRoute(string $origin, string $destination)
    {
        $response = $this->httpClient->get($this->config['api_url'], [
            'query' => [
                'key' => $this->config['api_key'],
                'language' => $this->config['locale'],
                'origin' => $origin,
                'destination' => $destination,
                'departure_time' => 'now',
                'traffic_model' => 'best_guess',
            ],
        ]);

        $traffic = json_decode((string) $response->getBody(), true);

        return [
            'origin' => $origin,
            'destination' => $destination,
            'distance' => $traffic['routes'][0]['legs'][0]['distance']['text'],
            'duration' => $traffic['routes'][0]['legs'][0]['duration_in_traffic']['text'],
        ];
    }
}
