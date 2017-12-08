<?php

namespace Api\Component;

use Api\Exception\ApiComponentException;

class Temperature implements ComponentInterface
{
    private $weather;
    private $roomTemperature;

    public function __construct(Weather $weather, RoomTemperature $roomTemperature)
    {
        $this->weather = $weather;
        $this->roomTemperature = $roomTemperature;
    }

    /**
     * @return array
     * @throws ApiComponentException
     */
    public function load(): array
    {
        try {
            $weatherResponse = $this->weather->load();
            $temperatureOutside = number_format($weatherResponse['temperature'], 1);
        } catch (\Exception $e) {
            throw new ApiComponentException('Die Aussentemperatur konnte nicht bestimmt werden');
        }

        try {
            $roomTemperatureResponse = $this->roomTemperature->load();
            $temperatureInside  = number_format($roomTemperatureResponse['temperature'], 1);
        } catch (\Exception $e) {
            throw new ApiComponentException('Die Zimmertemperatur konnte nicht bestimmt werden');
        }

        return [
            'temperature_outside' => floatval($temperatureOutside),
            'temperature_inside'  => floatval($temperatureInside),
        ];
    }
}
