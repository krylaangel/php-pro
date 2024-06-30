<?php

namespace App\CarMaster\Manager;

use App\CarMaster\DTO\CreateCar;
use App\CarMaster\Entity\Car;
use App\CarMaster\Entity\CarOwner;
use App\CarMaster\Entity\Enum\BodyTypes;
use App\Repository\SparePartRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;

readonly class CarManagerAPI
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private SparePartRepository $sparePartRepository,
    ) {
    }

    public function createVehicle(CreateCar $createVehicle): Car
    {
        $spareParts = $this->sparePartRepository->findBy(['partId' => $createVehicle->partId]);
        if (!$spareParts) {
            throw new EntityNotFoundException('Not find spare part');
        }
        $owner = $this->entityManager->getRepository(CarOwner::class)->find($createVehicle->ownerId);
        if (!$owner) {
            throw new EntityNotFoundException('Not find owner');
        }
        $bodyTypeObjects = array_map(fn(string $bodyType) => BodyTypes::from($bodyType), $createVehicle->bodyTypes);

        $car = new Car(
            licensePlate: $createVehicle->licensePlate,
            yearManufacture: $createVehicle->yearManufacture,
            brand: $createVehicle->brand,
            owner: $owner,
            bodyTypes: $bodyTypeObjects        );
        foreach ($spareParts as $sparePart) {
            $car->addSpareParts($sparePart);
        }
        $this->entityManager->persist($car);
        $this->entityManager->flush();
        return $car;
    }
}

