<?php

namespace App\CarMaster\Service;

use App\CarMaster\Entity\Interface\ServiceCostCalculatorInterface;
use App\CarMaster\Entity\ServiceOrder;

class ServiceCostCalculator implements ServiceCostCalculatorInterface
{
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