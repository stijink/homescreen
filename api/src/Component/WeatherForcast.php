<?php

namespace App\Component;

use Exception;
use App\Configuration;
use App\ApiException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class WeatherForcast implements ComponentInterface
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
            setlocale(LC_TIME, $this->configuration['locale']);

            $forcast = [];
            $response = $this->loadWeatherForcast();

            foreach ($response['list'] as $day) {
                $forcast[] = [
                    'day'         => strftime('%A', (int) $day['dt']),
                    'temperature' => sprintf('%.1f', $day['temp']['day']),
                    'description' => $day['weather'][0]['description'],
                    'icon_code'   => $day['weather'][0]['id'],
                ];
            }

            return $forcast;
        } catch (Exception) {
            throw new ApiException('Wettervorhersage konnte nicht bestimmt werden');
        }
    }

    /**
     * Load the weather forcast from the web service
     *
     * @return array
     */
    private function loadWeatherForcast(): array
    {
        $response = $this->httpClient->request('GET', $this->configuration['weather_forcast']['api_url'], [
            'query' => [
                'q'     => $this->configuration['weather_forcast']['city'],
                'APPID' => $this->configuration['weather_forcast']['api_key'],
                'units' => 'metric',
                'lang'  => $this->configuration['language'],
                'cnt'   => 7,
            ],
        ]);

        return json_decode($response->getContent(), true);
    }
}
