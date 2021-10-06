<?php

namespace App\Component;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class Covid19
{
    public function __construct(private HttpClientInterface $httpClient)
    {
    }

    public function load(): array
    {
        $result = $this->httpClient->request('GET', 'https://api.corona-zahlen.org/districts/05382');
        return $result->toArray()['data']['05382'];
    }
}
