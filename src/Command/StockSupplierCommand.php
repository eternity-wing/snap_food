<?php

namespace App\Command;

use App\Service\StockSupplier\StockSupplier;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:stock-supplier',
    description: 'Add a short description for your command',
)]
class StockSupplierCommand extends Command
{
    const SLEEP_TIME = 15 * 60;

    public function __construct(private StockSupplier $stockSupplier)
    {
        parent::__construct();

    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        while (true){
            $io->note('Stock supplier starts running');
            $this->stockSupplier->restock();
            $io->success('Stock supplier finished');
            sleep(self::SLEEP_TIME);
        }
    }
}
