<?php

namespace Tests\Api\Component;

use Api\Component\Petrol;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class PetrolTest extends TestCase
{
    public function testLoad()
    {
        $config = [
            'api_url' => 'http://ap.aral.de/api/v2/getStationPricesById.php',
            'location' => 'Aral - Moselstraße 2, Troisdorf',
            'station_id' => 20141300,
            'prefered_petrol' => ['Aral Super 95', 'Aral Ultimate 102'],
        ];

        $expectedResponse = [
            "location" => "Aral - Moselstraße 2, Troisdorf",
            "products" => [
                [
                    "name" => "Aral Super 95",
                    "price" => 1.32,
                    "currency" => "EUR",
                    "id" => "001040",
                    "sort" => "21",
                ],
                [
                    "name" => "Aral Ultimate 102",
                    "price" => 1.46,
                    "currency" => "EUR",
                    "id" => "001255",
                    "sort" => "24",
                ],
            ]
        ];

        $mockedHttpClient = \Mockery::mock('GuzzleHttp\Client')
            ->shouldReceive('get')
            ->once()
            ->withArgs([
                'http://ap.aral.de/api/v2/getStationPricesById.php',
                [
                    'query' => [
                        'stationId' => 20141300,
                    ],
                ],
            ])
            ->andReturn($this->exampleResponse())
            ->getMock();

        $petrol = new Petrol($mockedHttpClient, $config);
        $response = $petrol->load();

        $this->assertEquals($expectedResponse, $response);
    }

    private function exampleResponse()
    {
        $body = file_get_contents(__DIR__.'/../Fixtures/petrol.json');

        return new Response(200, [], $body);
    }
}
