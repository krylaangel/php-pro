<?php

declare(strict_types=1);

namespace App\Command;

use App\CarMaster\Entity\SparePart;
use CarMaster\ServiceFactory;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

require __DIR__ . '/../../vendor/autoload.php';

#[AsCommand(name: 'app:find-spare-part', description: 'Find spare parts by brand vehicles')]
class FindSparePartForVehicle extends Command
{

    protected function configure(): void
    {
        $this->setName('app:find-spare-part')
            ->setDescription('Find spare parts by brand vehicles')
            ->addArgument('brand', InputArgument::REQUIRED, 'The brand to search for');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $services = new ServiceFactory();
        $styledOutput = new SymfonyStyle($input, $output);

        try {
            $entityManager = $services->createORMEntityManager();
            $queryBuilder = $entityManager
                ->getRepository(SparePart::class)
                ->createQueryBuilder('s');
            $brand = $input->getArgument('brand');
            $queryBuilder
                ->join('s.vehicles', 'v')
                ->where('v.brand = :brand')
                ->setParameter('brand', $brand);
            $spareParts = $queryBuilder->getQuery()->getResult();

            if (empty($spareParts)) {
                $styledOutput->error("No spare parts found for brand '{$brand}'");
                return Command::FAILURE;
            }

            $styledOutput->info($queryBuilder->getQuery()->getSQL());

            $styledOutput->title("For '{$brand}' of car there are such parts:");
            foreach ($spareParts as $sparePart) {
                if ($sparePart instanceof SparePart) {
                    $this->displaySparePartInfo($sparePart, $styledOutput);
                }
            }

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $styledOutput->error("An error occurred: {$e->getMessage()}");
            return Command::FAILURE;
        }
    }
    private function displaySparePartInfo(SparePart $sparePart, SymfonyStyle $output): void
    {
        $partInfo = $sparePart->getPartInfo();
        $rows = [];
        foreach ($partInfo as $key => $value) {
            $rows[] = [$key, $value];
        }

        $output->table([], $rows);
    }
}