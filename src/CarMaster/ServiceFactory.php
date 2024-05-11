<?php

declare(strict_types=1);

namespace CarMaster;

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use PDO;

require_once "vendor/autoload.php";


class ServiceFactory
{
    public function createPDO(): PDO
    {
        $pdo = new PDO(
            sprintf('mysql:host=%s;dbname=%s', getenv('DB_HOST'), getenv('DB_NAME')),
            getenv('DB_USER'),
            getenv('DB_PASSWORD')
        );
        $pdo->query('SET NAMES utf8mb4');

        return $pdo;
    }

    public function createORMEntityManager(): EntityManager
    {
        $config = ORMSetup::createAttributeMetadataConfiguration(
            paths: [__DIR__ . '/Entity'],
            isDevMode: true,
        );
        $connection = DriverManager::getConnection([
            'driver' => 'pdo_mysql',
            'host' => getenv('DB_HOST'),
            'user' => getenv('DB_USER'),
            'password' => getenv('DB_PASSWORD'),
            'dbname' => getenv('DB_NAME'),
        ], $config);
        return new EntityManager($connection, $config);
    }
    }