<?php

namespace Tests\Api\Component;

use Api\Component\Temperature;
use Mockery\Adapter\Phpunit\MockeryTestCase;

class TemperatureTest extends MockeryTestCase
{
    public function testLoad()
    {
        $mockedWeather = \Mockery::mock('Api\Component\Weather')
            ->shouldReceive('load')
            ->once()
            ->andReturn(['temperature' => 27.5])
            ->getMock();

        $mockedRoomTemperature = \Mockery::mock('Api\Component\RoomTemperature')
            ->shouldReceive('load')
            ->once()
            ->andReturn(['temperature' => 23.5])
            ->getMock();

        $temperature = new Temperature($mockedWeather, $mockedRoomTemperature);
        $response = $temperature->load();

        $this->assertCount(2, $response);
        $this->assertSame(23.5, $response['temperature_inside']);
        $this->assertSame(27.5, $response['temperature_outside']);
    }
}
