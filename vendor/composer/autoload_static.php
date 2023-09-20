<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit921460591a0b63aeaa3680984f8d23d5
{
    public static $files = array (
        '5255c38a0faeba867671b61dfda6d864' => __DIR__ . '/..' . '/paragonie/random_compat/lib/random.php',
    );

    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Stripe\\' => 7,
        ),
        'P' => 
        array (
            'Phlib\\Encrypt\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Stripe\\' => 
        array (
            0 => __DIR__ . '/..' . '/stripe/stripe-php/lib',
        ),
        'Phlib\\Encrypt\\' => 
        array (
            0 => __DIR__ . '/..' . '/phlib/encrypt/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit921460591a0b63aeaa3680984f8d23d5::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit921460591a0b63aeaa3680984f8d23d5::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit921460591a0b63aeaa3680984f8d23d5::$classMap;

        }, null, ClassLoader::class);
    }
}