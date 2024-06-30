<?php

namespace App\Controller\API;

use App\CarMaster\DTO\CreateCar;
use App\CarMaster\Entity\Vehicle;
use App\CarMaster\Manager\CarManagerAPI;
use App\Repository\VehicleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/vehicles')]
class VehicleController extends AbstractController
{
    #[Route('/', methods: ['GET'], format: 'json')]
    public function list(VehicleRepository $vehicleRepository, #[MapQueryParameter] int $page = 1): JsonResponse
    {
        return new JsonResponse($vehicleRepository->findPage($page));
    }

    #[Route('/{vehicleId}', methods: ['GET'], format: 'json')]
    public function get(Vehicle $vehicle): JsonResponse
    {
        return new JsonResponse($vehicle);
    }

    #[Route('/', methods: ['POST'], format: 'json')]
    public function create(#[MapRequestPayload]CreateCar $createVehicle, CarManagerAPI $carManager): JsonResponse
    {
        return new JsonResponse($carManager->createVehicle($createVehicle), Response::HTTP_CREATED);
    }

    #[Route('/{vehicleId}', methods: ['PATCH'], format: 'json')]
    public function update(): JsonResponse
    {
    }

    #[Route('/{vehicleId}', methods: ['DELETE'], format: 'json')]
    public function delete(): JsonResponse
    {
    }
}