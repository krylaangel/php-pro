<?php
declare(strict_types=1);

namespace Command;

use App\CarMaster\Entity\SparePart;
use CarMaster\ServiceFactory;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\Exception\ORMException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'app:remove-spare-part', description: 'remove spare parts')]

class RemoveSparePart extends Command
{
    protected function configure(): void
    {
        $this->setName('app:remove-spare-part')
            ->setDescription('remove spare parts')
            ->addArgument('spare_part_id', InputArgument::REQUIRED, 'spare_part_id');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $services = new ServiceFactory();
        try {
            $entityManager = $services->createORMEntityManager();
            $sparePartRepository = $entityManager->getRepository(SparePart::class);
            $sparePart = $sparePartRepository->findOneBy(['partId' => $partId = $input->getArgument('spare_part_id')]);

            if (!$sparePart) {
                throw new EntityNotFoundException("Can not find c spare part with spare_part_id $partId");
            } else {
                $entityManager->remove($sparePart);
                $entityManager->flush();
            }
        } catch (ORMException $e) {
            $output->writeln('Error remove SparePart' . $e->getMessage());
            return Command::FAILURE;
        }
        $styledOutput = new SymfonyStyle($input, $output);
        $styledOutput->title("Spare part removed:");
        $styledOutput->writeln("spare part id: {$partId}");
        return Command::SUCCESS;
    }
}