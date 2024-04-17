<?php

declare(strict_types=1);

namespace CarMaster;

use CarMaster\Exception\FileOperationException;

class CarOwner
{
    protected Validator $validator;
    private string $fullName;
    protected array $vehicleInfo = [];
    private int $contactNumber;

    public function __construct(string $fullName, int $contactNumber, Validator $validator)
    {
        $this->validator = $validator;
        $this->setFullName($fullName);
        $this->setContactNumber($contactNumber);
    }

    public function writeOwnerInfo(string $filenameCarOwner): void
    {
        $ownerInfo = [
            'Full Name' => $this->getFullName(),
            'Contact Number' => $this->getContactNumber(),
        ];

        $json_data = json_encode($ownerInfo, JSON_PRETTY_PRINT);
        file_put_contents($filenameCarOwner, $json_data);
    }

// находит только машины определенного владельца, создает массив

    public function findOwnerCars(): array
    {
        $findOwner = $this->getFullName();
        $findCar = [];
        foreach ($this->getVehicleInfo() as $vehicleInfo) {
            if ($vehicleInfo instanceof Car) {
                $findCar[] = $vehicleInfo->getInformation();
            }
        }
        return [
            'Owner' => $findOwner,
            'Cars' => $findCar
        ];
    }

    /**
     * записывает в файл инфо, полученную из метода findOwnerCars и возвращает ошибки
     * @throws FileOperationException
     */
    public function writeOwnerCarsInfo(): void
    {
        $jsonString = json_encode($this->findOwnerCars(), JSON_PRETTY_PRINT);
        if ($jsonString !== false) {
            $result = file_put_contents(OWNER_CARS_INFO, $jsonString);
            if ($result === false) {
                throw new FileOperationException("Ошибка при записи в файл: OWNER_CARS_INFO;");
            }
        } else {
            throw new FileOperationException("Ошибка кодирования JSON");
        }
    }

    public function addVehicle(Vehicle $vehicleInfo): void
    {
        $this->vehicleInfo[] = $vehicleInfo;
    }

    public function getVehicleInfo(): array
    {
        return $this->vehicleInfo;
    }

    public function getFullName(): string
    {
        return $this->fullName;
    }

    public function setFullName(string $fullName): void
    {
        $this->validator->validateCharacterCount($fullName, 2);
        $this->validator->validateNamePart($fullName);
        $this->fullName = $fullName;
        $this->validator->verifyInputFields($fullName);

    }

    public function getContactNumber(): int
    {
        return $this->contactNumber;
    }

    public function setContactNumber(int $contactNumber): void
    {
        $this->validator->validateCharacterCount($contactNumber, 12);
        $this->contactNumber = $contactNumber;
        $this->validator->verifyInputFields($contactNumber);

    }

}