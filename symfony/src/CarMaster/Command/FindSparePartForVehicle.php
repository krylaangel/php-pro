<?php

declare(strict_types=1);

namespace App\CarMaster\Command;

use App\CarMaster\Manager\SparePartManager;
use App\CarMaster\Manager\VehicleManager;
use App\Repository\SparePartRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'app:find-spare-part', description: 'Find spare parts by license_plate vehicles')]
class FindSparePartForVehicle extends Command
{
    public function __construct(
        private readonly SparePartManager $sparePartManager
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('app:find-spare-part')
            ->setDescription('Find spare parts by brand vehicles')
            ->addArgument('license_plate', InputArgument::REQUIRED, 'The brand to search for');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $styledOutput = new SymfonyStyle($input, $output);
        $licensePlate = $input->getArgument('license_plate');
        try {
            $findSpare = $this->sparePartManager->getFindPartsForCar($licensePlate);
            if (empty($findSpare)) {
                $styledOutput->error("No spare parts found for license plate '{$licensePlate}'");
                return Command::FAILURE;
            }

            $styledOutput->title("For '{$licensePlate}' of car there are such parts:");

            foreach ($findSpare as $spare) {
                $styledOutput->writeln($spare);
            }
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $styledOutput->error("An error occurred: {$e->getMessage()}");
            return Command::FAILURE;
        }
    }

}