<?php

declare(strict_types=1);

namespace App\Eloquent\Command;

use App\Eloquent\Eloquent;
use App\Eloquent\Model\Car;
use App\Eloquent\Model\CarOwner;
use Exception;
use Faker\Factory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

require __DIR__ . '/../../../vendor/autoload.php';

class CreateCar extends Command
{
    protected function configure(): void
    {
        $this->setName('app:create-car_e')
            ->setDescription('Create car')
            ->addArgument('owner_id', InputArgument::REQUIRED, 'owner_id');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $eloquent = new Eloquent();
        $eloquent->configure();
        try {
            $faker = Factory::create();
            $carOwner = CarOwner::query()
                ->where('owner_id', $ownerId = $input->getArgument('owner_id'))
                ->firstOr(fn() => throw new ModelNotFoundException("Can not find car owner with ownerId $ownerId"));

            $bodyTypes = ['Sedan', 'SUV', 'Hatchback', 'Coupe', 'Convertible', 'Van', 'Truck', 'Wagon'];
            $car = new Car();
            $car->license_plate = $faker->regexify('^([A-Z]{2}\d{4}[A-Z]{2})$');
            $car->year_manufacture = $faker->numberBetween(1980, date('Y'));
            $car->brand = $faker->company();
            $car->type = 'Car';
            $car->body_type = $faker->randomElement($bodyTypes);
            $car->carOwner()->associate($carOwner);
            $car->save();
        } catch (Exception $e) {
            $output->writeln('Error creating car' . $e->getMessage());
            return Command::FAILURE;
        }
        $styledOutput = new SymfonyStyle($input, $output);
        $styledOutput->title("Car create:");
        $styledOutput->writeln("License plate: {$car->licensePlate}");
        $styledOutput->writeln("Year manufacture: {$car->yearManufacture}");
        $styledOutput->writeln("Brand: {$car->brand}");
        $styledOutput->writeln("Body type: {$car->bodyType}");
        return Command::SUCCESS;
    }


}