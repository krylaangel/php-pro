<?php

declare(strict_types=1);

namespace CarMaster;

abstract class Vehicle

{
    protected Validator $validator;
    protected string $licensePlate;
    protected int $yearManufacture;
    protected string $brand;

    public function __construct(string $licensePlate, int $yearManufacture, string $brand, Validator $validator)
    {
        $this->validator = $validator;
        $this->setLicensePlate($licensePlate);
        $this->setYearManufacture($yearManufacture);
        $this->setBrand($brand);
    }

    /**
     * @return array
     */
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
     * @return mixed
     */
    public function getLicensePlate(): string
    {
        return $this->licensePlate;
    }

    /**
     * @param mixed $licensePlate
     */
    public function setLicensePlate(string $licensePlate): void
    {
        $this->validator->validateCharacterCount($licensePlate, 4);
        $this->licensePlate = $licensePlate;
    }

    /**
     * @return mixed
     */
    public function getYearManufacture(): int
    {
        return $this->yearManufacture;
    }

    /**
     * @param mixed $yearManufacture
     */
    public function setYearManufacture(int $yearManufacture): void
    {
        $this->validator->validateCharacterCount($yearManufacture, 4);
        $this->yearManufacture = $yearManufacture;
    }

    /**
     * @return mixed
     */
    public function getBrand(): string
    {
        return $this->brand;
    }

    /**
     * @param mixed $brand
     */
    public function setBrand(string $brand): void
    {
        $this->validator->validateNamePart($brand);
        $this->validator->validateCharacterCount($brand, 3);
        $this->brand = $brand;
    }
}