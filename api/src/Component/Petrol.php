<?php

namespace App\Component;

use App\Configuration;
use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;

class Petrol implements ComponentInterface
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
     * @throws \App\ApiException
     */
    public function load(): array
    {
        try {
            $products = [];

            $response = $this->httpClient->get(
                $this->configuration['petrol']['api_url'],
                ['query' => ['stationId' => $this->configuration['petrol']['station_id']]]
            );

            $petrol = json_decode((string)$response->getBody(), true);

            foreach ($petrol['response']['prices'] as $product) {
                if (!in_array($product['name'], $this->configuration['petrol']['prefered_petrol'])) {
                    continue;
                }

                $product['price'] = (float)$product['price'] / 100;
                $product['price'] = number_format($product['price'], 2, '.', ',');

                $products[] = $product;
            }

            return [
                'location' => $this->configuration['petrol']['location'],
                'products' => $products,
            ];
        } catch (\Exception $e) {
            $this->handleException($e, 'Spritpreise konnten nicht bezogen werden');
        }
    }
}
