<?php

namespace App\Component;

use App\Configuration;
use App\ApiException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Weather implements ComponentInterface
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

    /**
     * @throws ApiException
     * @return array
     */
    public function load(): array
    {
        try {
            $weatherConfiguration = $this->configuration['weather'];

            $response = $this->httpClient->request('GET', $weatherConfiguration['api_url'], [
                    'query' => [
                        'q'     => $weatherConfiguration['city'],
                        'APPID' => $weatherConfiguration['api_key'],
                        'units' => 'metric',
                        'lang'  => $this->configuration['language'],
                    ],
                ]
            );

            $weather = json_decode($response->getContent(), true);

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
