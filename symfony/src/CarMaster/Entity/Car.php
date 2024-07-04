<?php

declare(strict_types=1);

namespace App\CarMaster\Entity;

use App\CarMaster\Entity\Enum\BodyTypes;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;

#[Entity]
class Car extends Vehicle

{
    /** @var BodyTypes[] */
    #[Column(type: 'simple_array', nullable: true, enumType: BodyTypes::class)]
    private array $bodyTypes = [BodyTypes::NONE];

    public function __construct(
        string $licensePlate,
        int $yearManufacture,
        string $brand,
        CarOwner $owner,
        array $bodyTypes

    ) {
        parent::__construct($licensePlate, $yearManufacture, $brand, $owner);
        $this->setBodyType($bodyTypes);
    }

    public function getInformation(): array
    {
        $data = parent::getInformation();
        $data['Body Type'] = $this->getBodyType();
        return $data;
    }

    /**
     * @return array
     */
    public function getBodyType(): array
    {
        return $this->bodyTypes;
    }

    /**
     * @param array $bodyTypes
     */
    public function setBodyType(array $bodyTypes): void
    {
        array_walk($bodyTypes, fn($bodyType) => $bodyType instanceof BodyTypes);
        $this->bodyTypes = $bodyTypes;
    }


}