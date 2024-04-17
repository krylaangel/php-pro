<?php

declare(strict_types=1);
require_once 'autoloader.php';

use CarMaster\Car;
use CarMaster\SparePart;
use CarMaster\Validator;
use CarMaster\CarOwner;
use CarMaster\Exception\InputException;
use CarMaster\Exception\LengthException;
use CarMaster\Exception\FormatException;
use CarMaster\Exception\FileOperationException;


use const CarMaster\CAR_INFO_JSON;
use const CarMaster\CAR_OWNER_JSON;

try {
    $car = new Car('Chevrolet', 2017, 'Chevrolet', 'Sedan', new Validator());
    $car->addSparePart(new SparePart('Engine Oil', 'Some Model', 50, new Validator()));
    $car->addSparePart(new SparePart('Brake Pads', 'Another Model', 5, new Validator()));
    $firstAllSparePartsInfo = $car->getAllSpareParts();

    $anotherCar = new Car('ABC123', 2019, 'Toyota', 'SUV', new Validator());
    $anotherCar->addSparePart(new SparePart('Brake Pads', 'Another Model', 200, new Validator()));
    $secondAllSparePartsInfo = $anotherCar->getAllSpareParts();

    $carOwner = new CarOwner('John Doe', 389876543205, new Validator());
    $carOwner->addVehicle($anotherCar);
    $carOwner->addVehicle($car);

    $carOwner->writeOwnerInfo(CAR_OWNER_JSON);

    $allCarsInfo = array($car->getInformation(), $anotherCar->getInformation());
    $anotherCar->writeInfoEquipment(CAR_INFO_JSON);
    $car->writeInfoEquipment(CAR_INFO_JSON);

    $carOwner->writeOwnerCarsInfo(); //поиск всех авто определенного владельца


} catch (InputException $e) {
    echo "Input validation error: " . $e->getMessage();
} catch (FormatException $e) {
    echo "Data format error: " . $e->getMessage();
} catch (LengthException $e) {
    echo "Data length error: " . $e->getMessage();
} catch (FileOperationException $e) {
    echo "File operation error: " . $e->getMessage();
} catch
(Exception $e) {
    echo "An unknown error occurred: " . $e->getMessage();
}