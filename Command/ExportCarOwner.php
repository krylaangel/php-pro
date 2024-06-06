<?php

declare(strict_types=1);

namespace Command;

use App\CarMaster\Entity\CarOwner;
use CarMaster\ServiceFactory;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'app:export-car-owner', description: 'Export all books to CSV')]
//php bin/console app:export-car-owner /var/www/html/export
class ExportCarOwner extends Command
{
    protected function configure(): void
    {
        $this->setName('app:export-car-owner')
            ->addArgument('exportDirectory', InputArgument::REQUIRED, 'Export CSV directory');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $services = new ServiceFactory();
        $styledOutput = new SymfonyStyle($input, $output);
        try {
            $entityManager = $services->createORMEntityManager();
            $query = $entityManager
                ->getRepository(CarOwner::class)
                ->createQueryBuilder('c')
                ->getQuery();


            $exportDirectory = realpath($input->getArgument('exportDirectory'));
            $exportFilename = $exportDirectory . DIRECTORY_SEPARATOR . 'owner.csv';

            if (file_exists($exportFilename)) {
                // Если файл существует, открываем его для записи
                $file = fopen($exportFilename, 'a'); // Используем 'a' для добавления в конец файла
            } else {
                // Если файл не существует, создаем его
                $file = fopen(
                    $exportFilename,
                    'w'
                ); // Используем 'w' для создания нового файла или перезаписи существующего
                if ($file === false) {
                    $lastError = error_get_last();
                    $output->writeln('<error>Error opening file: ' . $lastError['message'] . '</error>');
                    return Command::FAILURE;
                }
            }

            foreach ($query->toIterable() as $carOwner) {
                fputcsv($file, $carOwner->getOwnerInfo());
                $entityManager->detach($carOwner);
            }
            fclose($file);

            $output->writeln('<info>Export successful!</info>');

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $styledOutput->error("An error occurred: {$e->getMessage()}");
            return Command::FAILURE;
        }
    }
}