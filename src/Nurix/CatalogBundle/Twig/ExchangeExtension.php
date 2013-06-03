<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Admin
 * Date: 17.02.13
 * Time: 12:50
 * To change this template use File | Settings | File Templates.
 */
namespace Nurix\CatalogBundle\Twig;

use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\ORM\EntityRepository;

class ExchangeExtension extends \Twig_Extension
{
    protected $doctrine;

    public function __construct(RegistryInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function getFilters()
    {
        return array(
            'price' => new \Twig_Filter_Method($this, 'priceFilter',array(
                'is_safe' => array('html')
            )),
        );
    }

    public function priceFilter($number,$exchange='USD', $decimals = 1, $decPoint = '.')
    {
        if($exchange == 'USD')
        {
            $price = number_format($number, $decimals, $decPoint,'');
            $price = '$'.'<span class="value">'.$price.'</span>';
        }
        elseif ($exchange == 'SOM')
        {
            // TODO Надо исправить, чтобы брать из базы, теперь берет из базы
            $repository = $this -> doctrine ->getRepository("CatalogBundle:Exchange");

            $exchange_rate = $repository -> getRate();
            foreach($exchange_rate as $key=>$value){
                foreach($value as $key2 =>$value2){
                $price = number_format($number*$value2, $decimals, $decPoint,'');
                $price = '<span class="value">'.$price.'</span>'.' сом';
                }
            }

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