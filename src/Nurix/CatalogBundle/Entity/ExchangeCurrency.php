<?php

namespace Nurix\CatalogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Exchange
 *
 * @ORM\Table(name="exchange_currency")
 * @ORM\Entity
 */
class ExchangeCurrency
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="currency", type="string", length=50, nullable=true)
     */
    private $currency;

    /**
     * @var string
     *
     * @ORM\Column(name="currency_name", type="string", length=50, nullable=true)
     */
    private $currencyName;



    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set currency
     *
     * @param string $currency
     * @return ExchangeCurrency
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    
        return $this;
    }

    /**
     * Get currency
     *
     * @return string 
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Set currencyName
     *
     * @param string $currencyName
     * @return ExchangeCurrency
     */
    public function setCurrencyName($currencyName)
    {
        $this->currencyName = $currencyName;
    
        return $this;
    }

    /**
     * Get currencyName
     *
     * @return string 
     */
    public function getCurrencyName()
    {
        return $this->currencyName;
    }

    public function __toString()
    {
        return $this->getCurrency()?$this->getCurrency():"";
    }
}