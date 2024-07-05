<?php

namespace App\Controller;

use App\CarMaster\Entity\CarOwner;
use App\CarMaster\Manager\VehicleManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class VehicleController extends AbstractController
{
    /**
     * Пошук машини за номером телефона її власника
     */
    #[Route('/vehicle/{contactNumber}', name: 'app_find_vehicle', methods: ['GET'])]
    public function find(
        int $contactNumber,
        VehicleManager $vehicleManager
    ): Response {
        $findCarByOwner = $vehicleManager->getVehiclesInfoByOwner($contactNumber);
        if (!empty($findCarByOwner)) {
            return new JsonResponse($findCarByOwner);
        }
        return new JsonResponse([
            'error' => 'Owner has no vehicle',
        ], Response::HTTP_NOT_FOUND);
    }

    /**
     * Створення машини для її власника, пошук якого відбувається за номером його телефону
     */
    #[Route('/vehicle/create/{contactNumber}', name: 'app_create_vehicle', methods: ['GET'])]
    public function create(
        int $contactNumber,
        EntityManagerInterface $entityManager,
        VehicleManager $vehicleManager
    ): Response {
        $owner = $entityManager->getRepository(CarOwner::class)->findOneBy(['contactNumber' => $contactNumber]);
        if (!empty($owner)) {
            return new JsonResponse($vehicleManager->createVehicleByOwner($owner)->getInformation());
        }
        return new JsonResponse([
            'error' => 'Number not found',
        ], Response::HTTP_NOT_FOUND);
    }
}
