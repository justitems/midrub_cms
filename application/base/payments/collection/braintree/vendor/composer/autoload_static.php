<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit5d8d395603f7f539ce4c5dcdd04f60ec
{
    public static $prefixLengthsPsr4 = array (
        'B' => 
        array (
            'Braintree\\' => 10,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Braintree\\' => 
        array (
            0 => __DIR__ . '/..' . '/braintree/braintree_php/lib/Braintree',
        ),
    );

    public static $prefixesPsr0 = array (
        'B' => 
        array (
            'Braintree' => 
            array (
                0 => __DIR__ . '/..' . '/braintree/braintree_php/lib',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit5d8d395603f7f539ce4c5dcdd04f60ec::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit5d8d395603f7f539ce4c5dcdd04f60ec::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit5d8d395603f7f539ce4c5dcdd04f60ec::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}
