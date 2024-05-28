<?php

declare(strict_types=1);

use App\CarMaster\Entity\SparePart;
use CarMaster\ServiceFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

return function (Request $request, array $attributes): Response {
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
    if (!empty($spareParts)) {
        $html = "";
        foreach ($spareParts as $sparePart) {
            foreach ($sparePart->getPartInfo() as $key => $value) {
                $html .= "<tr><td><b>$key</b></td><td>$value</td></tr>";
            }
        }
        return new Response("<table>$html</table>");
    } else {
        return new Response(null, Response::HTTP_NOT_FOUND);
    }
};


