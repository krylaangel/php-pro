<?php

declare(strict_types=1);

namespace App\CarMaster\Manager;

use App\CarMaster\Entity\OrderItem;
use App\CarMaster\Entity\ServiceOrder;
use App\CarMaster\Entity\SparePart;
use App\CarMaster\Entity\Vehicle;
use App\CarMaster\Service\ServiceCostCalculator;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Faker\Generator;

readonly class ServiceOrderManager
{

    public function __construct(
        private EntityManagerInterface $entityManager,
        private Generator $faker,
        private ServiceCostCalculator $serviceCostCalculator
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
        $this->updateOrderQuantities($serviceOrder, $sparePart, $quantity);
        $this->entityManager->persist($serviceOrder);
        $this->entityManager->flush();
        return $serviceOrder;
    }

    /*
     * суммируем количество однотипных деталей - перебираем массив, для каждого $orderItem в массиве ордеров
     * проверяем есть ли деталь по ее айди в orderItem и в зависимости от того, есть или нет либо суммируем заданное
     * количество к уже существующему либо создаем новый orderItem и записываем туда переданное количество
     */
    public function updateOrderQuantities(ServiceOrder $serviceOrder, SparePart $sparePart, int $quantity): int
    {
        foreach ($serviceOrder->getOrderItems() as $orderItem) {
            if ($orderItem->getSparePart()->getPartId() === $sparePart->getPartId()) {
                if ($quantity !== 0) {
                    $newQuantity = $orderItem->getQuantity() + $quantity;
                    $orderItem->setQuantity($newQuantity);
                    return $newQuantity;
                } else {
                    $serviceOrder->getOrderItems()->removeElement($orderItem);
                    $this->entityManager->remove($orderItem);
                    return 0;
                }
            }
        }
        $orderItem = new OrderItem($serviceOrder, $sparePart, $quantity);
        $serviceOrder->addOrderItem($orderItem);
        $this->entityManager->persist($orderItem);
        return $quantity;
    }

    /**
     * @throws EntityNotFoundException
     */
    public function findTotalCostById($orderName): ServiceOrder
    {
        $serviceOrder = $this->entityManager->getRepository(ServiceOrder::class)->findOneBy(['orderName' => $orderName]
        );
        if (!$serviceOrder) {
            throw new EntityNotFoundException ('not found order');
        }
        return $serviceOrder;
    }

    /**
     * @throws EntityNotFoundException
     */
    public function calculateTotalCostById(int $orderName): float
    {
        $serviceOrder=$this->findTotalCostById($orderName);
        return $this->serviceCostCalculator->ServiceCostCalculator($serviceOrder);
    }

    public function getDetailsAboutOrder($orderName): array
    {
        $serviceOrder = $this->findTotalCostById($orderName);
        $totalCost = $this->calculateTotalCostById($orderName);
        $vehicle = $serviceOrder->getVehicle();

        return [
            'Order number' => $serviceOrder->getOrderName(),
            'Brand vehicle' => $vehicle->getBrand(),
            'License vehicle' => $vehicle->getLicensePlate(),
            'Total cost' => $totalCost
        ];
    }
}