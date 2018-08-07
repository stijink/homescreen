<?php

namespace App\Tests\Controller;

use App\Tests\FunctionalTestTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TemperatureControllerTest extends WebTestCase
{
    use FunctionalTestTrait;

    /**
     * @vcr temperature.yml
     */
    public function testIndex()
    {
        $this->makeGetRequest('/temperature');
        $this->expectValidApiResponse();
    }
}
