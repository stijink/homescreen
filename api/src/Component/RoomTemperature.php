<?php

namespace App\Component;

use App\Configuration;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class RoomTemperature implements ComponentInterface
{
    private $configuration;
    private $httpClient;

    /**
     * @param Configuration $configuration
     * @param HttpClientInterface $httpClient
     */
    public function __construct(Configuration $configuration, HttpClientInterface $httpClient)
    {
        $this->configuration = $configuration;
        $this->httpClient = $httpClient;
    }

    public function load(): array
    {
        $response = $this->httpClient->request('GET', $this->configuration['room_temperature']['api_url']);
        $temperature = $response->getContent();

        return [
            'temperature' => floatval($temperature),
        ];
    }
}
