<?php

declare(strict_types=1);

namespace App\CarMaster\Command;

use App\CarMaster\Entity\Exception\FormatException;
use App\CarMaster\Entity\Exception\InputException;
use App\CarMaster\Entity\Vehicle;
use App\CarMaster\Manager\SparePartManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\Exception\ORMException;
use LengthException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'app:create-spare-part', description: 'Create spare parts')]
class CreateSparePart extends Command
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly SparePartManager $spareManager
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('app:create-spare-part')
            ->setDescription('Create spare parts')
            ->addArgument('brand', InputArgument::REQUIRED, 'brand');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $styledOutput = new SymfonyStyle($input, $output);
        try {
            $vehicle = $this->entityManager->getRepository(Vehicle::class)->findOneBy(
                ['brand' => $brand] = $input->getArgument('brand')
            );
            if (!$vehicle) {
                throw new EntityNotFoundException("Can not find c vehicle with brand $brand");
            } else {
                $newSparePart = $this->spareManager->createSpareByVehicle($vehicle);
            }
        } catch (InputException|FormatException|LengthException $e) {
            $styledOutput->error("Error: " . $e->getMessage());
            return Command::FAILURE;
        } catch (ORMException $e) {
            $output->writeln('Error creating SparePart' . $e->getMessage());
            return Command::FAILURE;
        }
        $styledOutput = new SymfonyStyle($input, $output);
        $styledOutput->title("Spare part create:");
        $styledOutput->writeln("Model: {$newSparePart->getModelPart()}");
        $styledOutput->writeln("Name: {$newSparePart->getNamePart()}");
        $styledOutput->writeln("Price: {$newSparePart->getPricePart()}");
        return Command::SUCCESS;
    }
}