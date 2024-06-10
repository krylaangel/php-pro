<?php

declare(strict_types=1);

namespace App\CarMaster\Manager;

use App\CarMaster\Entity\SparePart;
use App\CarMaster\Entity\Validator;
use App\CarMaster\Entity\Vehicle;
use App\Repository\SparePartRepository;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Generator;

readonly class SparePartManager
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private Generator $faker,
        private SparePartRepository $sparePartRepository
    ) {
    }
    /*
        * создаем новую запчасть для конкретной машины.
        */
    public function createSpareByVehicle(Vehicle $vehicle): SparePart
    {

        $validator = new Validator();
        $sparePart = new SparePart(
            $this->faker->word,
            $this->faker->company,
            $this->faker->randomFloat(),
            $validator
        );
        $sparePart->addVehicle($vehicle);
        $this->entityManager->persist($sparePart);
        $this->entityManager->flush();
        return $sparePart;


    }

    public function getFindPartsForCar(string $licensePlate)
    {
        $spareParts=$this->sparePartRepository->findPartsForCar($licensePlate);
        $result = [];
        foreach ($spareParts as $sparePart) {
            $partInfo = $sparePart->getPartInfo();
            $result [] = $partInfo;
        }
        return $result;
    }

}