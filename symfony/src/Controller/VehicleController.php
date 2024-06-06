<?php

namespace App\Controller;

use App\CarMaster\Entity\CarOwner;
use App\CarMaster\Manager\VehicleManager;
use App\Repository\VehicleRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class VehicleController extends AbstractController
{
    #[Route('/vehicle/{contactNumber}', name: 'app_find_vehicle')]
    /*
     * поиск машин по номеру телефона владельца
     */
    public function find(
        int $contactNumber,
        VehicleRepository $vehicleRepository
    ): Response {
        $findCarByOwner = $vehicleRepository->findCarByOwner($contactNumber);
        if (!empty($findCarByOwner)) {
            return new JsonResponse($findCarByOwner);
        }
        return $this->json([
            'error' => 'Owner has not vehicle',
        ], Response::HTTP_CONFLICT);
    }
    #[Route('/vehicle/create/{contactNumber}', name: 'app_creat_vehicle')]

    /*
     * создание машины по владельцу, зная его номер телефона
     */
    public function create(
        int $contactNumber,
        EntityManagerInterface $entityManager,
        VehicleManager $vehicleManager
    ): Response {
        $owner = $entityManager->getRepository(CarOwner::class)->findOneBy(['contactNumber' => $contactNumber]);
        if (!empty($owner)) {
            return new JsonResponse($vehicleManager->createVehicleByOwner($owner)->getInformation());
        }
        return $this->json([
            'error' => 'Number not found',
        ], Response::HTTP_CONFLICT);
    }
}
