<?php

namespace Nurix\CatalogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ExchangeHelper
 *
 * @ORM\Table(name="exchange_helper")
 * @ORM\Entity
 */
class ExchangeHelper
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
     * @return ExchangeHelper
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

    public function __toString()
    {

        return $this->getCurrency()?$this->getCurrency():"";
    }
}