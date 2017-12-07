<?php

namespace Api\Component;

use Api\Exception\ApiComponentException;
use Api\Exception\ApiKeyException;
use GuzzleHttp\Client;
use function GuzzleHttp\json_decode;

class Weather implements ComponentInterface
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

    /**
     * @return array
     * @throws ApiComponentException
     */
    public function load(): array
    {
        try {
            $response = $this->httpClient->get(
                $this->config['api_url'],
                [
                    'query' => [
                        'q'     => $this->config['city'],
                        'APPID' => $this->config['api_key'],
                        'units' => 'metric',
                        'lang'  => 'de',
                    ],
                ]
            );

            $weather = json_decode((string)$response->getBody(), true);

            return [
                'city'        => $this->config['city'],
                'temperature' => round($weather['main']['temp'], 1),
                'description' => $weather['weather'][0]['description'],
                'sunrise'     => $weather['sys']['sunrise'],
                'sunset'      => $weather['sys']['sunset'],
                'icon_code'   => $weather['weather'][0]['id'],
            ];
        } catch (\Exception $e) {
            throw new ApiComponentException('Wetterinformationen konnten nicht bestimmt werden');
        }
    }
}
