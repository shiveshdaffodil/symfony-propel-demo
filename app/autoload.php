<?php

use Symfony\Component\ClassLoader\UniversalClassLoader;

$loader = new UniversalClassLoader();
$loader->registerNamespaces(array(
    'Symfony'          => array(__DIR__.'/../vendor/symfony/src', __DIR__.'/../vendor/bundles'),
    'Monolog'          => __DIR__.'/../vendor/monolog/src',
));
$loader->registerPrefixes(array(
    'Twig_'            => __DIR__.'/../vendor/twig/lib',
));

// intl
if (!function_exists('intl_get_error_code')) {
    require_once __DIR__.'/../vendor/symfony/src/Symfony/Component/Locale/Resources/stubs/functions.php';

    $loader->registerPrefixFallbacks(array(__DIR__.'/../vendor/symfony/src/Symfony/Component/Locale/Resources/stubs'));
}

if (!interface_exists('SessionHandlerInterface')) {
    require_once __DIR__.'/../vendor/symfony/src/Symfony/Component/HttpFoundation/Resources/stubs/SessionHandlerInterface.php';
}

$loader->registerNamespaceFallbacks(array(
    __DIR__.'/../src',
    __DIR__.'/../vendor/bundles',
));
$loader->register();
