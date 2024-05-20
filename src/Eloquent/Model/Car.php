<?php

declare(strict_types=1);

namespace App\Eloquent\Model;

use App\CarMaster\Entity\SparePart;

require __DIR__ . '/../../../vendor/autoload.php';

class Car extends Vehicle

{

    private array $spareParts;

    public function getAllSpareParts(): array
    {
        {
            $partsInfo = [];
            foreach ($this->spareParts as $sparePart) {
                $partsInfo[] = $sparePart->getPartInfo();
            }
            return $partsInfo;
        }
    }
    public function addSparePart(SparePart|\App\Eloquent\Model\SparePart $partInfo): void
    {
        $this->spareParts[] = $partInfo;
    }
    public function getInformation(): array
    {
        $data = parent::getInformation();
        $data['Body Type'] = $this->getBodyType();
        return $data;
    }
    
   }