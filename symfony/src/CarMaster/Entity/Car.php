<?php

declare(strict_types=1);

namespace App\CarMaster\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;

#[Entity]
class Car extends Vehicle

{
    #[Column(name: 'body_type', length: 60)]
    protected string $bodyType;
    protected array $spareParts = [];


    public function __construct(
        string $licensePlate,
        int $yearManufacture,
        string $brand,
        string $bodyType,
        Validator $validator

    ) {
        parent::__construct($licensePlate, $yearManufacture, $brand, $validator, $bodyType);
        $this->setBodyType($bodyType);
    }

    public function getInformation(): array
    {
        $data = parent::getInformation();
        $data['Body Type'] = $this->getBodyType();
        return $data;
    }

    public function getBodyType(): string
    {
        return $this->bodyType;
    }

    public function setBodyType(string $bodyType): void
    {
        $this->bodyType = $bodyType;
        $this->validator->verifyInputFields($bodyType);
    }

    public function jsonSerialize(): array
    {
        return $this->getInformation();
    }
}