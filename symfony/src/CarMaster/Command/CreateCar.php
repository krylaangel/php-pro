<?php

declare(strict_types=1);

namespace App\CarMaster\Command;

use App\CarMaster\Entity\CarOwner;
use App\CarMaster\Entity\Exception\FormatException;
use App\CarMaster\Entity\Exception\InputException;
use App\CarMaster\Manager\VehicleManager;
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

#[AsCommand(name: 'app:create-car', description: 'Create car')]
class CreateCar extends Command
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly VehicleManager $vehicleManager
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('app:create-car')
            ->setDescription('Create car')
            ->addArgument('owner_id', InputArgument::REQUIRED, 'owner_id');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $styledOutput = new SymfonyStyle($input, $output);

        try {
            $carOwner = $this->entityManager->getRepository(CarOwner::class)->findOneBy(
                ['ownerId' => $ownerId = $input->getArgument('owner_id')]
            );
            if (!$carOwner) {
                throw new EntityNotFoundException("Can not find car owner with ownerId $ownerId");
            } else {
                $newCar = $this->vehicleManager->createVehicleByOwner($carOwner);
            }
        } catch (InputException|FormatException|LengthException $e) {
            $styledOutput->error("Error: " . $e->getMessage());
            return Command::FAILURE;
        } catch (ORMException $e) {
            $styledOutput->error('Error creating car: ' . $e->getMessage());
            return Command::FAILURE;
        }
        $styledOutput->title("Car create:");
        $styledOutput->writeln("License plate: {$newCar->getLicensePlate()}");
        $styledOutput->writeln("Year manufacture: {$newCar->getYearManufacture()}");
        $styledOutput->writeln("Brand: {$newCar->getBrand()}");
        $styledOutput->writeln("Body type: {$newCar->getBodyType()}");
        return Command::SUCCESS;
    }
}