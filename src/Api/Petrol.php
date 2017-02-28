<?php

namespace Api;

use GuzzleHttp\Client;

class Petrol implements ApiInterface
{
    private $httpClient;
    private $config;

    public function __construct(Client $httpClient, array $config)
    {
        $this->httpClient = $httpClient;
        $this->config = $config;
    }

    public function load(): array
    {
        $products = [];

        $response = $this->httpClient->get($this->config['api_url'], [
            'query' => ['stationId' => $this->config['station_id']],
        ]
        );

        $petrol = json_decode((string)$response->getBody(), true);

        foreach ($petrol['response']['prices'] as $product) {
            if (!in_array($product['name'], $this->config['prefered_petrol'])) {
                continue;
            }

            $product['price'] = (float)$product['price'] / 100;
            $products[] = $product;
        }

        return [
            'location' => $this->config['location'],
            'products' => $products,
        ];
    }
}
