<?php

namespace App\Component;

use Exception;
use App\ApiException;
use App\Configuration;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Petrol implements ComponentInterface
{
    public function __construct(private Configuration $configuration, private HttpClientInterface $httpClient)
    {
    }

    /**
     * @throws ApiException
     * @return array
     */
    public function load(): array
    {
        try {
            $products = [];

            $response = $this->httpClient->request('GET', $this->configuration['petrol']['api_url'], [
                'query' => ['stationId' => $this->configuration['petrol']['station_id']]
            ]);

            $petrol = json_decode($response->getContent(), true);

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
        } catch (Exception) {
            throw new ApiException('Spritpreise konnten nicht bezogen werden');
        }
    }
}
