<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';


use App\CarMaster\Entity\Car;
use App\CarMaster\Entity\CarOwner;
use App\CarMaster\Entity\Exception\FileOperationException;
use App\CarMaster\Entity\Exception\FormatException;
use App\CarMaster\Entity\Exception\InputException;
use App\CarMaster\Entity\Exception\LengthException;
use App\CarMaster\Entity\SparePart;
use App\CarMaster\Entity\Validator;
use App\Command\CreatSparePart;
use const CarMaster\Write_files\CAR_INFO_JSON;
use const CarMaster\Write_files\CAR_OWNER_JSON;


try {
    $faker = Faker\Factory::create();

    $car = new Car('I2II5KK', 2017, 'Chevrolet', 'Sedan', new Validator());
    $car->addSparePart(new SparePart('Engine Oil', 'Some Model', 50, new Validator()));
    $car->addSparePart(new SparePart('Brake Pads', 'Another Model', 5, new Validator()));
    $firstAllSparePartsInfo = $car->getAllSpareParts();

    $anotherCar = new Car('ABC123', 2019, 'Toyota', 'SUV', new Validator());
    $anotherCar->addSparePart(new SparePart('Brake Pads', 'Another Model', 200, new Validator()));
    $secondAllSparePartsInfo = $anotherCar->getAllSpareParts();

    $ownerEmail = $faker->email();
    $firstName = $faker->firstName();
    $lastName = $faker->lastName();
    $password = $faker->password();

    $carOwner = new CarOwner($firstName, $lastName, $password, 389876543205, $ownerEmail, new Validator());
    $carOwner->addVehicle($anotherCar);
    $carOwner->addVehicle($car);

    $carOwner->writeOwnerInfo(CAR_OWNER_JSON);

    $allCarsInfo = array($car->getInformation(), $anotherCar->getInformation());
    $anotherCar->writeInfoEquipment(CAR_INFO_JSON);
    $car->writeInfoEquipment(CAR_INFO_JSON);

    $carOwner->writeOwnerCarsInfo(); //поиск всех авто определенного владельца

    $creatSparePart = new CreatSparePart();


} catch (InputException|FormatException|LengthException|FileOperationException $e) {
    echo "Error: " . $e->getMessage();
} catch (Exception $e) {
    echo "An unknown error occurred: " . $e->getMessage();
}