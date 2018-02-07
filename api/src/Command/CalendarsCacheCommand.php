<?php

namespace App\Command;

use App\Component\CalendarCache;
use App\Component\CalendarSchrink;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CalendarsCacheCommand extends Command
{
    private $calendarCache;
    private $calendarSchrink;

    /**
     * @param CalendarCache $calendarCache
     * @param CalendarSchrink $calendarSchrink
     */
    public function __construct(CalendarCache $calendarCache, CalendarSchrink $calendarSchrink)
    {
        parent::__construct();
        $this->calendarCache    = $calendarCache;
        $this->calendarSchrink  = $calendarSchrink;
    }

    protected function configure()
    {
        $this->setName('calendars:cache')
             ->setDescription('Populate the cache for the calendars');

        $this->addOption(
            'schrink',
            null,
            InputOption::VALUE_NONE,
            'optionally schrink the calendars by removing past events'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $this->calendarCache->populate();
        $io->success('Calendars have been populated to cache');

        if ($input->getOption('schrink')) {
            $this->calendarSchrink->schrink();
            $io->success('Calendars have been schrinked');
        }
    }
}
