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
            $filteredProducts = [];

            $response = $this->httpClient->request('GET', $this->configuration['petrol']['api_url']);
            $petrol   = json_decode($response->getContent(), true);
            $products = $petrol['fuel_pricing']['prices'];

            foreach ($products as $productName => $productPrice) {

                if (! in_array($productName, $this->configuration['petrol']['prefered_petrol'])) {
                    continue;
                }

                $filteredProducts[] = [
                    'name'  => $productName,
                    'price' => substr($productPrice, 0, 4),
                ];
            }

            return [
                'location' => $this->configuration['petrol']['location'],
                'products' => $filteredProducts,
            ];
        } catch (Exception) {
            throw new ApiException('Spritpreise konnten nicht bezogen werden');
        }
    }
}
