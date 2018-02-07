<?php

namespace App\Component;

use App\Configuration;
use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;

class RoomTemperature implements ComponentInterface
{
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

    public function load(): array
    {
        $response    = $this->httpClient->get($this->configuration['room_temperature']['api_url']);
        $temperature = (string)$response->getBody();

        return [
            'temperature' => floatval($temperature),
        ];
    }
}
