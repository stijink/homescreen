<?php

namespace App\Component;

use App\ApiException;
use App\Configuration;
use GuzzleHttp\Client;

class Petrol implements ComponentInterface
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
            $products = [];

            $response = $this->httpClient->get(
                $this->configuration['petrol']['api_url'],
                ['query' => ['stationId' => $this->configuration['petrol']['station_id']]]
            );

            $petrol = json_decode((string) $response->getBody(), true);

            foreach ($petrol['response']['prices'] as $product) {
                if (! in_array($product['name'], $this->configuration['petrol']['prefered_petrol'])) {
                    continue;
                }

                $product['price'] = (float) $product['price'] / 100;
                $product['price'] = number_format($product['price'], 2, '.', ',');

                $products[] = $product;
            }

            return [
                'location' => $this->configuration['petrol']['location'],
                'products' => $products,
            ];
        } catch (\Exception $e) {
            throw new ApiException('Spritpreise konnten nicht bezogen werden');
        }
    }
}
