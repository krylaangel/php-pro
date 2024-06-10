<?php

namespace App\Controller;

use App\CarMaster\Manager\SparePartManager;
use App\Repository\SparePartRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PartController extends AbstractController
{
    #[Route('/part/{licensePlate}', name: 'app_part')]
    /*
     * поиск запчастей для конкретной машины, если мы знаем ее номер лицензии
     */
    public function find(string $licensePlate, SparePartManager $sparePartManager): Response
    {
        $findCarByOwner = $sparePartManager->getFindPartsForCar($licensePlate);
        if (!empty($findCarByOwner)) {
            return new JsonResponse($findCarByOwner);
        }
        return $this->json([
            'error' => 'Owner has not vehicle',
        ], Response::HTTP_CONFLICT);
    }
}