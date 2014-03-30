<?php
/**
 * Created by PhpStorm.
 * User: bupychuk
 * Date: 31.03.14
 * Time: 3:41
 */

namespace Nurix\NurixBundle\Twig;


class CeilExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            'ceil' => new \Twig_Filter_Method($this, 'ceil'),
        );
    }

    public function ceil($number)
    {
        return ceil($number);
    }

    public function getName()
    {
        return 'ceil_extension';
    }
}