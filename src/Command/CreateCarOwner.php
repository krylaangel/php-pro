<?php

namespace App\Command;

use App\CarMaster\Entity\CarOwner;
use App\CarMaster\Entity\Exception\FormatException;
use App\CarMaster\Entity\Exception\InputException;
use App\CarMaster\Entity\Validator;
use CarMaster\ServiceFactory;
use Doctrine\ORM\Exception\ORMException;
use Faker\Factory;
use LengthException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

require __DIR__ . '/../../vendor/autoload.php';

class CreateCarOwner extends Command
{
    protected function configure(): void
    {
        $this->setName('app:create-car-owner')
            ->setDescription('Create car owner');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $services = new ServiceFactory();
        try {
            $entityManager = $services->createORMEntityManager();
            $faker = Factory::create();
            $validator = new Validator();
            $owner = new CarOwner(null,
                $faker->firstName,
                $faker->lastName,
                $faker->password,
                $faker->regexify('380[0-9]{9}'),
//            380661368736,
                $faker->email,
                $validator,
            );
            $entityManager->persist($owner);
            $entityManager->flush();
        } catch (InputException|FormatException|LengthException $e) {
            echo "Error: " . $e->getMessage();
        } catch (ORMException $e) {
            $output->writeln('Error creating SparePart' . $e->getMessage());
            return Command::FAILURE;
        }
        $styledOutput = new SymfonyStyle($input, $output);
        $styledOutput->title("Car owner create:");
        $styledOutput->writeln("First name: {$owner->getFirstName()}");
        $styledOutput->writeln("last name: {$owner->getLastName()}");
        $styledOutput->writeln("password: {$owner->getPassword()}");
        $styledOutput->writeln("phone number: {$owner->getContactNumber()}");
        $styledOutput->writeln("email: {$owner->getOwnerEmail()}");


        return Command::SUCCESS;
    }
}