<?php

namespace App\Component\Calendar;

use App\Configuration;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\CacheInterface;

class CalendarLoader
{
    private $calendarConfig;
    private $calendarShrink;
    private $cache;
    private $logger;

    /**
     * @param Configuration $configuration
     * @param CalendarShrink $calendarShrink
     * @param CacheInterface $cache
     * @param LoggerInterface $logger
     */
    public function __construct(
        Configuration $configuration,
        CalendarShrink $calendarShrink,
        CacheInterface $cache,
        LoggerInterface $logger
    ) {
        $this->calendarConfig = $configuration['calendar'];
        $this->calendarShrink = $calendarShrink;
        $this->cache = $cache;
        $this->logger = $logger;
    }

    /**
     * Download and cache the contents of all calendars
     */
    public function load()
    {
        foreach ($this->calendarConfig['calendars'] as $calendar) {
            $content = $this->download($calendar);
            $content = $this->calendarShrink->shrink($content, $this->calendarConfig['max_days']);
            $this->set($calendar, $content);
        }
    }

    /**
     * Clear the cache
     */
    public function clearCaches()
    {
        $this->cache->clear();
    }

    /**
     * Get the contents of one calendar from the cache
     *
     * @param   array $calendar
     * @return  string|null
     */
    public function get(array $calendar): ?string
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
     * Download the content of one calendar
     *
     * @param   array $calendar
     * @return  string|null
     */
    public function download(array $calendar): ?string
    {
        return file_get_contents($calendar['url']);
    }
}