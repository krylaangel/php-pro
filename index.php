<?php
declare(strict_types=1);
require_once 'autoloader.php';

use CarMaster\Car;
use CarMaster\SparePart;
use CarMaster\Validator;
use CarMaster\CarOwner;
use const CarMaster\CAR_INFO_JSON;
use const CarMaster\CAR_OWNER_JSON;
//use const CarMaster\OWNER_CARS_INFO;


try {

    $car = new Car('Chevrolet', 2017, 'Chevrolet', 'Sedan', new Validator());
    $car->addSparePart(new SparePart('Engine Oil', 'Some Model', 50));
    $car->addSparePart(new SparePart('Brake Pads', 'Another Model', 100));
    $firstAllSparePartsInfo = $car->getAllSpareParts();

    $anotherCar = new Car('ABC123', 2019, 'Toyota', 'SUV', new Validator());
    $anotherCar->addSparePart(new SparePart('Brake Pads', 'Another Model', 200));
    $secondAllSparePartsInfo = $anotherCar->getAllSpareParts();

    $carOwner = new CarOwner('John Doe', 389876543210, new Validator());
    $carOwner->addVehicle($anotherCar);
    $carOwner->addVehicle($car);

    $carOwner->writeOwnerInfo(CAR_OWNER_JSON);

    $allCarsInfo = array($car->getInformation(), $anotherCar->getInformation());
    $anotherCar->writeInfoEquipment(CAR_INFO_JSON);
    $car->writeInfoEquipment(CAR_INFO_JSON);

    $carOwner->writeOwnerCarsInfo(); //поиск всех авто определенного владельца


} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}