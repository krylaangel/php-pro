<?php

abstract class Vehicle
{
    protected ValidationController $validator;
    protected string $vehicleLicensePlate;
    protected int $yearVehicleManufacture;
    protected string $brandVehicle;

    public function __construct(string $vehicleLicensePlate, int $yearVehicleManufacture, string $brandVehicle)
    {
        $this->validator = new ValidationController();
        $this->setVehicleLicensePlate($vehicleLicensePlate);
        $this->setYearVehicleManufacture($yearVehicleManufacture);
        $this->setBrandVehicle($brandVehicle);
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return [
            'License Plate' => $this->getVehicleLicensePlate(),
            'Year of Manufacture' => $this->getYearVehicleManufacture(),
            'Brand' => $this->getBrandVehicle()
        ];

    }

    abstract public function addSparePart(SparePart $partInfo);

    abstract public function getAllSpareParts();

    abstract public function writeInfoVehicleEquipment(string $filename): void;

    /**
     * @return mixed
     */
    public function getVehicleLicensePlate(): string
    {
        return $this->vehicleLicensePlate;
    }

    /**
     * @param mixed $vehicleLicensePlate
     */
    public function setVehicleLicensePlate(string $vehicleLicensePlate): void
    {
        $this->validator->validateCharacterCount($vehicleLicensePlate, 4);
        $this->vehicleLicensePlate = $vehicleLicensePlate;

    }

    /**
     * @return mixed
     */
    public function getYearVehicleManufacture(): int
    {
        return $this->yearVehicleManufacture;
    }

    /**
     * @param mixed $yearVehicleManufacture
     */
    public function setYearVehicleManufacture(int $yearVehicleManufacture): void
    {
        $this->validator->validateCharacterCount($yearVehicleManufacture, 4);
        $this->yearVehicleManufacture = $yearVehicleManufacture;
    }

    /**
     * @return mixed
     */
    public function getBrandVehicle(): string
    {
        return $this->brandVehicle;
    }

    /**
     * @param mixed $brandVehicle
     */
    public function setBrandVehicle(string $brandVehicle): void
    {
        $this->validator->validateNamePart($brandVehicle);
        $this->validator->validateCharacterCount($brandVehicle, 3);
        $this->brandVehicle = $brandVehicle;
    }
}