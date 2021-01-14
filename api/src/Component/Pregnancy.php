<?php

namespace App\Component;

use App\Configuration;

class Pregnancy implements ComponentInterface
{
    public function __construct(private Configuration $configuration)
    {
    }

    public function load(): array
    {
        $currentDate = new \DateTime();
        $dateStart = new \DateTime($this->configuration['pregnancy']['date_start']);
        $dateExpected = new \DateTime($this->configuration['pregnancy']['date_expected']);

        $dateDiffStart = $dateStart->diff($currentDate);
        $dateDiffUntil = $currentDate->diff($dateExpected);

        return [
            'date_expected'   => $dateExpected->format('d.m.Y'),
            'days_since'      => $dateDiffStart->days,
            'weeks_since'     => intval(($dateDiffStart->days / 7) + 1),
            'months_since'    => intval($dateDiffStart->m + 1),
            'weeks_until'     => intval(($dateDiffUntil->days / 7) + 1),
        ];
    }
}
