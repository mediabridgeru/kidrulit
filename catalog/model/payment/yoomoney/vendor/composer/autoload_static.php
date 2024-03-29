<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitb00d954f09ad1b76d616f8d6d51779fe
{
    public static $prefixLengthsPsr4 = array (
        'Y' => 
        array (
            'YooKassa\\' => 9,
        ),
        'P' => 
        array (
            'Psr\\Log\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'YooKassa\\' => 
        array (
            0 => __DIR__ . '/..' . '/yoomoney/yookassa-sdk-php/lib',
        ),
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/Psr/Log',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitb00d954f09ad1b76d616f8d6d51779fe::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitb00d954f09ad1b76d616f8d6d51779fe::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitb00d954f09ad1b76d616f8d6d51779fe::$classMap;

        }, null, ClassLoader::class);
    }
}
