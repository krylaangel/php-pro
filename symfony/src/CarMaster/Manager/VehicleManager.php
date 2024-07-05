<?php

declare(strict_types=1);

namespace App\CarMaster\Manager;

use App\CarMaster\Entity\Car;
use App\CarMaster\Entity\CarOwner;
use App\CarMaster\Entity\Enum\BodyTypes;
use App\CarMaster\Entity\Validator;
use App\CarMaster\Entity\Vehicle;
use App\Repository\VehicleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Generator;

readonly class VehicleManager
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private Generator $faker,
        private VehicleRepository $vehicleRepository
    ) {
    }

    /*
        * создаем новое транспортное средство по существующему в базе владельцу.
        */
    public function createVehicleByOwner(CarOwner $owner): Vehicle
    {
        $randomBodyType = $this->faker->randomElement(BodyTypes::toArray());
        $car = new Car(
            $this->faker->regexify('^([A-Z]{2}\d{4}[A-Z]{2})$'),
            $this->faker->numberBetween(1980, date('Y')),
            $this->faker->company(),
            $owner,
            [$randomBodyType],
        );
        $this->entityManager->persist($car);
        $this->entityManager->flush();
        return $car;
    }

    public function getVehiclesInfoByOwner(int $contactNumber): array
    {
        $vehicles = $this->vehicleRepository->findVehiclesByOwner($contactNumber);
        $result = [];
        foreach ($vehicles as $vehicle) {
            $vehicleInfo = $vehicle->getInformation();
            $result [] = $vehicleInfo;
        }
        return $result;
    }
}