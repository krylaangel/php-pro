<?php

class CarOwner
{
    protected ValidationController $validator;
    private string $fullName;
    protected array $vehicleInfo = [];
    private int $contactNumber;

    /**
     * @throws Exception
     */
    public function __construct(string $fullName, int $contactNumber)
    {
        $this->validator = new ValidationController();
        $this->setFullName($fullName);
        $this->setContactNumber($contactNumber);
    }

    public function addVehicle(Vehicle $vehicleInfo): void
    {
        $this->vehicleInfo[] = $vehicleInfo;
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

    public function getVehicleInfo(): array
    {
        return $this->vehicleInfo;
    }

    /**
     * @return string
     */
    public function getFullName(): string
    {
        return $this->fullName;
    }

    /**
     * @param string $fullName
     * @throws Exception
     */
    public function setFullName(string $fullName): void
    {
        $this->validator->validateCharacterCount($fullName, 2);
        $this->validator->validateNamePart($fullName);
        $this->fullName = $fullName;
    }

    /**
     * @return int
     */
    public function getContactNumber(): int
    {
        return $this->contactNumber;
    }

    /**
     * @param int $contactNumber
     * @throws Exception
     */
    public function setContactNumber(int $contactNumber): void
    {
        $this->validator->validateCharacterCount($contactNumber, 12);
        $this->contactNumber = $contactNumber;
    }

}