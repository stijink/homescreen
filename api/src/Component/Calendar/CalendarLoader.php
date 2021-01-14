<?php

namespace App\Component\Calendar;

use App\Configuration;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class CalendarLoader
{
    private array $calendarConfig;

    public function __construct(
        private Configuration $configuration,
        private CalendarShrink $calendarShrink,
        private CacheInterface $cache,
        private LoggerInterface $logger
    ) {
        $this->calendarConfig = $configuration['calendar'];
    }

    /**
     * Download and cache the contents of all calendars
     */
    public function populateCache()
    {
        foreach ($this->calendarConfig['calendars'] as $calendar) {
            $this->get($calendar);
        }
    }

    /**
     * Clear the cache
     */
    public function clearCache()
    {
        foreach ($this->calendarConfig['calendars'] as $calendar) {
            $cacheName = 'calendar_' . $calendar['name'];
            $this->cache->delete($cacheName);
        }
    }

    /**
     * Get the contents of one calendar
     *
     * @param array $calendar
     * @return  string|null
     */
    public function get(array $calendar): ?string
    {
        $cacheName = 'calendar_' . $calendar['name'];

        $content = $this->cache->get($cacheName, function (ItemInterface $item) use ($calendar): string {
            $content = file_get_contents($calendar['url']);
            $content = $this->calendarShrink->shrink($content, $this->calendarConfig['max_days']);

            $this->logger->debug(sprintf(
                'Calendar Cache SET: %s (%d kBytes)',
                $calendar['name'],
                (strlen($content) / 1024)
            ));

            return $content;
        });

        return $content;
    }
}
