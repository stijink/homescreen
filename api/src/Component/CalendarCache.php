<?php

namespace App\Component;

use App\Configuration;
use Psr\Log\LoggerInterface;
use Symfony\Component\Cache\Simple\FilesystemCache;

class CalendarCache
{
    private $calendarConfig;
    private $cache;
    private $logger;

    /**
     * @param Configuration $configuration
     * @param FilesystemCache $cache
     * @param LoggerInterface $logger
     */
    public function __construct(Configuration $configuration, FilesystemCache $cache, LoggerInterface $logger)
    {
        $this->calendarConfig = $configuration['calendar'];
        $this->cache = $cache;
        $this->logger = $logger;
    }

    /**
     * Populate all calendars to the cache
     */
    public function populate()
    {
        foreach ($this->calendarConfig['calendars'] as $calendar) {
            $content = $this->load($calendar);
            $this->set($calendar, $content);
        }
    }

    /**
     * Get the contents of one calendar from the cache
     *
     * @param   array $calendar
     * @return  string
     */
    public function get(array $calendar): string
    {
        $cacheName = 'calendar_' . $calendar['name'];

        if (! $this->cache->has($cacheName)) {
            $content = $this->load($calendar);
            $this->set($calendar, $content);
        }

        $content = $this->cache->get($cacheName);

        $this->logger->debug(sprintf(
            'Calendar Cache GET: %s (%d kBytes)',
            $calendar['name'],
            (strlen($content) / 1024)
        ));

        return $this->cache->get($cacheName);
    }

    /**
     * Populate one calendar to the cache
     *
     * @param array $calendar
     * @param string $content
     */
    public function set(array $calendar, string $content)
    {
        $cacheName = 'calendar_' . $calendar['name'];

        $this->logger->debug(sprintf(
            'Calendar Cache SET: %s (%d kBytes)',
            $calendar['name'],
            (strlen($content) / 1024)
        ));

        $this->cache->set($cacheName, $content);
    }

    /**
     * Load the content of one calendar
     *
     * @param   array $calendar
     * @return  string
     */
    private function load(array $calendar): string
    {
        return file_get_contents($calendar['url']);
    }
}
