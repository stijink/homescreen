<?php

namespace App\Component;

use App\Configuration;
use App\ApiException;
use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;

class WeatherForcast implements ComponentInterface
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
     * @throws ApiException
     */
    public function load(): array
    {
        try {
            setlocale(LC_TIME, $this->configuration['locale']);

            $forcast  = [];
            $response = $this->loadWeatherForcast();

            foreach ($response['list'] as $day) {
                $forcast[] = [
                    'day'         => strftime('%A', (int)$day['dt']),
                    'temperature' => sprintf('%.1f', $day['temp']['day']),
                    'description' => $day['weather'][0]['description'],
                    'icon_code'   => $day['weather'][0]['id'],
                ];
            }

            return $forcast;
        } catch (\Exception $e) {
            $this->handleException($e, 'Wettervorhersage konnte nicht bestimmt werden');
        }
    }

    /**
     * Load the weather forcast from the web service
     *
     * @return array
     */
    private function loadWeatherForcast(): array
    {
        $response = $this->httpClient->get($this->configuration['weather_forcast']['api_url'], [
            'query' => [
                'q'     => $this->configuration['weather_forcast']['city'],
                'APPID' => $this->configuration['weather_forcast']['api_key'],
                'units' => 'metric',
                'lang'  => $this->configuration['language'],
                'cnt'   => 7,
            ],
        ]);

        return json_decode((string)$response->getBody(), true);
    }
}
