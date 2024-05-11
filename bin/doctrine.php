<?php
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;
use CarMaster\ServiceFactory;
require_once "vendor/autoload.php";

$serviceFactory = new ServiceFactory();
$entityManager = $serviceFactory->createORMEntityManager();

ConsoleRunner::run(new SingleManagerProvider($entityManager));