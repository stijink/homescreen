<?php

namespace Tests\Api;

use InterNations\Component\HttpMock\PHPUnit\HttpMockTrait;

trait MyHttpMockTrait
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

    public function setExpectedHttpResponse(string $responseBody)
    {
        $this->http->mock
            ->when()
            ->then()
            ->body($responseBody)
            ->end();

        $this->http->setUp();
    }
}
