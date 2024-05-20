<?php

declare(strict_types=1);

namespace App\Eloquent\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

require __DIR__ . '/../../../vendor/autoload.php';


class CarOwner extends Model
{
    protected $table = 'car_owner';
    protected $primaryKey = 'owner_id';
    public $timestamps = false;

    public function cars(): HasMany
    {
        return $this->hasMany(Car::class, 'vehicle_id')->where(['type'=>'Car']);
    }
    public function getOwnerInfo(): array
    {
        return [
            'First Name' => $this->firstName(),
            'Last Name' => $this->lastName(),
            'Contact Number' => $this->contactNumber(),
            'Email' => $this->ownerEmail(),
            'Password' => $this->password()
        ];
    }



// находит только машины определенного владельца, создает массив

    public function findOwnerCars(): array
    {
        $findOwner = $this->firstName() . $this->lastName();
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
    public function addVehicle(Vehicle $vehicleInfo): void
    {
        $this->vehicleInfo[] = $vehicleInfo;
    }

    public function getVehicleInfo(): array
    {
        return $this->vehicleInfo;
    }

}