<?php

declare(strict_types=1);

namespace App\Eloquent\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

require __DIR__ . '/../../../vendor/autoload.php';


class SparePart extends Model
{
    protected $table = 'spare_part';
    protected $primaryKey = 'spare_part_id';
    public $timestamps = false;
    public function cars(): HasMany
    {
        return $this->hasMany(Car::class, 'vehicle_id')->where(['type'=>'Car']);

    }

    public function getPartInfo(): array
    {
        return [
            'Name Part' => $this->namePart(),
            'Model Part' => $this->modelPart(),
            'Price Part' => $this->pricePart()
        ];
    }



}