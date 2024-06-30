<?php
declare(strict_types=1);

namespace App\CarMaster\Entity\Enum;

enum BodyTypes: string
{
    case NONE = 'N/A';
    case SEDAN = 'Sedan';
    case SUV = 'SUV';
    case HATCHBACK = 'Hatchback';
    case COUPE = 'Coupe';
    case CONVERTIBLE = 'Convertible';
    case VAN = 'Van';
    case TRUCK = 'Truck';
    case WAGON = 'Wagon';

    public static function toArray(): array
    {
        return [
            self::SEDAN,
            self::SUV,
            self::HATCHBACK,
            self::COUPE,
            self::CONVERTIBLE,
            self::VAN,
            self::TRUCK,
            self::WAGON
];
    }

}
