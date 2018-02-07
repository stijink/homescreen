<?php

namespace App\Command;

use App\Component\CalendarSchrink;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CalendarsSchrinkCommand extends Command
{
    private $caledarSchrink;

    /**
     * @param CalendarSchrink $caledarSchrink
     */
    public function __construct(CalendarSchrink $caledarSchrink)
    {
        parent::__construct();
        $this->caledarSchrink = $caledarSchrink;
    }


    protected function configure()
    {
        $this->setName('calendars:schrink')
             ->setDescription('Schrink the cached calendar files by removing past events');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $this->caledarSchrink->schrink();
        $io->success('Calendars have been schrinked');
    }
}
