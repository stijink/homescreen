<?php

namespace App\Component;

use App\ApiException;

class Temperature implements ComponentInterface
{
    private $weather;
    private $roomTemperature;

    /**
     * @param Weather $weather
     * @param RoomTemperature $roomTemperature
     */
    public function __construct(Weather $weather, RoomTemperature $roomTemperature)
    {
        $this->weather = $weather;
        $this->roomTemperature = $roomTemperature;
    }

    /**
     * @throws ApiException
     * @return array
     */
    public function load(): array
    {
        try {
            $weatherResponse = $this->weather->load();
            $temperatureOutside = number_format($weatherResponse['temperature'], 1);
        } catch (\Exception $e) {
            throw new ApiException('Die Aussentemperatur konnte nicht bestimmt werden');
        }

        try {
            $roomTemperatureResponse = $this->roomTemperature->load();
            $temperatureInside = number_format($roomTemperatureResponse['temperature'], 1);
        } catch (\Exception $e) {
            throw new ApiException('Die Zimmertemperatur konnte nicht bestimmt werden');
        }

        return [
            'temperature_outside' => floatval($temperatureOutside),
            'temperature_inside'  => floatval($temperatureInside),
        ];
    }
}
