<?php

namespace App\CarMaster\Service;

use App\CarMaster\Entity\ServiceOrder;

interface CostCalculatorInterface
{
public function calculateTotalCost(CalculableInterface $calculable): float;
}