<?php

namespace App\Tests\Controller;

use App\Tests\FunctionalTestTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CalendarControllerTest extends WebTestCase
{
    use FunctionalTestTrait;

    public function testIndex()
    {
        $this->makeGetRequest('/calendar');
        $this->expectValidApiResponse();
    }
}
