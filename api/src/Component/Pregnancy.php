<?php

namespace App\Component;

use App\Configuration;
use GuzzleHttp\Client;

class Pregnancy implements ComponentInterface
{
    private $configuration;

    /**
     * @param Client $client
     * @param Configuration $configuration
     */
    public function __construct(Client $client, Configuration $configuration)
    {
        $this->client = $client;
        $this->configuration = $configuration;
    }


    public function load(): array
    {
        $currentDate   = new \DateTime();
        $dateStart     = new \DateTime($this->configuration['pregnancy']['date_start']);
        $dateExpected  = new \DateTime($this->configuration['pregnancy']['date_expected']);

        $dateDiffStart = $dateStart->diff($currentDate);
        $dateDiffUntil = $currentDate->diff($dateExpected);

        return [
            'date_expected' => $dateExpected->format('d.m.Y'),
            'days_since'    => $dateDiffStart->days,
            'weeks_since'   => intval(($dateDiffStart->days / 7) + 1),
            'months_since'  => intval($dateDiffStart->m + 1),
            'weeks_until'     => intval(($dateDiffUntil->days / 7) + 1),
        ];
    }
}
