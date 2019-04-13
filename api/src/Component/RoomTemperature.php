<?php

namespace App\Component;

use App\Configuration;
use GuzzleHttp\Client;

class RoomTemperature implements ComponentInterface
{
    private $configuration;
    private $httpClient;

    /**
     * @param Configuration $configuration
     * @param Client $httpClient
     */
    public function __construct(Configuration $configuration, Client $httpClient)
    {
        $this->configuration = $configuration;
        $this->httpClient = $httpClient;
    }

    public function load(): array
    {
        $response = $this->httpClient->get($this->configuration['room_temperature']['api_url']);
        $temperature = (string) $response->getBody();

        return [
            'temperature' => floatval($temperature),
        ];
    }
}
