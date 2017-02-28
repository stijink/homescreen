<?php

namespace Api;

use Api\Exception\ApiKeyException;
use GuzzleHttp\Client;
use function GuzzleHttp\json_decode;

class WeatherForcast implements ApiInterface
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
        $forcast = [];

        $response = $this->httpClient->get($this->config['api_url'], [
            'query' => [
                'q' => $this->config['city'],
                'APPID' => $this->config['api_key'],
                'units' => 'metric',
                'lang' => 'de',
                'cnt' => 5,
            ],
        ]);

        $answer = json_decode((string) $response->getBody(), true);

        foreach ($answer['list'] as $day) {
            $forcast[] = [
                'day' => strftime('%A', (int) $day['dt']),
                'temperature' => round($day['temp']['day'], 1),
                'description' => $day['weather'][0]['description'],
                'icon_code' => $day['weather'][0]['id'],
            ];
        }

        return $forcast;
    }
}
