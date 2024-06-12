<?php

namespace App\Controller;

use App\CarMaster\Manager\ServiceOrderManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class ServiceOrderController extends AbstractController
{
    /**
     * @throws \Exception
     */
    #[Route('/service/{orderName}', name: 'app_calc_service_order')]
    public function calc(ServiceOrderManager $serviceOrderManager, int $orderName): JsonResponse
    {
        $totalCost = $serviceOrderManager->calculateTotalCostById($orderName);
        return new JsonResponse(['total_cost' => $totalCost]);
    }
}
