<?php

declare(strict_types=1);

use App\CarMaster\Entity\SparePart;
use CarMaster\ServiceFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
function displaySparePartInfo(SparePart $sparePart): string
{
    $partInfo = $sparePart->getPartInfo();
    $html = "";
    foreach ($partInfo as $key => $value) {
        $html .= "<tr><td><b>$key</b></td><td>$value</td></tr>";    }

    return $html;
}

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
    $spareParts = $query->getResult();
    var_dump($spareParts);

    if (empty($spareParts)) {
        return new Response(status: Response::HTTP_NOT_FOUND);
    } else {
        $html = "<table>";
        foreach ($spareParts as $sparePart) {
            if ($sparePart instanceof SparePart) {
                $html .= displaySparePartInfo($sparePart);
            }
        }

        $html .= "</table>";

        return new Response("<table>$html</table>");
    }
};

