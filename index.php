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
use const CarMaster\Write_files\CAR_INFO_JSON;
use const CarMaster\Write_files\CAR_OWNER_JSON;


try {
    $faker = Faker\Factory::create();

    $validator = new Validator();
    $car = new Car(null, 'I2II5KK', 2017, 'Chevrolet', 'Sedan', $validator);
    $car->addSparePart(new SparePart(null,'Engine Oil', 'Some Model', 50, $validator));
    $car->addSparePart(new SparePart(null,'Brake Pads', 'Another Model', 5, $validator));
    $firstAllSparePartsInfo = $car->getAllSpareParts();

    $anotherCar = new Car(null, 'ABC123', 2019, 'Toyota', 'SUV', $validator);
    $anotherCar->addSparePart(new SparePart(null,'Brake Pads', 'Another Model', 200, $validator));
    $secondAllSparePartsInfo = $anotherCar->getAllSpareParts();

    $ownerEmail = $faker->email();
    $firstName = $faker->firstName();
    $lastName = $faker->lastName();
    $password = $faker->password();

    $carOwner = new CarOwner(null, $firstName, $lastName, $password, 380661368736, $ownerEmail, $validator);
    $carOwner->addVehicle($anotherCar);
    $carOwner->addVehicle($car);

    $carOwner->writeOwnerInfoToFile(CAR_OWNER_JSON);

    $allCarsInfo = array($car->getInformation(), $anotherCar->getInformation());
    $anotherCar->writeInfoEquipment(CAR_INFO_JSON);
    $car->writeInfoEquipment(CAR_INFO_JSON);

    $carOwner->writeOwnerCarsInfo(); //поиск всех авто определенного владельца

} catch (InputException|FormatException|LengthException|FileOperationException $e) {
    echo "Error: " . $e->getMessage();
} catch (Exception $e) {
    echo "An unknown error occurred: " . $e->getMessage();
}