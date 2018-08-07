<?php

namespace App\Tests\Controller;

use App\Tests\FunctionalTestTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RasperriesControllerTest extends WebTestCase
{
    use FunctionalTestTrait;

    /**
     * @vcr raspberries.yml
     */
    public function testIndex()
    {
        $this->makeGetRequest('/raspberries');
        $this->expectValidApiResponse();
    }
}
