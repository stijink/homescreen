<?php

namespace App\Tests\Controller;

use App\Tests\FunctionalTestTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class WeatherControllerTest extends WebTestCase
{
    use FunctionalTestTrait;

    public function testWeather()
    {
        $this->makeGetRequest('/weather');
        $this->expectValidApiResponse();
    }
}
