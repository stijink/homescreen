<?php

namespace Api\Component;

class Temperature implements ComponentInterface
{
    private $weather;
    private $roomTemperature;

    public function __construct(Weather $weather, RoomTemperature $roomTemperature)
    {
        $this->weather = $weather;
        $this->roomTemperature = $roomTemperature;
    }

    public function load(): array
    {
        $weatherResponse = $this->weather->load();
        $roomTemperatureResponse = $this->roomTemperature->load();

        return [
            'temperature_outside' => $weatherResponse['temperature'],
            'temperature_inside'  => $roomTemperatureResponse['temperature'],
        ];
    }
}
