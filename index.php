<?php
require_once __DIR__ . '/constants.php';
require_once APP_DIR . 'Vehicle.php';
require_once APP_DIR . 'Car.php';
require_once APP_DIR . 'SparePart.php';
require_once APP_DIR . 'Validator.php';
require_once APP_DIR . 'CarOwner.php';


try {

    $car = new Car('GHI789', 2017, 'Chevrolet', 'Sedan', new Validator());
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

    $carOwner->displayOwnerCarsInfo(); //поиск всех авто определенного владельца


} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}