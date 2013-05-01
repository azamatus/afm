<?php

use Doctrine\Common\Annotations\AnnotationRegistry;

$loader = require __DIR__.'/../vendor/autoload.php';

// intl
if (!function_exists('intl_get_error_code')) {
    require_once __DIR__.'/../vendor/symfony/symfony/src/Symfony/Component/Locale/Resources/stubs/functions.php';

    $loader->add('', __DIR__.'/../vendor/symfony/symfony/src/Symfony/Component/Locale/Resources/stubs');
}
$loader->add('Knp\Bundle', __DIR__.'/../vendor/bundles');
$loader->add('Knp\Menu'  , __DIR__.'/../vendor/KnpMenu/src');

$loader->add('Knp\\Component', __DIR__.'/../vendor/knp-components/src');
$loader->add('Knp\\Bundle', __DIR__.'/../vendor/bundles');

AnnotationRegistry::registerLoader(array($loader, 'loadClass'));

return $loader;
