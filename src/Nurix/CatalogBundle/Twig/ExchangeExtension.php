<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Admin
 * Date: 17.02.13
 * Time: 12:50
 * To change this template use File | Settings | File Templates.
 */
namespace Nurix\CatalogBundle\Twig;

class ExchangeExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            'price' => new \Twig_Filter_Method($this, 'priceFilter'),
        );
    }

    public function priceFilter($number,$exchange='USD', $decimals = 2, $decPoint = '.')
    {
        if($exchange == 'USD')
        {
            $price = number_format($number, $decimals, $decPoint,'');
            $price = '$'.$price;
        }
        elseif ($exchange == 'SOM')
        {
            // TODO Надо исправить, чтобы брать из базы
            $price = number_format($number*47.8, $decimals, $decPoint,'');
            $price = $price.' сом';
        }
        else
        {
            throw new \Symfony\Component\DependencyInjection\Exception\InvalidArgumentException('Не правильная валюта!'.$exchange);

        }
        return $price;
    }

    public function getName()
    {
        return 'exchange_extension';
    }
}