<?php

namespace App\Component;

use App\Configuration;
use App\ApiException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Traffic implements ComponentInterface
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
            $traffic = [];

            foreach ($this->configuration['traffic']['routes'] as $route) {
                $traffic[] = $this->loadRoute(origin: $route['origin'], destination: $route['destination']);
            }

            return $traffic;
        } catch (\Exception $e) {
            throw new ApiException('Verkehrsinformationen konnten nicht bestimmt werden');
        }
    }

    /**
     * @param string $origin
     * @param string $destination
     * @return array
     */
    private function loadRoute(string $origin, string $destination): array
    {
        $response = $this->httpClient->request('GET', $this->configuration['traffic']['api_url'], [
            'query' => [
                'key'            => $this->configuration['traffic']['api_key'],
                'language'       => $this->configuration['locale'],
                'origin'         => $origin,
                'destination'    => $destination,
                'departure_time' => 'now',
                'traffic_model'  => 'best_guess',
            ],
        ]);

        $traffic = json_decode($response->getContent(), true);

        return [
            'origin'      => $origin,
            'destination' => $destination,
            'distance'    => $traffic['routes'][0]['legs'][0]['distance']['text'],
            'duration'    => $traffic['routes'][0]['legs'][0]['duration_in_traffic']['text'],
        ];
    }
}
