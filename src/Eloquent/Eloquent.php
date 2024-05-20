<?php

declare(strict_types=1);
namespace App\Eloquent;

use Illuminate\Database\Capsule\Manager as Capsule;

require dirname(__DIR__) . '/../vendor/autoload.php';
class Eloquent
{
    public function configure():void
    {
        $capsule = new Capsule;
        $capsule->addConnection([
            'driver' => 'mysql',
            'host' => getenv('DB_HOST'),
            'database' => getenv('DB_NAME'),
            'username' => getenv('DB_USER'),
            'password' => getenv('DB_PASSWORD'),
        ]);
        $capsule->bootEloquent();
    }

}


