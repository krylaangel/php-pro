<?php
declare(strict_types=1);

namespace App\Command;

use App\CarMaster\Entity\Exception\FormatException;
use App\CarMaster\Entity\Exception\InputException;
use App\CarMaster\Entity\SparePart;
use App\CarMaster\Entity\Validator;
use App\CarMaster\Entity\Vehicle;
use CarMaster\ServiceFactory;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\Exception\ORMException;
use Faker\Factory;
use LengthException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

require __DIR__ . '/../../vendor/autoload.php';
#[AsCommand(name: 'app:create-spare-part', description: 'Create spare parts')]

class CreateSparePart extends Command
{
    protected function configure(): void
    {
        $this->setName('app:create-spare-part')
            ->setDescription('Create spare parts')
            ->addArgument('vehicle_id', InputArgument::REQUIRED, 'vehicle_id');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $services = new ServiceFactory();
        try {
            $entityManager = $services->createORMEntityManager();
            $faker = Factory::create();
            $VehicleRepository = $entityManager->getRepository(Vehicle::class);
            $vehicle = $VehicleRepository->findOneBy(['vehicleId' => $vehicleId = $input->getArgument('vehicle_id')]);
            if (!$vehicle) {
                throw new EntityNotFoundException("Can not find c vehicle with vehicle_id $vehicleId");
            }
            else {
                $validator = new Validator();
                $sparePart = new SparePart(
                null,
                    $faker->word,
                    $faker->company,
                    $faker->randomFloat(),
                    $validator
                );
                $sparePart->addVehicle($vehicle);
                $entityManager->persist($sparePart);
                $entityManager->flush();
            }
        } catch (InputException|FormatException|LengthException $e) {
            echo "Error: " . $e->getMessage();
        } catch (ORMException $e) {
            $output->writeln('Error creating SparePart' . $e->getMessage());
            return Command::FAILURE;
        }
        $styledOutput = new SymfonyStyle($input, $output);
        $styledOutput->title("Spare part create:");
        $styledOutput->writeln("Model: {$sparePart->getModelPart()}");
        $styledOutput->writeln("Name: {$sparePart->getNamePart()}");
        $styledOutput->writeln("Price: {$sparePart->getPricePart()}");
        return Command::SUCCESS;
    }
}