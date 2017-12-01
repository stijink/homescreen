<?php

namespace Tests\Api\Component;

use Api\Component\RoomTemperature;
use GuzzleHttp\Psr7\Response;
use Mockery\Adapter\Phpunit\MockeryTestCase;

class RoomTemperatureTest extends MockeryTestCase
{
    public function testLoad()
    {
        $config = ['api_url' => 'http://homescreen:9321/'];

        $mockedHttpClient = \Mockery::mock('GuzzleHttp\Client')
            ->shouldReceive('get')
            ->once()
            ->withArgs(['http://homescreen:9321/'])
            ->andReturn(new Response(200, [], '22.5'))
            ->getMock();

        $roomTemperature = new RoomTemperature($mockedHttpClient, $config);
        $response = $roomTemperature->load();

        $this->assertCount(1, $response);
        $this->assertSame(22.5, $response['temperature']);
    }
}
