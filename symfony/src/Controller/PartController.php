<?php

namespace App\Controller;

use App\CarMaster\Manager\SparePartManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PartController extends AbstractController
{
    #[Route('/part/{licensePlate}', name: 'app_part', methods: ['GET'])]
    /**
     * Поиск запчастей для конкретной машины по номеру лицензии
     */
    public function find(
        string $licensePlate,
        SparePartManager $sparePartManager
    ): Response {
        $parts = $sparePartManager->getFindPartsForCar($licensePlate);
        if (!empty($parts)) {
            return new JsonResponse($parts);
        }
        return new JsonResponse([
            'error' => 'Part not found'
        ], Response::HTTP_NOT_FOUND);
    }
}