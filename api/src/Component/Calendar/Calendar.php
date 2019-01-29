<?php

namespace App\Component\Calendar;

use App\Component\ComponentInterface;
use App\Component\ComponentTrait;
use App\Configuration;
use App\ApiException;
use ICal\ICal;
use Psr\Log\LoggerInterface;

class Calendar implements ComponentInterface
{
    use ComponentTrait;

    private $configuration;
    private $logger;
    private $calendarLoader;

    /**
     * @param Configuration $configuration
     * @param LoggerInterface $logger
     * @param CalendarLoader $calendarLoader
     */
    public function __construct(Configuration $configuration, LoggerInterface $logger, CalendarLoader $calendarLoader)
    {
        $this->configuration = $configuration;
        $this->logger = $logger;
        $this->calendarLoader = $calendarLoader;
    }

    /**
     * @throws ApiException
     * @return array
     */
    public function load(): array
    {
        try {
            $events = [];

            foreach ($this->configuration['calendar']['calendars'] as $calendar) {
                $events = array_merge($events, $this->loadEvents($calendar));
            }

            $events = $this->sortEvents($events);
            $events = $this->mergeUniqueEvents($events);

            // Reduce to a maximum number of events
            $events = array_slice($events, 0, $this->configuration['calendar']['max_events']);

            return $events;
        } catch (\Exception $e) {
            $this->handleException($e, 'Kalender-Einträge konnten nicht bezogen werden');
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
        $content = $this->calendarLoader->get($calendar);

        $icalendar = new ICal();
        $icalendar->initString($content);

        foreach ((array) $icalendar->events() as $iCalEvent) {
            $timestampStart = strtotime($iCalEvent->dtstart);
            $timestampEnd = strtotime($iCalEvent->dtend);
            $checksum = md5($iCalEvent->summary . $iCalEvent->dtstart . $iCalEvent->dtend);

            $event = [
                'description'       => $this->sanitizeSummary($iCalEvent->summary),
                'date'              => date('Y-m-d', $timestampStart),
                'timestamp_start'   => $timestampStart,
                'timestamp_end'     => $timestampEnd,
                'checksum'          => $checksum,
            ];

            $event['persons'] = $this->getEventParticipants($calendar);
            $events[$timestampStart] = $event;
        }

        return $events;
    }

    /**
     * Remove Emoticons
     *
     * @param  string $summary
     * @return string
     */
    private function sanitizeSummary(string $summary): string
    {
        // Match Emoticons
        $regexEmoticons = '/[\x{1F600}-\x{1F64F}]/u';
        $summary = preg_replace($regexEmoticons, '', $summary);

        // Match Miscellaneous Symbols and Pictographs
        $regexSymbols = '/[\x{1F300}-\x{1F5FF}]/u';
        $summary = preg_replace($regexSymbols, '', $summary);

        // Match Transport And Map Symbols
        $regexTransport = '/[\x{1F680}-\x{1F6FF}]/u';
        $summary = preg_replace($regexTransport, '', $summary);

        // Match Miscellaneous Symbols
        $regexMisc = '/[\x{2600}-\x{26FF}]/u';
        $summary = preg_replace($regexMisc, '', $summary);

        // Match Dingbats
        $regexDingbats = '/[\x{2700}-\x{27BF}]/u';
        $summary = preg_replace($regexDingbats, '', $summary);

        return $summary;
    }

    /**
     * Determine which persons should be associated with an event
     *
     * @param   array $calendar
     * @return  array
     */
    private function getEventParticipants(array $calendar): array
    {
        $participants = [];

        foreach ($this->configuration['persons'] as $person) {
            // If a spcific person is bound to a calendar we add the person
            if (array_key_exists('person', $calendar) && $person['name'] == $calendar['person']) {
                $participants[] = $person;
                break;
            }
        }

        if (count($participants) === 0) {
            $participants = $this->filterResidentPersons($this->configuration['persons']);
        }

        return $participants;
    }

    /**
     * Filter only that persons that are of type "resident"
     *
     * @param   array $persons
     * @return  array
     */
    private function filterResidentPersons(array $persons): array
    {
        return array_filter($persons, function ($person) {
            return $person['type'] == 'resident';
        });
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
            return $first['timestamp_start'] - $second['timestamp_start'];
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
