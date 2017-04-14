<?php

namespace Tests\Api\Component;

use Api\Component\News;
use InterNations\Component\HttpMock\PHPUnit\HttpMockTrait;
use PicoFeed\Reader\Reader;

class NewsTest extends \PHPUnit_Framework_TestCase
{
    use HttpMockTrait;

    public static function setUpBeforeClass()
    {
        static::setUpHttpMockBeforeClass('9012', 'localhost');
    }

    public static function tearDownAfterClass()
    {
        static::tearDownHttpMockAfterClass();
    }

    public function setUp()
    {
        $this->setUpHttpMock();
    }

    public function tearDown()
    {
        $this->tearDownHttpMock();
    }

    public function testLoad()
    {
        $this->http->mock
            ->when()
            ->methodIs('GET')
            ->pathIs('/')
            ->then()
            ->body(file_get_contents(__DIR__.'/../Fixtures/news.rss'))
            ->end();
        $this->http->setUp();

        $config = [
            'feeds' => [
                'http://t3n.de/feed/feed.rss',
            ],
        ];

        $news = new News(new Reader(), $config);
        $response = $news->load();
    }
}
