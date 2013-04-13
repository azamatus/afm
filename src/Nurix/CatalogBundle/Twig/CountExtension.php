<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Admin
 * Date: 17.02.13
 * Time: 12:50
 * To change this template use File | Settings | File Templates.
 */
namespace Nurix\CatalogBundle\Twig;

class CountExtension extends \Twig_Extension {

    public function getFilters()
    {
        return array(
            'count' => new \Twig_Filter_Method($this, 'countFilter')
        );
    }

    public function countFilter($count,$single,$several,$many){
        $mod = $count%10;
        if($mod == 1 && $count%100 != 11){
            $amount = $single;
        }
        elseif(($mod > 1 && $mod < 5) && ($count%100 < 11 || $count%100 > 15) ){
            $amount = $several;
        }
        else $amount = $many;

        return $count.' '.$amount;
    }

    public function getName()
    {
        return 'count_extension';
    }
}