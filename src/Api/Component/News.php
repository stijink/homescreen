<?php

namespace Api\Component;

use PicoFeed\Reader\Reader;

class News implements ComponentInterface
{
    private $feedReader;
    private $config;

    public function __construct(Reader $feedReader, array $config)
    {
        $this->feedReader = $feedReader;
        $this->config = $config;
    }

    public function load(): array
    {
        $news = [];

        foreach ($this->config['feeds'] as $feed) {
            $news = array_merge($news, $this->loadFeed($feed));
        }

        shuffle($news);

        return $news;
    }

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
                'description' => $this->getSummary($item->getContent()),
                'date' => $item->getPublishedDate()->format('d.m.Y H:m'),
                'visible' => false,
            ];
        }

        return $news;
    }

    private function getSummary(string $description, int $maxLength = 250): string
    {
        $description = strip_tags($description);
        $description = str_replace('\n', '', $description);
        $description = trim($description);

        if (strlen($description) > $maxLength) {
            $description = substr($description, 0, $maxLength).'...';
        }

        return $description;
    }
}
