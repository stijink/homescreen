<?php

namespace Tests\Api;

use Api\Weather;
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

        $this->assertInternalType('array', $response);

        $this->assertArrayHasKey('city', $response);
        $this->assertArrayHasKey('temperature', $response);
        $this->assertArrayHasKey('description', $response);
        $this->assertArrayHasKey('icon_code', $response);
    }

    private function exampleResponse()
    {
        $body = file_get_contents(__DIR__.'/Fixtures/weather.json');

        return new Response(200, [], $body);
    }
}
