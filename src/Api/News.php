<?php

namespace Api;

class News implements ApiInterface
{
    private $config;

    public function __construct(array $config)
    {
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
        $articles = \Feed::loadRss($feed);

        foreach ($articles->item as $item) {
            $news[] = [
                'title' => (string) $item->title,
                'description' => $this->formatDescription((string) $item->description),
                'date' => date('d.m.Y H:m', (int) $item->timestamp),
                'visible' => false,
            ];
        }

        return $news;
    }

    private function formatDescription(string $description): string
    {
        $description = strip_tags($description);
        $description = str_replace('\r\n', '', $description);
        $description = trim($description);

        return $description;
    }
}
