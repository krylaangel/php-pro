<?php

namespace Controller;

use App\CarMaster\Entity\SparePart;
use CarMaster\ServiceFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PartController
{
    protected array $vars;
    public function get(Request $request, array $attributes): Response
    {
        $services = new ServiceFactory();
        $entityManager = $services->createORMEntityManager();
        $queryBuilder = $entityManager
            ->getRepository(SparePart::class)
            ->createQueryBuilder('s')
            ->join('s.vehicles', 'v')
            ->where('v.licensePlate = :license_plate');
        $query = $queryBuilder->getQuery()
            ->setParameter('license_plate', $attributes['licensePlate']);
        $spareParts = $query->getResult();
        $this->vars['spareParts']=$spareParts;
        ob_start();
        require __DIR__ . '/../views/part.phtml';

return new Response(ob_get_clean());
    }

}