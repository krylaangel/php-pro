<?php

declare(strict_types=1);

namespace App\CarMaster\Manager;
use Doctrine\Common\Collections\ArrayCollection;

use App\CarMaster\Entity\SparePart;
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
    public function createPartByVehicle(Vehicle $vehicle): SparePart
    {

        $sparePart = new SparePart();
        $sparePart->setNamePart($this->faker->word);
        $sparePart->setModelPart($this->faker->company);
        $sparePart->setPricePart($this->faker->randomFloat());  ;

        $sparePart->addVehicle($vehicle);
        $this->entityManager->persist($sparePart);
        $this->entityManager->flush();
        return $sparePart;


    }

    public function getFindPartsForCar(string $licensePlate):array
    {
        $spareParts=$this->sparePartRepository->findPartsForCar($licensePlate);
        $result = [];
        foreach ($spareParts as $sparePart) {
            $partInfo = $sparePart->getPartInfo();
            $result [] = $partInfo;
        }
        return $result;
    }
    public function collectFindPartsForCar(string $licensePlate): ArrayCollection
    {
        $parts = $this->getFindPartsForCar($licensePlate); // Получаем результат из вашей функции

        // Преобразуем массив в коллекцию
        return new ArrayCollection($parts);
    }
}