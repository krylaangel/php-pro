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
    #[Column(type: 'simple_array', enumType: BodyTypes::class)]
    private array $bodyTypes = [BodyTypes::NONE];

    protected array $spareParts = [];


    public function __construct(
        string $licensePlate,
        int $yearManufacture,
        string $brand,
        array $bodyTypes,
        Validator $validator

    ) {
        parent::__construct($licensePlate, $yearManufacture, $brand, $validator);
        $this->setBodyType($bodyTypes);
    }

    public function getInformation(): array
    {
        $data = parent::getInformation();
        $data['Body Type'] = implode(', ', array_column($this->bodyTypes, 'value'));
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

    public function jsonSerialize(): array
    {
        return $this->getInformation();
    }
}