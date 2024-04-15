<?php

spl_autoload_register(
    function (string $className) {
        $classFilePath = str_replace('\\', DIRECTORY_SEPARATOR, $className);
        require_once(__DIR__ . DIRECTORY_SEPARATOR . $classFilePath . '.php');
    }
);
require_once(__DIR__ . DIRECTORY_SEPARATOR . 'CarMaster/' . 'paths_constants.php');
