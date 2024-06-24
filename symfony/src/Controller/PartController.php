<?php

namespace App\Controller;

use App\CarMaster\Entity\SparePart;
use App\CarMaster\Entity\Vehicle;
use App\CarMaster\Manager\SparePartManager;
use App\Form\PartFind;
use App\Form\PartType;
use App\Repository\SparePartRepository;
use App\Repository\VehicleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/parts')]
class PartController extends AbstractController
{

    #[Route('/parts', name: 'app_all_parts', methods: ['GET'])]
    public function index(
        SparePartRepository $spareParts,
        #[MapQueryParameter(
            filter: FILTER_VALIDATE_REGEXP,
            options: ['regexp' => '/^[1-9][0-9]*$/']
        )]
        int $page = 1
    ): Response {
        return $this->render('parts/index.html.twig', [
            'parts' => $spareParts->findPage(max(1, $page))
        ]);
    }

    #[Route('/{partId}', name: 'app_part_show', requirements: ['partId' => '\d+'], methods: ['GET'])]
    public function show(SparePart $sparePart): Response
    {
        return $this->render('parts/show.html.twig', [
            'part' => $sparePart,
        ]);
    }

    /**
     * удалить запчасть
     */
    #[Route('/{partId}/_delete', name: 'app_part_delete', requirements: ['partId' => '\d+'])]
    public function delete(EntityManagerInterface $entityManager, SparePart $sparePart): Response
    {
        $entityManager->remove($sparePart);
        $entityManager->flush();
        $this->addFlash('success', 'Part ' . $sparePart->getNamePart() . ' deleted successfully');
        return $this->redirectToRoute('app_all_parts');
    }

    /**
     * создать запчасть
     */
    #[Route('/_create', name: 'app_create_part', methods: ['GET', 'POST'])]
    public function create(
        Request $request,
        EntityManagerInterface $entityManager,
    ): Response {
        $sparePart = new SparePart();
        $form = $this->createForm(PartType::class, $sparePart);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($sparePart->getVehicles() as $vehicle) {
                $vehicle->addSpareParts($sparePart);
                $entityManager->persist($vehicle);
            }
            $entityManager->persist($sparePart);
            $entityManager->flush();

            $this->addFlash('success', "Part {$sparePart->getNamePart()} created successfully");

            return $this->redirectToRoute('app_part_show', ['partId' => $sparePart->getPartId()]);
        }
        return $this->render('parts/create_part.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * изменить запчасть
     */
    #[Route('/{partId}/_update', name: 'app_update_part', requirements: ['partId' => '\d+'], methods: [
        'GET',
        'POST'
    ])]
    public function update(Request $request, EntityManagerInterface $entityManager, SparePart $sparePart): Response
    {
        $form = $this->createForm(PartType::class, $sparePart);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($sparePart->getVehicles() as $vehicle) {
                $vehicle->addSpareParts($sparePart);
                $entityManager->persist($vehicle);
            }
            $entityManager->flush();

            $this->addFlash('success', "Part {$sparePart->getNamePart()} updated successfully");

            return $this->redirectToRoute('app_part_show', ['partId' => $sparePart->getPartId()]);
        }

        return $this->render('parts/update.html.twig', ['part' => $sparePart, 'form' => $form]);
    }

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