<?php

namespace Tests\Api;

use Api\WeatherForcast;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class WeatherForcastTest extends TestCase
{
    /**
     * @expectedException \Api\Exception\ApiKeyException
     */
    public function testApiyKeyException()
    {
        $mockedHttpClient = \Mockery::mock('GuzzleHttp\Client');
        $weatherForcast = new WeatherForcast($mockedHttpClient, ['api_key' => null]);
    }

    public function testLoad()
    {
        $exprectedResponse = [
            [
                "day" => "Tuesday",
                "temperature" => 4.0,
                "description" => "mäßiger Schnee",
                "icon_code" => 600,
            ],
            [
                "day" => "Wednesday",
                "temperature" => 4.8,
                "description" => "sehr starker Regen",
                "icon_code" => 502,
            ],
            [
                "day" => "Thursday",
                "temperature" => 7.7,
                "description" => "leichter Regen",
                "icon_code" => 500,
            ],
            [
                "day" => "Friday",
                "temperature" => 9.0,
                "description" => "mäßiger Regen",
                "icon_code" => 501,
            ],
            [
                "day" => "Saturday",
                "temperature" => 11.5,
                "description" => "mäßiger Regen",
                "icon_code" => 501,
            ]
        ];

        $mockedHttpClient = \Mockery::mock('GuzzleHttp\Client')
            ->shouldReceive('get')
            ->once()
            ->withArgs([
                'http://example-api.com',
                [
                    'query' => [
                        'q' => 'Troisdorf',
                        'APPID' => 1234,
                        'units' => 'metric',
                        'lang' => 'de',
                        'cnt' => 5,
                    ],
                ],
            ])
            ->andReturn($this->exampleResponse())
            ->getMock();

        $weatherForcast = new WeatherForcast($mockedHttpClient, [
            'api_url' => 'http://example-api.com',
            'api_key' => 1234,
            'city' => 'Troisdorf',
        ]);

        $response = $weatherForcast->load();
        $this->assertEquals($exprectedResponse, $response);
    }

    private function exampleResponse()
    {
        $body = file_get_contents(__DIR__.'/Fixtures/weather-forcast.json');

        return new Response(200, [], $body);
    }
}
