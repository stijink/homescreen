<?php

namespace App\Component;

use App\ApiException;
use Psr\Log\LoggerInterface;

class Temperature implements ComponentInterface
{
    use ComponentTrait;

    private $weather;
    private $roomTemperature;
    private $logger;

    /**
     * @param Weather $weather
     * @param RoomTemperature $roomTemperature
     * @param LoggerInterface $logger
     */
    public function __construct(Weather $weather, RoomTemperature $roomTemperature, LoggerInterface $logger)
    {
        $this->weather = $weather;
        $this->roomTemperature = $roomTemperature;
        $this->logger = $logger;
    }

    /**
     * @return array
     * @throws ApiException
     */
    public function load(): array
    {
        try {
            $weatherResponse = $this->weather->load();
            $temperatureOutside = number_format($weatherResponse['temperature'], 1);
        } catch (\Exception $e) {
            $this->handleException($e, 'Die Aussentemperatur konnte nicht bestimmt werden');
        }

        try {
            $roomTemperatureResponse = $this->roomTemperature->load();
            $temperatureInside  = number_format($roomTemperatureResponse['temperature'], 1);
        } catch (\Exception $e) {
            $this->handleException($e, 'Die Zimmertemperatur konnte nicht bestimmt werden');
        }

        return [
            'temperature_outside' => floatval($temperatureOutside),
            'temperature_inside'  => floatval($temperatureInside),
        ];
    }
}
