<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInite275b532ed84938a3b0f150c8ea5f19a
{
    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInite275b532ed84938a3b0f150c8ea5f19a::$classMap;

        }, null, ClassLoader::class);
    }
}