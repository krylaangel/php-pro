<?php

namespace App\Command;

use App\CarMaster\Repository\Exception\LogicErrorException;
use CarMaster\Repository\SparePartRepository;
use CarMaster\ServiceFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;


require __DIR__ . '/../../vendor/autoload.php';

class CreatSparePart extends Command
{
    protected function configure(): void
    {
        $this->setName('app:spare-part')
            ->setDescription('Displays information about spare part');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $services = new ServiceFactory();
        $styledOutput = new SymfonyStyle($input, $output);

        try {
            $sparePartRepository = new SparePartRepository($services->createPDO());
            $sparePart = $sparePartRepository->findByModel();

            if (empty($sparePart)) {
                $styledOutput->warning("No spare parts found!");
                return Command::FAILURE;
            }

            $styledOutput->writeln('<info>Spare Parts:</info>');
            $spareParts = [];
            foreach ($spareParts as $sparePart) {
                $styledOutput->writeln('ID: ' . $sparePart->getId());
                $styledOutput->writeln('Name: ' . $sparePart->getNamePart());
                $styledOutput->writeln('Model: ' . $sparePart->getModelPart());
                $styledOutput->writeln('Price: ' . $sparePart->getPricePart());
                $styledOutput->writeln('---------------------------');
            }
        } catch (LogicErrorException) {
            return Command::FAILURE;
        }
        return Command::SUCCESS;
    }
}
