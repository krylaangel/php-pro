<?php

declare(strict_types=1);

namespace App\Repository;

use App\CarMaster\Entity\SparePart;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class SparePartRepository extends ServiceEntityRepository
{
    private const PARTS_PER_PAGE = 10;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SparePart::class);
    }

    /*
     * ищем запчасти по машине
     */
    public function findPartsForCar(string $licensePlate): array
    {
        $queryBuilder = $this->createQueryBuilder('s')
            ->join('s.vehicles', 'v')
            ->where('v.licensePlate = :license_plate');
        $query = $queryBuilder->getQuery()
            ->setParameter('license_plate', $licensePlate);
        return $query->getResult();
    }

    public function findPage(int $page = 1)
    {
        return $this->createQueryBuilder('s')
            ->orderBy('s.partId')
            ->getQuery()
            ->setFirstResult(self::PARTS_PER_PAGE * $page - self::PARTS_PER_PAGE)
            ->setMaxResults(self::PARTS_PER_PAGE)
            ->getResult();
    }

    }