<?php

namespace App\Controller;

use App\CarMaster\Entity\CarOwner;
use App\CarMaster\Manager\OwnerManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class OwnerController extends AbstractController
{
    /*
    * поиск владельца по айди
    */
    #[Route('/owner/{ownerId}', name: 'app_owner', methods: ['GET'])]
    public function find(int $ownerId, EntityManagerInterface $entityManager): Response
    {
        $owner = $entityManager->getRepository(CarOwner::class)->find($ownerId);
        if (!$owner) {
            return new JsonResponse([
                'error' => 'Owner not found'
            ], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse($owner->getOwnerInfo());
    }

    /*
    * создаем нового владельца
    */

    #[Route('/owner/create/{ownerId}', name: 'app_owner_create', methods: ['GET'])]
    public function create(int $ownerId, OwnerManager $ownerManager, EntityManagerInterface $entityManager): Response
    {
        $owner = $entityManager->getRepository(CarOwner::class)->find($ownerId);
        if ($owner) {
            return new JsonResponse([
                'error' => 'Owner already exists',
                'owner' => $owner->getOwnerInfo()
            ], Response::HTTP_NOT_FOUND);
        }
        return new JsonResponse($ownerManager->createOwner()->getOwnerInfo());
    }

}
