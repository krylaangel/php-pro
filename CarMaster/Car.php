<?php
declare(strict_types=1);

namespace CarMaster;

class Car extends Vehicle

{
    protected string $bodyType;
    protected array $spareParts = [];


    public function __construct(string $licensePlate, int $yearManufacture, string $brand, string $bodyType, Validator $validator)
    {
        parent::__construct($licensePlate, $yearManufacture, $brand, $validator);
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

    public function getInformation(): array
    {
        $data = parent::getInformation();
        $data['Body Type'] = $this->getBodyType();
        return $data;

    }

    public function writeInfoEquipment(string $filename): void
    {
        $existingDataCar = [];
        if (file_exists($filename)) {
            $existingDataCar = json_decode(file_get_contents($filename), true);
        }
        $existingDataCar[] = [
            'Vehicle' => $this->getInformation(),
            'SpareParts' => $this->getAllSpareParts()
        ];
        $json_data = json_encode($existingDataCar, JSON_PRETTY_PRINT);
        $json_data .= PHP_EOL;
        file_put_contents($filename, $json_data);
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
}