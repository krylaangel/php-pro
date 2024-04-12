<?php

class Car extends Vehicle

{
    protected string $bodyType;
    protected array $spareParts = [];


    public function __construct(string $vehicleLicensePlate, int $yearVehicleManufacture, string $brandVehicle, string $bodyType)
    {
        parent::__construct($vehicleLicensePlate, $yearVehicleManufacture, $brandVehicle);
        $this->setBodyType($bodyType);

    }

    public function addSparePart(SparePart $partInfo): void
    {
        $this->spareParts[] = $partInfo;
    }

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

    public function getData(): array
    {
        $data = parent::getData();
        $data['Body Type'] = $this->getBodyType();
        return $data;

    }

    public function writeInfoVehicleEquipment(string $filenameCareInfo): void
    {
        $existingDataCar = [];
        if (file_exists($filenameCareInfo)) {
            $existingDataCar = json_decode(file_get_contents($filenameCareInfo), true);
        }
        $existingDataCar[] = [
            'Vehicle' => $this->getData(),
            'SpareParts' => $this->getAllSpareParts()
        ];
        $json_data = json_encode($existingDataCar, JSON_PRETTY_PRINT);
        $json_data .= PHP_EOL;
        file_put_contents($filenameCareInfo, $json_data);
    }
    /**
     * @param mixed $vehicleLicensePlate
     */
    /**
     * @return string
     */
    public function getBodyType(): string
    {
        return $this->bodyType;
    }

    /**
     * @param string $bodyType
     */
    public function setBodyType(string $bodyType): void
    {
        $this->bodyType = $bodyType;
    }

    public function getDataFormatted()
    {
    }
}