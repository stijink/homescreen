<?php

namespace Tests\Api\Component;

use Api\Component\Weather;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class WeatherTest extends TestCase
{
    /**
     * @expectedException \Api\Exception\ApiKeyException
     */
    public function testApiyKeyException()
    {
        $mockedHttpClient = \Mockery::mock('GuzzleHttp\Client');
        $weather = new Weather($mockedHttpClient, ['api_key' => null]);
    }

    public function testLoad()
    {
        $expectedResponse = [
            'city' => 'Troisdorf',
            'temperature' => 10.4,
            'description' => 'klarer Himmel',
            'icon_code' => 800,
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
                    ],
                ],
            ])
            ->andReturn($this->exampleResponse())
            ->getMock();

        $weather = new Weather($mockedHttpClient, [
            'api_url' => 'http://example-api.com',
            'api_key' => 1234,
            'city' => 'Troisdorf',
        ]);

        $response = $weather->load();
        $this->assertEquals($expectedResponse, $response);
    }

    private function exampleResponse()
    {
        $body = file_get_contents(__DIR__.'/../Fixtures/weather.json');

        return new Response(200, [], $body);
    }
}
