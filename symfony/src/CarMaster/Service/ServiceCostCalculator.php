<?php

namespace App\CarMaster\Service;

use App\CarMaster\Entity\Interface\ServiceCostCalculatorInterface;
use App\CarMaster\Entity\ServiceOrder;

class ServiceCostCalculator implements ServiceCostCalculatorInterface
{
    /*
     * Створити клас-сервіс (приклад назви  - ServiceCostCalculator), який займається підрахунком вартості якогось,
     * заздалегіть збереженого в БД, сервісного замовлення на авто . Клас має ралізувати метод по типу
     * calculateTotalCost(): int і повертати ітогову ціну за всі роботи + запчастини (матеріали),
     * використані в замолвені.
     */
    public function serviceCostCalculator(ServiceOrder $serviceOrder): float
    {
        {
            $totalCost = 0;
            foreach ($serviceOrder->getOrderItems() as $orderItem) {
                $totalCost += $orderItem->getSparePart()->getPricePart() * $orderItem->getQuantity();
            }
            return $totalCost;
        }
    }
}