<?php

namespace App\Command;

use CarMaster\Car;
use CarMaster\CarOwner;
use CarMaster\SparePart;
use CarMaster\Validator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

require __DIR__ . '/../../vendor/autoload.php';

class CarInformationCommand extends Command
{
//    protected static $defaultName;
//    protected static $defaultDescription;
    protected function configure(): void
    {
        $this->setName('app:car:info')
             ->setDescription('Displays information about cars');
    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $car = new Car('I2II5KK', 2017, 'Chevrolet', 'Sedan', new Validator());
        $car->addSparePart(new SparePart('Engine Oil', 'Some Model', 50, new Validator()));

        // Створюємо екземпляр класу CarOwner
        $carOwner = new CarOwner('John Doe', 123456789012, 'john@example.com', new Validator());
        $carOwner->addVehicle($car);

        // Отримуємо інформацію про автомобіль та виводимо її в консоль
        $output->writeln('<info>Car information:</info>');
        foreach ($car->getInformation() as $key => $value) {
            $output->writeln("$key: $value");
        }
        return Command::SUCCESS;
    }
}