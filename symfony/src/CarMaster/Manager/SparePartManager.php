<?php

declare(strict_types=1);

namespace App\CarMaster\Manager;

use App\Repository\VehicleRepository;
use App\CarMaster\Entity\SparePart;
use App\CarMaster\Entity\Vehicle;
use App\Repository\SparePartRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Generator;
use phpDocumentor\Reflection\Types\Collection;

readonly class SparePartManager
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private Generator $faker,
        private SparePartRepository $sparePartRepository,
        private VehicleRepository $vehicleRepository
    ) {
    }

    /*
        * создаем новую запчасть для конкретной машины.
        */
    public function createPartByVehicle(Vehicle $vehicle): SparePart
    {
        $sparePart = new SparePart();
        $sparePart->setNamePart($this->faker->word);
        $sparePart->setModelPart($this->faker->company);
        $sparePart->setPricePart($this->faker->randomFloat());;

        $sparePart->addVehicle($vehicle);
        $this->entityManager->persist($sparePart);
        $this->entityManager->flush();
        return $sparePart;
    }

    public function getFindPartsForCar(string $licensePlate): array
    {
        $spareParts = $this->sparePartRepository->findPartsForCar($licensePlate);
        $result = [];
        foreach ($spareParts as $sparePart) {
            $partInfo = $sparePart->getPartInfo();
            $result [] = $partInfo;
        }
        return $result;
    }

    public function connectionWithVehicle(SparePart $sparePart): void
    {
        foreach ($sparePart->getVehicles() as $vehicle) {
            $vehicle->addSpareParts($sparePart);
            $this->entityManager->persist($vehicle);
        }
        $this->entityManager->flush();
        $this->entityManager->clear();
    }

   public function removePartByDB(SparePart $sparePart): void
    {
        $this->entityManager->remove($sparePart);
        $this->entityManager->flush();

        $this->entityManager->clear();
    }
}