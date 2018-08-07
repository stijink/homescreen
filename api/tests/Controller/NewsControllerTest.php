<?php

namespace App\Tests\Controller;

use App\Tests\FunctionalTestTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class NewsControllerTest extends WebTestCase
{
    use FunctionalTestTrait;

    /**
     * @vcr news.yml
     */
    public function testIndex()
    {
        $this->makeGetRequest('/news');
        $this->expectValidApiResponse();
    }
}
