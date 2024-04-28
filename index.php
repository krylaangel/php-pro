<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';


use CarMaster\Car;
use CarMaster\CarOwner;
use CarMaster\Exception\FileOperationException;
use CarMaster\Exception\FormatException;
use CarMaster\Exception\InputException;
use CarMaster\Exception\LengthException;
use CarMaster\SparePart;
use CarMaster\Validator;

const APP_DIR = __DIR__ . '/';

const JSON_DIR = \CarMaster\APP_DIR . 'json_files/';
const CAR_OWNER_JSON = \CarMaster\JSON_DIR . 'car_owner.json';
const CAR_INFO_JSON = JSON_DIR . 'car_info.json';
const OWNER_CARS_INFO = JSON_DIR . 'owner_cars_info.json';


try {
    $faker = Faker\Factory::create();

    $car = new Car('I2II5KK', 2017, 'Chevrolet', 'Sedan', new Validator());
    $car->addSparePart(new SparePart('Engine Oil', 'Some Model', 50, new Validator()));
    $car->addSparePart(new SparePart('Brake Pads', 'Another Model', 5, new Validator()));
    $firstAllSparePartsInfo = $car->getAllSpareParts();

    $anotherCar = new Car('ABC123', 2019, 'Toyota', 'SUV', new Validator());
    $anotherCar->addSparePart(new SparePart('Brake Pads', 'Another Model', 200, new Validator()));
    $secondAllSparePartsInfo = $anotherCar->getAllSpareParts();
//
    $ownerEmail = $faker->email();
    $fullName = $faker->name();

    $carOwner = new CarOwner($fullName, 389876543205, $ownerEmail, new Validator());
    $carOwner->addVehicle($anotherCar);
    $carOwner->addVehicle($car);

    $carOwner->writeOwnerInfo(CAR_OWNER_JSON);

    $allCarsInfo = array($car->getInformation(), $anotherCar->getInformation());
    $anotherCar->writeInfoEquipment(CAR_INFO_JSON);
    $car->writeInfoEquipment(CAR_INFO_JSON);

    $carOwner->writeOwnerCarsInfo(); //поиск всех авто определенного владельца


} catch (InputException|FormatException|LengthException|FileOperationException $e) {
    echo "Error: " . $e->getMessage();
} catch (Exception $e) {
    echo "An unknown error occurred: " . $e->getMessage();
}