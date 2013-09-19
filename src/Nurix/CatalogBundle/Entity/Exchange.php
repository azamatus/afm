<?php

namespace Nurix\CatalogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Exchange
 *
 * @ORM\Table(name="exchange")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Nurix\CatalogBundle\Entity\ExchangeRepository")
 */
class Exchange
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
     * @var float
     *
     * @ORM\Column(name="exchange_rate", type="float", nullable=true)
     */
    private $exchangeRate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date;

    /**
     * @var \ExchangeHelper
     *
     * @ORM\ManyToOne(targetEntity="ExchangeHelper")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="currency_id", referencedColumnName="id")
     * })
     */
    private $currency;


    public function __construct()
    {
        $this->date = new \DateTime();
    }
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
     * Set exchangeRate
     *
     * @param float $exchangeRate
     * @return Exchange
     */
    public function setExchangeRate($exchangeRate)
    {
        $this->exchangeRate = $exchangeRate;
    
        return $this;
    }

    /**
     * Get exchangeRate
     *
     * @return float 
     */
    public function getExchangeRate()
    {
        return $this->exchangeRate;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Exchange
     */
    public function setDate($date)
    {
        $this->date = $date;
    
        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set currency
     *
     * @param \Nurix\CatalogBundle\Entity\ExchangeHelper $currency
     * @return Exchange
     */
    public function setCurrency(\Nurix\CatalogBundle\Entity\ExchangeHelper $currency = null)
    {
        $this->currency = $currency;
    
        return $this;
    }

    /**
     * Get currency
     *
     * @return \Nurix\CatalogBundle\Entity\ExchangeHelper 
     */
    public function getCurrency()
    {
        return $this->currency;
    }
}