<?php
/**
 * Created by PhpStorm.
 * User: bupychuk
 * Date: 26.03.14
 * Time: 18:09
 */

namespace Strokit\ConfigBundle\Admin;


use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Route\RouteCollection;

class ConfigAdmin extends Admin
{

    protected $baseRoutePattern = 'config';
    protected $baseRouteName = 'admin_config';

    /**
     * {@inheritdoc}
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clear();
        $collection->add('config');
        $collection->add('cacheclear');
    }
} 