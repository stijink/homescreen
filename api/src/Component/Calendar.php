<?php

namespace Api\Component;

use Api\Exception\ApiComponentException;
use ICal\ICal;

class Calendar implements ComponentInterface
{
    private $config;
    private $persons;

    /**
     * @param array $config
     * @param array $persons
     */
    public function __construct(array $config, array $persons)
    {
        $this->config = $config;
        $this->persons = $persons;
    }

    /**
     * @return array
     * @throws ApiComponentException
     */
    public function load(): array
    {
        try {
            $events = [];

            foreach ($this->config['calendars'] as $calendar) {
                $events = array_merge($events, $this->loadEvents($calendar));
            }

            $events = $this->sortEvents($events);
            $events = $this->mergeUniqueEvents($events);

            // Reduce to a maximum number of events
            $events = array_slice($events, 0, $this->config['max_events']);

            return $events;
        } catch (\Exception $e) {
            throw new ApiComponentException('Kalender-Einträge konnten nicht bezogen werden');
        }
    }

    /**
     * Load events for a celandar.
     * We need to create a fresh ICal instance every time.
     * Otherwise we would run into timeout issues.
     *
     * @param   array $calendar
     * @return  array
     */
    private function loadEvents(array $calendar): array
    {
        $events = [];

        $icalendar = new ICal($calendar['url']);

        $intervalInDays = $this->config['max_days'] . ' days';
        $interval = $icalendar->eventsFromInterval($intervalInDays);
        $iCalEvents = $icalendar->sortEventsWithOrder($interval);

        foreach ((array) $iCalEvents as $iCalEvent) {
            $timestampStart = strtotime($iCalEvent->dtstart);
            $checksum = md5($iCalEvent->summary.$iCalEvent->dtstart.$iCalEvent->dtend);

            $event = [
                'description' => $iCalEvent->summary,
                'date'        => date('Y-m-d', $timestampStart),
                'timestamp'   => $timestampStart,
                'checksum'    => $checksum,
            ];

            $event['persons'] = $this->getEventParticipants($calendar);
            $events[$timestampStart] = $event;
        }

        return $events;
    }

    /**
     * Determine which persons should be associated with an event
     *
     * @param   array $calendar
     * @return  array
     */
    private function getEventParticipants(array $calendar): array
    {
        // If a spcific person is bound to a calendar we add the person
        if ($calendar['person'] !== null) {
            return [$this->persons[$calendar['person']]];
        }

        $participants = [];

        // If no person is specified for the calendar we add all persons that are marked
        // as "residents". We assume the events for this calendar are of general interest.
        foreach ($this->persons as $person) {
            if ($person['type'] == 'resident') {
                $participants[] = $person;
            }
        }

        return $participants;
    }

    /**
     * Sort the events.
     * This is primarily nessasary if we check for multiple calendars.
     *
     * @param array $events
     *
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
     * Also the persons from both calendars are added
     *
     * @param array $events
     *
     * @return array
     */
    private function mergeUniqueEvents(array $events): array
    {
        $uniqueEvents = [];
        $events = array_unique($events, SORT_REGULAR);

        foreach ($events as $event) {
            $checksum = $event['checksum'];
            $persons = [];

            if (array_key_exists($checksum, $uniqueEvents)) {
                $persons = array_merge($uniqueEvents[$checksum]['persons'], $event['persons']);
                $uniqueEvents[$checksum]['persons'] = $persons;
                continue;
            }

            $uniqueEvents[$checksum] = $event;
        }

        return array_values($uniqueEvents);
    }
}
