<?php

namespace App\Component;

use App\Configuration;
use App\ApiComponentException;
use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;

class Traffic implements ComponentInterface
{
    use ComponentTrait;

    private $configuration;
    private $logger;
    private $httpClient;

    /**
     * @param Configuration $configuration
     * @param LoggerInterface $logger
     * @param Client $httpClient
     */
    public function __construct(Configuration $configuration, LoggerInterface $logger, Client $httpClient)
    {
        $this->configuration = $configuration;
        $this->logger = $logger;
        $this->httpClient = $httpClient;
    }

    /**
     * @return array
     * @throws ApiComponentException
     */
    public function load(): array
    {
        try {
            $traffic = [];

            foreach ($this->configuration['traffic']['routes'] as $route) {
                $traffic[] = $this->loadRoute($route['origin'], $route['destination']);
            }

            return $traffic;
        } catch (\Exception $e) {
            $this->handleException($e, 'Verkehrsinformationen konnten nicht bestimmt werden');
        }
    }

    private function loadRoute(string $origin, string $destination)
    {
        $response = $this->httpClient->get($this->configuration['traffic']['api_url'], [
            'query' => [
                'key' => $this->configuration['traffic']['api_key'],
                'language' => $this->configuration['locale'],
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
