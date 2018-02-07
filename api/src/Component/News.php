<?php

namespace App\Component;

use App\Configuration;
use App\ApiComponentException;
use PicoFeed\Reader\Reader;
use Psr\Log\LoggerInterface;

class News implements ComponentInterface
{
    use ComponentTrait;

    private $configuration;
    private $logger;
    private $feedReader;

    /**
     * @param Configuration $configuration
     * @param LoggerInterface $logger
     * @param Reader $feedReader
     */
    public function __construct(Configuration $configuration, LoggerInterface $logger, Reader $feedReader)
    {
        $this->configuration = $configuration;
        $this->logger = $logger;
        $this->feedReader = $feedReader;
    }

    /**
     * @return  array
     * @throws  ApiComponentException
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
        } catch (\Exception $e) {
            $this->handleException($e, 'Nachrichten konnten nicht bezogen werden');
        }
    }

    /**
     * Load the news from a single news source
     *
     * @param   string $feed
     * @return  array
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

        $description = preg_replace("/&#?[a-z0-9]{2,8};/i", "", $description);
        $description = mb_strimwidth($description, 0, $maxLength, "...");

        return $description;
    }
}
