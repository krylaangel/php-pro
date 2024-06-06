<?php
declare(strict_types=1);

namespace App\Repository;

use App\CarMaster\Entity\SparePart;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class SparePartRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SparePart::class);
    }

    public function findPartForCar(string $licensePlate): array
    {
        $queryBuilder = $this->createQueryBuilder('s')
            ->join('s.vehicles', 'v')
            ->where('v.licensePlate = :license_plate');
        $query = $queryBuilder->getQuery()
            ->setParameter('license_plate', $licensePlate);
        $spareParts = $query->getResult();
        $result = [];
        foreach ($spareParts as $sparePart) {
            $partInfo = $sparePart->getPartInfo();
            $result [] = $partInfo;
        }
        return $result;
    }
}