<?php
declare(strict_types=1);

namespace App\CarMaster\Command;

use App\CarMaster\Entity\Car;
use App\CarMaster\Entity\CarOwner;
use App\CarMaster\Entity\Exception\FormatException;
use App\CarMaster\Entity\Exception\InputException;
use App\CarMaster\Entity\Validator;
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

#[AsCommand(name: 'app:create-car', description: 'Create car')]

class CreateCar extends Command
{
    protected function configure(): void
    {
        $this->setName('app:create-car')
            ->setDescription('Create car')
            ->addArgument('owner_id', InputArgument::REQUIRED, 'owner_id');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $services = new ServiceFactory();
        try {
            $entityManager = $services->createORMEntityManager();
            $faker = Factory::create();
            $validator = new Validator();
            $carOwnerRepository = $entityManager->getRepository(CarOwner::class);
            $carOwner = $carOwnerRepository->findOneBy(['ownerId' => $ownerId = $input->getArgument('owner_id')]);
            if (!$carOwner) {
                throw new EntityNotFoundException("Can not find car owner with ownerId $ownerId");
            }
            else {
                $bodyTypes = ['Sedan', 'SUV', 'Hatchback', 'Coupe', 'Convertible', 'Van', 'Truck', 'Wagon'];
                $car = new Car(
                    null,
                    $faker->regexify('^([A-Z]{2}\d{4}[A-Z]{2})$'),
                    $faker->numberBetween(1980, date('Y')),
                    $faker->company(),
                    $faker->randomElement($bodyTypes),
                    $validator
                );
                $car->setOwner($carOwner);
                $entityManager->persist($car);
                $entityManager->flush();
            }
        } catch (InputException|FormatException|LengthException $e) {
            echo "Error: " . $e->getMessage();
        } catch (ORMException $e) {
            $output->writeln('Error creating car' . $e->getMessage());
            return Command::FAILURE;
        }
        $styledOutput = new SymfonyStyle($input, $output);
        $styledOutput->title("Car create:");
        $styledOutput->writeln("License plate: {$car->getLicensePlate()}");
        $styledOutput->writeln("Year manufacture: {$car->getYearManufacture()}");
        $styledOutput->writeln("Brand: {$car->getBrand()}");
        $styledOutput->writeln("Body type: {$car->getBodyType()}");
        return Command::SUCCESS;
    }
}