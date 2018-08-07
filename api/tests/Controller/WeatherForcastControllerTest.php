<?php

namespace App\Tests\Controller;

use App\Tests\FunctionalTestTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class WeatherForcastControllerTest extends WebTestCase
{
    use FunctionalTestTrait;

    /**
     * @vcr weather-forcast.yml
     */
    public function testWeather()
    {
        $this->makeGetRequest('/weather-forcast');
        $this->expectValidApiResponse();
    }
}
