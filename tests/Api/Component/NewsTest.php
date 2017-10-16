<?php

namespace Tests\Api\Component;

use Api\Component\News;
use PHPUnit\Framework\TestCase;
use PicoFeed\Reader\Reader;
use Tests\Api\MyHttpMockTrait;

class NewsTest extends TestCase
{
    use MyHttpMockTrait;

    public function testLoad()
    {
        $this->setExpectedHttpResponse(
            file_get_contents(__DIR__ . '/../Fixtures/news.rss')
        );

        $config = [
            'feeds' => [
                'http://t3n.de/feed/feed.rss',
            ],
        ];

        $news = new News(new Reader(), $config);
        $response = $news->load();

        $this->assertCount(10, $response);

        foreach ($response as $news) {
            $this->assertArrayHasKey('title', $news);
            $this->assertArrayHasKey('description', $news);
            $this->assertArrayHasKey( 'date', $news);
            $this->assertArrayHasKey('visible', $news);
        }
    }
}
