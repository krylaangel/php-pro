<?php
declare(strict_types=1);

namespace App\Command;

use App\CarMaster\Entity\Car;
use App\CarMaster\Entity\SparePart;
use App\CarMaster\Entity\Validator;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

require __DIR__ . '/../../vendor/autoload.php';
#[AsCommand(name: 'app:car:info', description: 'Displays information about cars')]

class CarInformationCommand extends Command
{
    protected function configure(): void
    {
        $this->setName('app:car:info')
            ->setDescription('Displays information about cars');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $car = new Car('I2II5KK', 2017, 'Chevrolet', 'Sedan', new Validator());
        $car->addSparePart(new SparePart('Engine Oil', 'Some Model', 50, new Validator()));

        // Отримуємо інформацію про автомобіль та виводимо її в консоль
        $output->writeln('<info>Car information:</info>');
        foreach ($car->getInformation() as $key => $value) {
            $output->writeln("$key: $value");
        }
        return Command::SUCCESS;
    }
}