<?php

namespace App\Command;

use App\Component\CalendarCache;
use App\Component\CalendarShrink;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CalendarsCacheCommand extends Command
{
    private $calendarCache;
    private $calendarShrink;

    /**
     * @param CalendarCache $calendarCache
     * @param CalendarShrink $calendarShrink
     */
    public function __construct(CalendarCache $calendarCache, CalendarShrink $calendarShrink)
    {
        parent::__construct();
        $this->calendarCache = $calendarCache;
        $this->calendarShrink = $calendarShrink;
    }

    protected function configure()
    {
        $this->setName('calendars:cache')
             ->setDescription('Populate the cache for the calendars');

        $this->addOption(
            'shrink',
            null,
            InputOption::VALUE_NONE,
            'optionally shrink the calendars by removing past events'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $this->calendarCache->populate();
        $io->success('Calendars have been populated to cache');

        if ($input->getOption('shrink')) {
            $this->calendarShrink->shrink();
            $io->success('Calendars have been shrinked');
        }
    }
}
