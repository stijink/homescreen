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
        } catch (\Exception $e) {
            throw new ApiComponentException('Die Aussentemperatur konnte nicht bestimmt werden');
        }

        try {
            $roomTemperatureResponse = $this->roomTemperature->load();
        } catch (\Exception $e) {
            throw new ApiComponentException('Die Zimmertemperatur konnte nicht bestimmt werden');
        }

        return [
            'temperature_outside' => $weatherResponse['temperature'],
            'temperature_inside'  => $roomTemperatureResponse['temperature'],
        ];
    }
}
