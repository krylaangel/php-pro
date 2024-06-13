<?php

namespace App\Controller;

use App\CarMaster\Manager\ServiceOrderManager;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class ServiceOrderController extends AbstractController
{
    /**
     * @throws Exception
     */
    #[Route('/service_order/calculate/{orderName}', name: 'app_calc_service_order', methods: ['GET'])]
    public function calculate(ServiceOrderManager $serviceOrderManager, int $orderName): JsonResponse
    {
        return new JsonResponse($serviceOrderManager->getDetailsAboutOrder($orderName));
    }
}
