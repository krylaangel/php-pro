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
        ->where('v.license_plate = :license_plate');
    $query = $queryBuilder->getQuery()
        ->setParameter('license_plate', $attributes['licensePlate']);
    echo "Запрос создан: " . $query->getSQL() . "<br>";

    $spareParts = $query->getResult();
    if (count($spareParts)) {
        $html = "";
        foreach ($spareParts[0]->getPartInfo() as $key => $value) {
            $html .= "<tr><td><b>$key</b></td><td>$value</td><tr>";
            }

       return new Response("<table>$html</table>");
    } else {
        return new Response(status: Response::HTTP_NOT_FOUND);
    }
};


