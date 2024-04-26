<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit1f2a5429743de295598442a5dbf2e20b
{
    public static $files = array (
        '0e6d7bf4a5811bfa5cf40c5ccd6fae6a' => __DIR__ . '/..' . '/symfony/polyfill-mbstring/bootstrap.php',
        '320cde22f66dd4f5d3fd621d3e88b98f' => __DIR__ . '/..' . '/symfony/polyfill-ctype/bootstrap.php',
        '8825ede83f2f289127722d4e842cf7e8' => __DIR__ . '/..' . '/symfony/polyfill-intl-grapheme/bootstrap.php',
        'e69f7f6ee287b969198c3c9d6777bd38' => __DIR__ . '/..' . '/symfony/polyfill-intl-normalizer/bootstrap.php',
        '6e3fae29631ef280660b3cdad06f25a8' => __DIR__ . '/..' . '/symfony/deprecation-contracts/function.php',
        'b6b991a57620e2fb6b2f66f03fe9ddc2' => __DIR__ . '/..' . '/symfony/string/Resources/functions.php',
        '54a408186e6c5db8581c9b48efad4e09' => __DIR__ . '/../..' . '/src/CarMaster/paths_constants.php',
    );

    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Symfony\\Polyfill\\Mbstring\\' => 26,
            'Symfony\\Polyfill\\Intl\\Normalizer\\' => 33,
            'Symfony\\Polyfill\\Intl\\Grapheme\\' => 31,
            'Symfony\\Polyfill\\Ctype\\' => 23,
            'Symfony\\Contracts\\Service\\' => 26,
            'Symfony\\Component\\String\\' => 25,
            'Symfony\\Component\\Console\\' => 26,
        ),
        'P' => 
        array (
            'Psr\\Container\\' => 14,
        ),
        'F' => 
        array (
            'Faker\\' => 6,
        ),
        'C' => 
        array (
            'CarMaster\\' => 10,
        ),
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Symfony\\Polyfill\\Mbstring\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-mbstring',
        ),
        'Symfony\\Polyfill\\Intl\\Normalizer\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-intl-normalizer',
        ),
        'Symfony\\Polyfill\\Intl\\Grapheme\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-intl-grapheme',
        ),
        'Symfony\\Polyfill\\Ctype\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-ctype',
        ),
        'Symfony\\Contracts\\Service\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/service-contracts',
        ),
        'Symfony\\Component\\String\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/string',
        ),
        'Symfony\\Component\\Console\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/console',
        ),
        'Psr\\Container\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/container/src',
        ),
        'Faker\\' => 
        array (
            0 => __DIR__ . '/..' . '/fakerphp/faker/src/Faker',
        ),
        'CarMaster\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/CarMaster',
        ),
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'App\\Command\\CarInformationCommand' => __DIR__ . '/../..' . '/src/Command/CarInformationCommand.php',
        'CarMaster\\Car' => __DIR__ . '/../..' . '/src/CarMaster/Car.php',
        'CarMaster\\CarOwner' => __DIR__ . '/../..' . '/src/CarMaster/CarOwner.php',
        'CarMaster\\Exception\\FileOperationException' => __DIR__ . '/../..' . '/src/CarMaster/Exception/FileOperationException.php',
        'CarMaster\\Exception\\FormatException' => __DIR__ . '/../..' . '/src/CarMaster/Exception/FormatException.php',
        'CarMaster\\Exception\\InputException' => __DIR__ . '/../..' . '/src/CarMaster/Exception/InputException.php',
        'CarMaster\\Exception\\LengthException' => __DIR__ . '/../..' . '/src/CarMaster/Exception/LengthException.php',
        'CarMaster\\Exception\\ValidationException' => __DIR__ . '/../..' . '/src/CarMaster/Exception/ValidationException.php',
        'CarMaster\\SparePart' => __DIR__ . '/../..' . '/src/CarMaster/SparePart.php',
        'CarMaster\\Validator' => __DIR__ . '/../..' . '/src/CarMaster/Validator.php',
        'CarMaster\\Vehicle' => __DIR__ . '/../..' . '/src/CarMaster/Vehicle.php',
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'Normalizer' => __DIR__ . '/..' . '/symfony/polyfill-intl-normalizer/Resources/stubs/Normalizer.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit1f2a5429743de295598442a5dbf2e20b::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit1f2a5429743de295598442a5dbf2e20b::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit1f2a5429743de295598442a5dbf2e20b::$classMap;

        }, null, ClassLoader::class);
    }
}