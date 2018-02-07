<?php

namespace App\Component;

use App\Configuration;
use App\ApiComponentException;
use GuzzleHttp\Client;
use function GuzzleHttp\json_decode;
use Psr\Log\LoggerInterface;

class Weather implements ComponentInterface
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

            $weather = json_decode((string)$response->getBody(), true);

            return [
                'city'        => $weatherConfiguration['city'],
                'temperature' => sprintf('%.1f', $weather['main']['temp']),
                'description' => $weather['weather'][0]['description'],
                'sunrise'     => $weather['sys']['sunrise'],
                'sunset'      => $weather['sys']['sunset'],
                'icon_code'   => $weather['weather'][0]['id'],
            ];
        } catch (\Exception $e) {
            $this->handleException($e, 'Wetterinformationen konnten nicht bestimmt werden');
        }
    }
}
