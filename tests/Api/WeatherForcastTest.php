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

        $this->assertInternalType('array', $response);
        $this->assertCount(5, $response);

        $firstResult = $response[0];

        $this->assertArrayHasKey('day', $firstResult);
        $this->assertArrayHasKey('temperature', $firstResult);
        $this->assertArrayHasKey('description', $firstResult);
        $this->assertArrayHasKey('icon_code', $firstResult);
    }

    private function exampleResponse()
    {
        $body = file_get_contents(__DIR__.'/Fixtures/weather-forcast.json');

        return new Response(200, [], $body);
    }
}
