<?php

namespace App\Component;

use App\Configuration;
use App\ApiException;

class OpeningHours implements ComponentInterface
{
    private $configuration;

    /**
     * @param Configuration $configuration
     */
    public function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * @return array
     */
    public function load(): array
    {
        $response = [];
        $today = strtolower(date('l'));

        foreach ($this->configuration['opening_hours'] as $place) {
            $response[] = [
                'name'    => $place['name'],
                'hours'   => $place['hours'][$today],
                'is_open' => $this->isPlaceCurrentlyOpen($place),
            ];
        }

        return $response;
    }

    /**
     * Check if a place is currently open
     *
     * @param  array $place
     * @return bool
     */
    private function isPlaceCurrentlyOpen(array $place)
    {
        $today = strtolower(date('l'));
        $currentHour = date('H:00');
        $hoursToday = $place['hours'][$today];

        if ($hoursToday === null) {
            return false;
        }

        $openingHour = trim(substr($hoursToday, 0, 5));
        $closingHour = trim(substr($hoursToday, 8, 13));

        return $currentHour >= $openingHour && $currentHour < $closingHour;
    }
}
