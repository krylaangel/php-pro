<?php

declare(strict_types=1);


namespace App\Repository;

use App\CarMaster\Entity\Vehicle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class VehicleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vehicle::class);
    }
    /*
        * поиск машин по номеру телефона владельца
        */
    public function findVehiclesByOwner(int $contactNumber): array
    {
        $queryBuilder = $this->createQueryBuilder('v')
            ->join('v.owner', 'o')
            ->where('o.contactNumber =:phone_number');
        $query = $queryBuilder->getQuery()
            ->setParameter('phone_number', $contactNumber);
        return $query->getResult();
    }
    /*
     * ищем машины по запчасти
     */

    public function getVehicleInPart(int $partId): array
    {
        $queryBuilder = $this->createQueryBuilder('v')
            ->join('v.spareParts', 's')
            ->where('s.partId = :spare_part_id');
        $query = $queryBuilder->getQuery()
            ->setParameter('spare_part_id', $partId);
        return $query->getResult();
    }

}

