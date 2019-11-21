<?php

namespace App\Command;

use App\Component\Calendar\CalendarLoader;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Command\LockableTrait;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CalendarsLoadCommand extends Command
{
    use LockableTrait;

    private $calendarLoader;

    /**
     * @param CalendarLoader $calendarLoader
     */
    public function __construct(CalendarLoader $calendarLoader)
    {
        parent::__construct();
        $this->calendarLoader = $calendarLoader;
    }

    protected function configure()
    {
        $this
            ->setName('calendars:load')
            ->setDescription('Preload and cache the calendars contents');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        if (! $this->lock()) {
            $io->writeln('The command is already running in another process.');

            return 0;
        }

        $this->calendarLoader->clearCache();
        $this->calendarLoader->populateCache();

        $io->success('Successfully loaded the calendars contents');
        $this->release();

        return 0;
    }
}
