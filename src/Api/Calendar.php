<?php

namespace Api;

use ICal\ICal;

class Calendar implements ApiInterface
{
    private $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function load(): array
    {
        $events = [];

        foreach ($this->config['calendars'] as $calendar) {
            $events = array_merge($events, $this->loadEvents($calendar['name'], $calendar['url']));
        }

        $events = $this->sortEvents($events);
        $events = $this->mergeUniqueEvents($events);

        // Reduce to a maximum number of events
        $events = array_slice($events, 0, $this->config['max_events']);

        return $events;
    }

    /**
     * Load events for a celandar.
     * We need to create a fresh ICal instance every time.
     * Otherwise we would run into timeout issues.
     *
     * @param string $calendarName
     * @param string $calendarUrl
     * @return array
     */
    private function loadEvents(string $calendarName, string $calendarUrl): array
    {
        $events = [];

        $icalendar = new ICal($calendarUrl);

        $interval = $icalendar->eventsFromInterval('6 days');
        $iCalEvents = $icalendar->sortEventsWithOrder($interval);

        foreach ((array)$iCalEvents as $iCalEvent) {
            $timestampStart = strtotime($iCalEvent->dtstart);
            $checksum = md5($iCalEvent->summary.$iCalEvent->dtstart.$iCalEvent->dtend);

            $events[$timestampStart] = [
                'name'      => $iCalEvent->summary,
                'date'      => date('Y-m-d', $timestampStart),
                'calendar'  => $calendarName,
                'timestamp' => $timestampStart,
                'checksum'  => $checksum,
            ];
        }

        return $events;
    }

    /**
     * Sort the events.
     * This is primarily nessasary if we check for multiple calendars
     *
     * @param array $events
     * @return array
     */
    private function sortEvents(array $events): array
    {
        usort($events, function ($first, $second) {
            return $first['timestamp'] - $second['timestamp'];
        });

        return $events;
    }

    /**
     * Sometimes it can happen that the same event occurs
     * in multiple calendars. In this case these events
     * get merged into one.
     *
     * @param array $events
     * @return array
     */
    private function mergeUniqueEvents(array $events): array
    {
        $uniqueEvents = [];
        $events = array_unique($events, SORT_REGULAR);

        foreach ($events as $event) {
            $checksum = $event['checksum'];
            $calendars = [];

            if (array_key_exists($checksum, $uniqueEvents)) {
                $calendars[] = $uniqueEvents[$checksum]['calendar'];
                $calendars[] = $event['calendar'];

                $uniqueEvents[$checksum]['calendar'] = implode(', ', $calendars);
                continue;
            }

            $uniqueEvents[$checksum] = $event;
        }

        return array_values($uniqueEvents);
    }
}
