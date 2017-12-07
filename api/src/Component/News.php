<?php

namespace Api\Component;

use Api\Exception\ApiComponentException;
use PicoFeed\Reader\Reader;

class News implements ComponentInterface
{
    private $feedReader;
    private $config;

    /**
     * @param Reader $feedReader
     * @param array $config
     */
    public function __construct(Reader $feedReader, array $config)
    {
        $this->feedReader = $feedReader;
        $this->config = $config;
    }

    /**
     * @return  array
     * @throws  ApiComponentException
     */
    public function load(): array
    {
        try {
            $news = [];

            foreach ($this->config['feeds'] as $feed) {
                $news = array_merge($news, $this->loadFeed($feed));
            }

            shuffle($news);

            return $news;
        } catch (\Exception $e) {
            throw new ApiComponentException('News konnten nicht bezogen werden');
        }
    }

    /**
     * Load the news from a single news source
     *
     * @param   string $feed
     * @return  array
     * @throws  \PicoFeed\Parser\MalformedXmlException
     * @throws  \PicoFeed\Reader\UnsupportedFeedFormatException
     */
    private function loadFeed(string $feed): array
    {
        $news = [];

        $resource = $this->feedReader->download($feed);
        $parser = $this->feedReader->getParser(
            $resource->getUrl(),
            $resource->getContent(),
            $resource->getEncoding()
        );

        $feed = $parser->execute();

        foreach ($feed->items as $item) {
            $news[] = [
                'title' => $item->getTitle(),
                'description' => $this->getExcerpt($item->getContent()),
                'date' => $item->getPublishedDate()->format('d.m.Y H:m'),
                'visible' => false,
            ];
        }

        return $news;
    }

    /**
     * Get an excerpt of the news
     *
     * @param   string $description
     * @param   int $maxLength
     * @return  string
     */
    private function getExcerpt(string $description, int $maxLength = 250): string
    {
        $description = strip_tags($description);
        $description = str_replace('\n', '', $description);
        $description = trim($description);

        // Remove html entities
        $description = preg_replace("/&#?[a-z0-9]{2,8};/i", "", $description);

        $description = mb_strimwidth($description, 0, $maxLength, "...");

        return $description;
    }
}
