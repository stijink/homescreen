<?php

namespace App\Component;

use App\Configuration;
use App\ApiException;
use GuzzleHttp\Client;
use function GuzzleHttp\json_decode;

class Weather implements ComponentInterface
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

    /**
     * @throws ApiException
     * @return array
     */
    public function load(): array
    {
        try {
            $weatherConfiguration = $this->configuration['weather'];

            $response = $this->httpClient->get(
                $weatherConfiguration['api_url'],
                [
                    'query' => [
                        'q'     => $weatherConfiguration['city'],
                        'APPID' => $weatherConfiguration['api_key'],
                        'units' => 'metric',
                        'lang'  => $this->configuration['language'],
                    ],
                ]
            );

            $weather = json_decode((string) $response->getBody(), true);

            return [
                'city'        => $weatherConfiguration['city'],
                'temperature' => sprintf('%.1f', $weather['main']['temp']),
                'description' => $weather['weather'][0]['description'],
                'sunrise'     => $weather['sys']['sunrise'],
                'sunset'      => $weather['sys']['sunset'],
                'icon_code'   => $weather['weather'][0]['id'],
            ];
        } catch (\Exception $e) {
            throw new ApiException('Wetterinformationen konnten nicht bestimmt werden');
        }
    }
}
