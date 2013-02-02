<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Junus
 * Date: 03.02.13
 * Time: 0:23
 * To change this template use File | Settings | File Templates.
 */

namespace Nurix\NurixBundle\Twig;

class DateExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            'proDate' => new \Twig_Filter_Method($this, 'proDateFilter'),
        );
    }

    public function proDateFilter(\DateTime $date)
    {
        $now = new \DateTime();
        if ($date->format('d') == $now->format('d')){
            $pro_date = 'Сегодня в ' . $date->format('H:i');
        }elseif($date->format('d') == $now->sub(new \DateInterval('P1D'))->format('d')){
            $pro_date = 'Вчера в ' . $date->format('H:i');
        }else{
            $month = array(
                1   => 'января',
                2   => 'февраля',
                3   => 'марта',
                4   => 'апреля',
                5   => 'мая',
                6   => 'июня',
                7   => 'июля',
                8   => 'августа',
                9   => 'сентября',
                10   => 'октября',
                11   => 'ноября',
                12   => 'декабря',
            );
            $pro_date = $date->format('j') . ' ' . $month[$date->format('n')];
        }

        return $pro_date;
    }

    public function getName()
    {
        return 'nurix_extension';
    }
}
