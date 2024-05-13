<?php

namespace App\Command;

use App\CarMaster\Entity\SparePart;
use CarMaster\ServiceFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

require __DIR__ . '/../../vendor/autoload.php';

class FindSparePart extends Command
{

    protected function configure(): void
    {
        $this->setName('app:find-spare-part')
            ->setDescription('Find spare parts by model')
            ->addArgument('model', InputArgument::REQUIRED, 'The model to search for');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $services = new ServiceFactory();
        $model = $input->getArgument('model');
        try {
            $entityManager = $services->createORMEntityManager();
        } catch (\Exception $e) {
            $output->writeln('Error creating SparePartRepository: ' . $e->getMessage());
            return Command::FAILURE;
        }
        $sparePart = $entityManager->getRepository(SparePart::class)
            ->findOneBy(array('modelPart' => $model));
        if (!$sparePart) {
            $output->writeln("No spare parts found for model '{$model}'");
            return Command::FAILURE;
        }
        $styledOutput = new SymfonyStyle($input, $output);

        $styledOutput->title("Spare part found for model '{$model}':");
        $styledOutput->writeln("Model: <info>{$model}</info>");
        $styledOutput->writeln("Name: {$sparePart->getNamePart()}");
        $styledOutput->writeln("Price: {$sparePart->getPricePart()}");

        return Command::SUCCESS;
    }
}