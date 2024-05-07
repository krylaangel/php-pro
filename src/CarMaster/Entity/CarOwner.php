<?php

declare(strict_types=1);

namespace App\CarMaster\Entity;

use App\CarMaster\Entity\Exception\FileOperationException;

use const CarMaster\Write_files\OWNER_CARS_INFO;

class CarOwner
{
    protected Validator $validator;
    private string $firstName;
    private string $lastName;
    private string $password;
    private string $ownerEmail;
    protected array $vehicleInfo = [];
    private int $contactNumber;

    public function __construct(
        string $firstName,
        string $lastName,
        string $password,
        int $contactNumber,
        string $ownerEmail,
        Validator $validator
    ) {
        $this->validator = $validator;
        $this->setFirstName($firstName);
        $this->setLastName($lastName);
        $this->setPassword($password);
        $this->setContactNumber($contactNumber);
        $this->setOwnerEmail($ownerEmail);
    }

    public function writeOwnerInfo(string $filenameCarOwner): void
    {
        $ownerInfo = [
            'First Name' => $this->getFirstName(),
            'Last Name' => $this->getLastName(),
            'Contact Number' => $this->getContactNumber(),
            'Email' => $this->getOwnerEmail(),
            'Password' => $this->getPassword()
        ];

        $json_data = json_encode($ownerInfo, JSON_PRETTY_PRINT);
        file_put_contents($filenameCarOwner, $json_data);
    }

// находит только машины определенного владельца, создает массив

    public function findOwnerCars(): array
    {
        $findOwner = $this->getFirstName() . $this->getLastName();
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

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
        $this->validator->validateCharacterCount($firstName, 2);
        $this->validator->validateNamePart($firstName);
        $this->firstName = $firstName;
        $this->validator->verifyInputFields($firstName);
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

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
        $this->validator->verifyInputFields($lastName);
    }

    public function getOwnerEmail(): string
    {
        return $this->ownerEmail;
    }

    public function setOwnerEmail(string $ownerEmail): void
    {
        $this->ownerEmail = $ownerEmail;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
}