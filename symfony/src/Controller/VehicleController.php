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
     * Поиск машин по номеру телефона владельца
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
     * Создание машины по владельцу, зная его номер телефона
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
