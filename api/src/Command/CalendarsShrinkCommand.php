<?php

namespace App\Command;

use App\Component\CalendarShrink;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CalendarsShrinkCommand extends Command
{
    private $caledarShrink;

    /**
     * @param CalendarShrink $calendarShrink
     */
    public function __construct(CalendarShrink $calendarShrink)
    {
        parent::__construct();
        $this->caledarShrink = $calendarShrink;
    }

    protected function configure()
    {
        $this->setName('calendars:shrink')
             ->setDescription('Shrink the cached calendar files by removing past events');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $this->caledarShrink->shrink();
        $io->success('Calendars have been shrinked');
    }
}
