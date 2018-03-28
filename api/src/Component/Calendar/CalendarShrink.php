<?php

namespace App\Component\Calendar;

use ICal\Event;
use ICal\ICal;

class CalendarShrink
{
    private $icalTemplate = '
BEGIN:VCALENDAR
VERSION:2.0
PRODID:https://github.com/stijink/homescreen
METHOD:PUBLISH%events%
END:VCALENDAR';

    /**
     * Shrink the contents of a calendar by removing past events
     *
     * @param   string $content
     * @param   int $maxdays
     * @return  string
     */
    public function shrink(string $content, int $maxdays): string
    {
        $shrinked = '';

        $ical = new ICal();
        $ical->initString($content);

        $endDate = new \DateTime();
        $endDate->add(new \DateInterval('P' . $maxdays . 'D'));

        // Remove past events and  pnly keep future events of the upcoming x days
        $interval = $ical->eventsFromRange(date('Y-m-d'), $endDate->format('Y-m-d'));
        $events = $ical->sortEventsWithOrder($interval);

        foreach ($events as $event) {
            $shrinked .= "\nBEGIN:VEVENT\n" . $this->formatEvent($event) . 'END:VEVENT';
        }

        return trim(str_replace('%events%', $shrinked, $this->icalTemplate));
    }

    /**
     * Format a single event
     *
     * @param   Event $event
     * @return  string
     */
    private function formatEvent(Event $event): string
    {
        $data = [
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
        ];

        $data = array_map('trim', $data); // Trim all values
        $data = array_filter($data);      // Remove any blank values
        $output = '';

        foreach ($data as $key => $value) {
            $output .= "${key}:${value}\n";
        }

        return $output;
    }
}
