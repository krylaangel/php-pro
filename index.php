<?php
define('APP_DIR', __DIR__ . '/');

require_once APP_DIR . 'Vehicle.php';
require_once APP_DIR . 'Car.php';
require_once APP_DIR . 'SparePart.php';
require_once APP_DIR . 'ValidationController.php';
require_once APP_DIR . 'CarOwner.php';


try {
    $filenameCareInfo = 'car_info.json';
    $filenameCarOwner = 'car_owner.json';

    $car = new Car('GHI789', 2017, 'Chevrolet', 'Sedan');
    $car->addSparePart(new SparePart('Engine Oil', 'Some Model', 50));
    $car->addSparePart(new SparePart('Brake Pads', 'Another Model', 100));
    $FirstAllSparePartsInfo = $car->getAllSpareParts();


    $anotherCar = new Car('ABC123', 2019, 'Toyota', 'SUV');
    $anotherCar->addSparePart(new SparePart('Brake Pads', 'Another Model', 200));
    $SecondAllSparePartsInfo = $anotherCar->getAllSpareParts();

    $carOwner = new CarOwner('John Doe', 389876543210);
    $carOwner->addVehicle($anotherCar);
    $carOwner->writeOwnerInfo($filenameCarOwner);

    $allCarsInfo = array($car->getData(), $anotherCar->getData());
    $anotherCar->writeInfoVehicleEquipment($filenameCareInfo);
    $car->writeInfoVehicleEquipment($filenameCareInfo);

// цикл, що шукає власника авто
    foreach ($carOwner->getVehicleInfo() as $vehicleInfo) {
        if ($vehicleInfo instanceof Car) {
            echo "<pre>";
            var_dump('Owner car is: ' . $carOwner->getFullName() . "\n");
            var_dump($vehicleInfo->getData());
            echo "</pre>";
        }
    }

    echo "<pre>";
    print_r($anotherCar);
    print_r($car);
//    print_r($carOwner); вивід інфо про власника, його авто та запчастини до авто

    echo "</pre>";


} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}