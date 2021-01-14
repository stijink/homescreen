<?php

namespace App\Component;

use Exception;
use App\Configuration;
use App\ApiException;
use Laminas\Feed\Reader\Reader;

class News implements ComponentInterface
{
    public function __construct(private Configuration $configuration, private Reader $feedReader)
    {
    }

    /**
     * @throws  ApiException
     * @return  array
     */
    public function load(): array
    {
        try {
            $news = [];

            foreach ($this->configuration['news'] as $feed) {
                $news = array_merge($news, $this->loadFeed($feed));
            }

            shuffle($news);

            return $news;
        } catch (Exception) {
            throw new ApiException('Nachrichten konnten nicht bezogen werden');
        }
    }

    /**
     * Load the news from a single news source
     *
     * @param string $feedUrl
     * @return  array
     */
    private function loadFeed(string $feedUrl): array
    {
        $news = [];
        $feed = Reader::importFile($feedUrl);

        foreach ($feed as $item) {
            $news[] = [
                'title'       => $item->getTitle(),
                'description' => $this->getExcerpt(description: $item->getDescription()),
                'date'        => $item->getDateModified()->format('d.m.Y H:m'),
                'visible'     => false,
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

        $description = preg_replace('/&#?[a-z0-9]{2,8};/i', '', $description);

        return mb_strimwidth($description, 0, $maxLength, '...');
    }
}
