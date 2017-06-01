<?php

namespace Api\Component;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Psr7\Request;

class Raspberries implements ComponentInterface
{
    private $httpClient;
    private $config;

    /**
     * @param Client $httpClient
     * @param array  $config
     */
    public function __construct(Client $httpClient, array $config)
    {
        $this->httpClient = $httpClient;
        $this->config = $config;
    }

    /**
     * @return array
     */
    public function load(): array
    {
        $raspberry   = [];
        $raspberries = [];

        foreach ($this->config as $url) {
            $response  = $this->httpClient->get($url);
            $raspberry = json_decode((string)$response->getBody(), true);

            $raspberry['temperature'] = floatval(number_format($raspberry['temperature'], 1));

            $raspberries[] = $raspberry;
        }

        return $raspberries;
    }
}
