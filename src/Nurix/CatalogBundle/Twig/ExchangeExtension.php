<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Admin
 * Date: 17.02.13
 * Time: 12:50
 * To change this template use File | Settings | File Templates.
 */
namespace Nurix\CatalogBundle\Twig;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Nurix\CatalogBundle\Entity\Exchange;
use Nurix\CatalogBundle\Entity\ExchangeCurrency;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\TwigBundle\Debug\TimedTwigEngine;
use Symfony\Component\HttpFoundation\Request;

class ExchangeExtension extends \Twig_Extension
{
	/**
	 * @var Registry
	 */
	protected $doctrine;
	/**
	 * @var TimedTwigEngine
	 */
	private $templating;
	/**
	 * @var Request
	 */
	private $request;
	/**
	 * @var
	 */
	private $container;

	public function __construct($doctrine, $container)
	{
		$this->doctrine = $doctrine;
		$this->container = $container;
	}

	public function getFunctions()
	{
		return array(
			'exchange_list' => new \Twig_Function_Method($this, 'showExchangeList', array('is_safe' => array('html')))
		);
	}

	public function getFilters()
	{
		return array(
			'price' => new \Twig_Filter_Method($this, 'priceFilter', array(
					'is_safe' => array('html')
				))
		);
	}

	public function priceFilter($number, $currentCurrency = 'USD', $decimals = 0, $decPoint = '.')
	{
		/** @var $currentCurrency ExchangeCurrency */
		$currentCurrency = $this->getCurrentExchange();
		if (!$currentCurrency || $currentCurrency->getCurrency() == 'USD')
		{
			$price = number_format($number, $decimals, $decPoint, '');
			$price = '<span class="value">$' . $price . '</span>';

		}
		else
		{
			$exchange_rate = $this->doctrine->getRepository("CatalogBundle:Exchange")->getRate($currentCurrency);
			//var_dump("test");die;
			if ($exchange_rate)
			{
				$currency_name = $currentCurrency->getCurrencyName();
				$price = number_format($number * $exchange_rate->getExchangeRate(), $decimals, $decPoint, '');
				$price = '<span class="value">' . $price . ' ' . $currency_name . '</span>';
			}
			else
				throw new \Symfony\Component\DependencyInjection\Exception\InvalidArgumentException('Не правильная валюта! ' . $currentCurrency);

		}
		return $price;
	}

	public function showExchangeList()
	{
		$exchangeList = $this->doctrine->getRepository("CatalogBundle:ExchangeCurrency")->findAll();

		/** @var $exchangeHelper ExchangeCurrency */
		$currentCurrency = $this->getCurrentExchange();

		return $this->container->get('templating')->render(
			"CatalogBundle:Exchange:list.html.twig", array('exchangeList' => $exchangeList, 'currentCurrency' => $currentCurrency)
		);
	}

	private function getCurrentExchange()
	{
		$currentExchangeCookie = $this->container->get('request')->cookies->get('currency', 'USD');
		return $this->doctrine->getRepository("CatalogBundle:ExchangeCurrency")->findOneBy(array('currency' => $currentExchangeCookie));
	}

	public function getName()
	{
		return 'exchange_extension';
	}
}