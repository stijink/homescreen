<?php

namespace Tests\Api\Component;

use Api\Component\Traffic;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class TrafficTest extends TestCase
{
    /**
     * @expectedException \Api\Exception\ApiKeyException
     */
    public function testApiyKeyException()
    {
        $mockedHttpClient = \Mockery::mock('GuzzleHttp\Client');
        $traffic = new Traffic($mockedHttpClient, ['api_key' => null]);
    }

    public function testLoad()
    {
        $config = [
            'api_key' => 'awesome_api_key',
            'api_url' => 'https://maps.googleapis.com/maps/api/directions/json',
            'locale' => 'de',
            'routes' => [
                [
                    'origin' => 'Bonn',
                    'destination' => 'Köln',
                ],
             ],
        ];

        $expectedResponse = [
            [
              'origin' => 'Bonn',
              'destination' => 'Köln',
              'distance' => '28,6 km',
              'duration' => '31 Minuten',
            ],
        ];

        $mockedHttpClient = \Mockery::mock('GuzzleHttp\Client')
            ->shouldReceive('get')
            ->once()
            ->withArgs([
                'https://maps.googleapis.com/maps/api/directions/json',
                [
                    'query' => [
                        'key' => 'awesome_api_key',
                        'language' => 'de',
                        'origin' => 'Bonn',
                        'destination' => 'Köln',
                        'departure_time' => 'now',
                        'traffic_model' => 'best_guess',
                    ],
                ],
            ])
            ->andReturn($this->exampleResponse())
            ->getMock();

        $traffic = new Traffic($mockedHttpClient, $config);
        $response = $traffic->load();

        $this->assertEquals($expectedResponse, $response);
    }

    private function exampleResponse() : Response
    {
        $body = file_get_contents(__DIR__.'/../Fixtures/traffic.json');

        return new Response(200, [], $body);
    }
}
