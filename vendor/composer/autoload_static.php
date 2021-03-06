<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit79fb57cad9369705dc4278c2df68c150
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Panigale\\Point\\' => 15,
            'Panigale\\Payment\\' => 17,
            'Pagniale\\GoMyPay\\' => 17,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Panigale\\Point\\' => 
        array (
            0 => __DIR__ . '/..' . '/panigale/laravel5-point-system/src',
        ),
        'Panigale\\Payment\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
        'Pagniale\\GoMyPay\\' => 
        array (
            0 => __DIR__ . '/..' . '/panigale/laravel5-gomypay/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit79fb57cad9369705dc4278c2df68c150::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit79fb57cad9369705dc4278c2df68c150::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
