<?php

namespace App\Tests\Controller;

use App\Tests\FunctionalTestTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TrafficControllerTest extends WebTestCase
{
    use FunctionalTestTrait;

    public function testIndex()
    {
        $this->makeGetRequest('/traffic');
        $this->expectValidApiResponse();
    }
}