<?php

namespace App\Component;

use App\Configuration;
use ICal\Event;
use ICal\ICal;

class CalendarSchrink
{
    private $calendarConfig;
    private $calendarCache;

    private $icalTemplate = "
BEGIN:VCALENDAR
VERSION:2.0
PRODID:https://github.com/stijink/homescreen
METHOD:PUBLISH%events%
END:VCALENDAR";

    /**
     * @param Configuration $configuration
     * @param CalendarCache $calendarCache
     */
    public function __construct(Configuration $configuration, CalendarCache $calendarCache)
    {
        $this->calendarConfig = $configuration['calendar'];
        $this->calendarCache  = $calendarCache;
    }

    /**
     * Schrink all calendars by removing past events
     */
    public function schrink()
    {
        foreach ($this->calendarConfig['calendars'] as $calendar) {
            $schrinked = $this->schrinkCalendar($calendar);
            $this->calendarCache->set($calendar, $schrinked);
        }
    }

    /**
     * Process a single calendar
     *
     * @param   array $calendar
     * @return  string
     */
    private function schrinkCalendar(array $calendar): string
    {
        $schrinked = null;
        $content = $this->calendarCache->get($calendar);

        $ical = new ICal();
        $ical->initString($content);

        $interval = $ical->eventsFromRange(date('Y-m-d'), false);
        $events = $ical->sortEventsWithOrder($interval);

        foreach ($events as $event) {
            $schrinked .= "\nBEGIN:VEVENT\n" . $this->formatEvent($event) . "END:VEVENT";
        }

        return trim(str_replace('%events%', $schrinked, $this->icalTemplate));
    }

    /**
     * Format a single event
     *
     * @param   Event $event
     * @return  string
     */
    private function formatEvent(Event $event) : string
    {
        $data = array(
            'SUMMARY'       => $event->summary,
            'DTSTART'       => $event->dtstart,
            'DTEND'         => $event->dtend,
            'DURATION'      => $event->duration,
            'DTSTAMP'       => $event->dtstamp,
            'UID'           => $event->uid,
            'CREATED'       => $event->created,
            'LAST-MODIFIED' => $event->lastmodified,
            'DESCRIPTION'   => $event->description,
            'LOCATION'      => $event->location,
            'SEQUENCE'      => $event->sequence,
            'STATUS'        => $event->status,
            'TRANSP'        => $event->transp,
            'ORGANIZER'     => $event->organizer,
            'ATTENDEE'      => $event->attendee,
        );

        $data   = array_map('trim', $data); // Trim all values
        $data   = array_filter($data);      // Remove any blank values
        $output = '';

        foreach ($data as $key => $value) {
            $output .= "${key}:${value}\n";
        }

        return $output;
    }
}
