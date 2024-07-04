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

    public function updatingConnectionsWithVehicle(SparePart $sparePart): void
    {
        $originalCars = new ArrayCollection($sparePart->getVehicles()->toArray());

        // получаем коллекцию авто, связанных с запчастью, найденной по айди.
        foreach ($sparePart->getVehicles() as $vehicle) {
            $originalCars->add($vehicle);
        }
        //удаление старых записей о автомобилях из коллекции
        foreach ($originalCars as $vehicle) {
            if (!$sparePart->getVehicles()->contains($vehicle)) {
                $sparePart->removeVehicle($vehicle);
            }
        }

        // Добавление новых автомобилей
        foreach ($sparePart->getVehicles() as $vehicle) {
            if (!$originalCars->contains($vehicle)) {
                $sparePart->addVehicle($vehicle);
            }
        }
        $this->entityManager->flush();

    }

   public function removePartByDB(SparePart $sparePart): void
    {
        $this->entityManager->remove($sparePart);
        $this->entityManager->flush();

    }
}