<?php


namespace App\Tests;

use Symfony\Component\BrowserKit\Client;
use Symfony\Component\DomCrawler\Crawler;

trait FunctionalTestTrait
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var Crawler
     */
    private $crawler;

    /**
     * Make a GET request
     *
     * @param string $url
     * @param array  $params
     */
    public function makeGetRequest(string $url, array $params = array())
    {
        $this->client  = static::createClient();
        $this->crawler = $this->client->request('GET', $url, $params);
    }

    /**
     * We expect a valid api response
     */
    public function expectValidApiResponse()
    {
        $this->expectResponseIsJson();
        $this->expectResponseIsSuccessful();
    }

    /**
     * We expect that the response is successful
     */
    public function expectResponseIsSuccessful()
    {
        $this->assertTrue(in_array($this->client->getResponse()->getStatusCode(), [200, 204]));
    }

    /**
     * We expect the content-type of the response to be "application/json"
     */
    public function expectResponseIsJson()
    {
        $this->assertSame('application/json', $this->client->getResponse()->headers->get('content-type'));
    }
}
