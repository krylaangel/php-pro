<?php

declare(strict_types=1);

namespace App\CarMaster\Manager;

use App\CarMaster\Entity\SparePart;
use App\CarMaster\Entity\Validator;
use App\CarMaster\Entity\Vehicle;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Generator;

readonly class SpareManager
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private Generator $faker
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

}