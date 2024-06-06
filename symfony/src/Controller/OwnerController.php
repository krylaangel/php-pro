<?php

namespace App\Controller;

use App\CarMaster\Entity\CarOwner;
use App\CarMaster\Manager\OwnerManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class OwnerController extends AbstractController
{
    /*
    * поиск владельца по айди
    */
    #[Route('/owner/{ownerId}', name: 'app_owner')]
    public function find(int $ownerId, EntityManagerInterface $entityManager): Response
    {
        $owner = $entityManager->getRepository(CarOwner::class)->find($ownerId);
        if (!$owner) {
            return $this->json([
                'error' => 'Owner not found',
            ], Response::HTTP_CONFLICT);
        }

        return $this->json($owner->getOwnerInfo());
    }
    /*
    * создаем нового владельца
    */

    #[Route('/owner/create/{ownerId}', name: 'app_owner_create')]
    public function create(int $ownerId, OwnerManager $ownerManager, EntityManagerInterface $entityManager): Response
    {
        $owner = $entityManager->getRepository(CarOwner::class)->find($ownerId);
        if ($owner) {
            return $this->json([
                'error' => 'Owner already exists',
                'owner' => $owner->getOwnerInfo()
            ], Response::HTTP_CONFLICT);
        }
        return $this->json($ownerManager->createOwner()->getOwnerInfo());
    }

}
