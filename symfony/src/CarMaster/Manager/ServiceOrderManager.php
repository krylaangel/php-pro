<?php

declare(strict_types=1);

namespace App\CarMaster\Manager;

use App\CarMaster\Entity\ServiceOrder;
use App\CarMaster\Entity\SparePart;
use App\CarMaster\Entity\Vehicle;
use App\CarMaster\Service\CostCalculatorInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Faker\Generator;

readonly class ServiceOrderManager
{

    public function __construct(
        private EntityManagerInterface $entityManager,
        private Generator $faker,
    ) {
    }

    /*
     * создаем новый ордер под определенную машину
     */

    public function createOrder(Vehicle $vehicle): ServiceOrder
    {
        $order = new ServiceOrder(
            $vehicle,
            $this->faker->unique()->numberBetween(1, 9999)
        );
        $this->entityManager->persist($order);
        $this->entityManager->flush();
        return $order;
    }

    /*
     * наполняем его деталями, суммирую количество однотипных через функцию updateOrderQuantities
     */

    public function addOrder(ServiceOrder $serviceOrder, SparePart $sparePart, int $quantity): ServiceOrder
    {
        $serviceOrder->updateOrderQuantities($sparePart, $quantity);
        $this->entityManager->persist($serviceOrder);
        $this->entityManager->flush();
        return $serviceOrder;
    }

}