<?php

namespace App\CarMaster\Service;

class ServiceCostCalculator implements CostCalculatorInterface
{
    public function calculateTotalCost(CalculableInterface $calculable): float
    {
        // встроенная функция, которая принимает параметром нужный массив (проходит по каждому элементу)
        // и анонимную функцию, определеющую накопленное значение суммы элементов массива ($carry)
        // и текущий элемент массива $item,
        // + начальное значение $carry=0
        return array_reduce($calculable->getItems(), function ($carry, $item) {
            return $carry + $item->getSparePart()->getPricePart() * $item->getQuantity();
        }, 0);
    }

}