<?php

namespace App\Command;

use App\Service\DataInitializer\BasicDataInitializer;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:data-initializer',
    description: 'Add a short description for your command',
)]
class DataInitializerCommand extends Command
{
    public function __construct(private BasicDataInitializer $dataInitializer)
    {
        parent::__construct();

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->note('DataInitializerCommand starts');
        $this->dataInitializer->initialize();
        $io->success('Data Initialization has finished.');

        return Command::SUCCESS;
    }
}
