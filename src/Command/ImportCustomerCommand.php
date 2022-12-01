<?php

declare(strict_types=1);

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use App\Service\Customer\CustomerImporterInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:import-customer')]
class ImportCustomerCommand extends Command
{
    public function __construct(protected CustomerImporterInterface $customerImporter)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->customerImporter->import();

        return Command::SUCCESS;
    }
}
