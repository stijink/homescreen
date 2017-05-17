<?php

namespace Api\Component;

use GuzzleHttp\Client;

class RoomTemperature implements ComponentInterface
{
    private $httpClient;
    private $config;

    public function __construct(Client $httpClient, array $config)
    {
        $this->httpClient = $httpClient;
        $this->config = $config;
    }

    public function load(): array
    {
        $response    = $this->httpClient->get($this->config['api_url']);
        $temperature = (string)$response->getBody();

        return [
            'temperature' => floatval($temperature),
        ];
    }
}
