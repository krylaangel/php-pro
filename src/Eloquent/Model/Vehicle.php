<?php

declare(strict_types=1);

namespace App\Eloquent\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

abstract class Vehicle extends Model

{
    protected $table = 'vehicle';
    protected $primaryKey = 'vehicle_id';
    public $timestamps = false;

public function carOwner(): BelongsTo
{
    return $this->belongsTo(CarOwner::class, 'owner_id');
}
    public function spareParts(): HasMany
    {        return $this->hasMany(SparePart::class, 'spare_part_id');

    }

    public function getInformation(): array
    {
        return [
            'License Plate' => $this->licensePlate(),
            'Year of Manufacture' => $this->yearManufacture(),
            'Brand' => $this->brand()
        ];
    }

    abstract public function addSparePart(SparePart $partInfo);

    abstract public function getAllSpareParts();



}
