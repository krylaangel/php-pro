<?php

declare(strict_types=1);

namespace App\CarMaster\Command;

use App\CarMaster\Entity\Exception\FormatException;
use App\CarMaster\Entity\Exception\InputException;
use App\CarMaster\Manager\OwnerManager;
use LengthException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'app:create-car-owner', description: 'Create car owner')]
class CreateCarOwner extends Command
{
    public function __construct(
        private readonly OwnerManager $ownerManager
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('app:create-car-owner')
            ->setDescription('Create car owner');
    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output,

    ): int {
        try {
            $newOwner = $this->ownerManager->createOwner();
            $styledOutput = new SymfonyStyle($input, $output);
            $styledOutput->title("Car owner create:");
            $styledOutput->writeln("First name: {$newOwner->getFirstName()}");
            $styledOutput->writeln("last name: {$newOwner->getLastName()}");
            $styledOutput->writeln("password: {$newOwner->getPassword()}");
            $styledOutput->writeln("phone number: {$newOwner->getContactNumber()}");
            $styledOutput->writeln("email: {$newOwner->getOwnerEmail()}");
        } catch (InputException|FormatException|LengthException $e) {
            echo "Error: " . $e->getMessage();
        }
        return Command::SUCCESS;
    }
}