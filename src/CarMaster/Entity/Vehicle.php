<?php

declare(strict_types=1);

namespace App\CarMaster\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\{Column,
    DiscriminatorColumn,
    DiscriminatorMap,
    Entity,
    GeneratedValue,
    Id,
    InheritanceType,
    InverseJoinColumn,
    JoinColumn,
    JoinTable,
    ManyToMany,
    ManyToOne,
    Table};

#[Entity]
#[Table(name: 'vehicle')]
#[InheritanceType('SINGLE_TABLE')]
#[DiscriminatorColumn(name: 'type', type: 'string')]
#[DiscriminatorMap(['Car' => Car::class])]
abstract class Vehicle

{
    protected Validator $validator;

    #[Id]
    #[GeneratedValue]
    #[Column(name: 'vehicle_id', type: Types::INTEGER)]
    protected ?int $vehicleId;

    #[Column(name: 'license_plate', length: 60)]
    protected string $licensePlate;

    #[Column(name: 'year_manufacture', type: Types::INTEGER)]
    protected int $yearManufacture;

    #[Column(name: 'brand', length: 60)]
    protected string $brand;

    #[ManyToOne(targetEntity: CarOwner::class, inversedBy: 'vehicles')]
    #[JoinColumn(name: 'owner_id', referencedColumnName: 'owner_id')]
    private CarOwner $owner;

    #[ManyToMany(targetEntity: SparePart::class, inversedBy: 'vehicles')]
    #[JoinTable(name: 'car_spares_parts')]
    #[JoinColumn(name: 'vehicle_id', referencedColumnName: 'vehicle_id')]
    #[InverseJoinColumn(name: 'spare_part_id', referencedColumnName: 'spare_part_id')]

    private SparePart $sparePart;

    public function __construct(
        ?int $vehicleId,
        string $licensePlate,
        int $yearManufacture,
        string $brand,
        Validator $validator
    ) {
        $this->validator = $validator;
        $this->setVehicleId($vehicleId);
        $this->setLicensePlate($licensePlate);
        $this->setYearManufacture($yearManufacture);
        $this->setBrand($brand);
    }

    public function getInformation(): array
    {
        return [
            'License Plate' => $this->getLicensePlate(),
            'Year of Manufacture' => $this->getYearManufacture(),
            'Brand' => $this->getBrand()
        ];
    }

    abstract public function addSparePart(SparePart $partInfo);

    abstract public function getAllSpareParts();

    abstract public function writeInfoEquipment(string $filename): void;

    /**
     * @return int|null
     */
    public function getVehicleId(): ?int
    {
        return $this->vehicleId;
    }

    /**
     * @param int|null $vehicleId
     */
    public function setVehicleId(?int $vehicleId): void
    {
        $this->vehicleId = $vehicleId;
    }

    public function getLicensePlate(): string
    {
        return $this->licensePlate;
    }

    public function setLicensePlate(string $licensePlate): void
    {
        $this->validator->validateCharacterCount($licensePlate, 2);
        $this->licensePlate = $licensePlate;
        $this->validator->verifyInputFields($licensePlate);
    }

    public function getYearManufacture(): int
    {
        return $this->yearManufacture;
    }

    public function setYearManufacture(int $yearManufacture): void
    {
        $this->validator->validateCharacterCount($yearManufacture, 4);
        $this->yearManufacture = $yearManufacture;
        $this->validator->verifyInputFields($yearManufacture);
    }

    public function getBrand(): string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): void
    {
//        $this->validator->validateNamePart($brand); отключено, пока используется Faker
        $this->validator->validateCharacterCount($brand, 3);
        $this->validator->verifyInputFields($brand);
        $this->brand = $brand;
    }
}