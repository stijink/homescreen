<?php

namespace App\Component;

use App\ApiException;
use App\Configuration;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Temperature implements ComponentInterface
{
    public function __construct(
        private Configuration $configuration,
        private HttpClientInterface $httpClient,
        private Weather $weather
    ) {
    }


    /**
     * @throws ApiException
     * @return array
     */
    public function load(): array
    {
        $headers = [
            'Authorization' =>  'Bearer ' . $this->configuration['homeassistant']['api_token'],
            'content-type'  =>  'application/json',
        ];

        try {
            $weather = $this->weather->load();
            $temperatureOutside = $weather['temperature'];
        } catch (\Exception $e) {
            throw new ApiException('Die Aussentemperatur konnte nicht bestimmt werden');
        }

        try {
            $temperatureUrl      = $this->configuration['homeassistant']['api_url'] . '/sensor.temperature_4';
            $temperatureResponse = $this->httpClient->request('GET', $temperatureUrl, [
                'headers' => $headers
            ]);

            $temperature = json_decode($temperatureResponse->getContent(), true);
            $temperatureInside = sprintf('%.1f', $temperature['state']);
        } catch (\Exception $e) {
            throw new ApiException('Die Zimmertemperatur konnte nicht bestimmt werden');
        }

        return [
            'temperature_outside' => floatval($temperatureOutside),
            'temperature_inside'  => floatval($temperatureInside),
        ];
    }
}
