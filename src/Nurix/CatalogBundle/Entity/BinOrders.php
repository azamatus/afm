<?php

namespace Nurix\CatalogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BinOrders
 *
 * @ORM\Table(name="bin_orders")
 * @ORM\Entity(repositoryClass="Nurix\CatalogBundle\Entity\BinOrdersRepository")
 */
class BinOrders
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
     * @var integer
     *
     * @ORM\Column(name="amount", type="integer", nullable=true)
     */
    private $amount;

    /**
     * @var float
     *
     * @ORM\Column(name="coast", type="float", nullable=false)
     */
    private $coast;

    /**
     * @var \BinClients
     *
     * @ORM\ManyToOne(targetEntity="BinClients")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="bin_client_id", referencedColumnName="id")
     * })
     */
    private $binClient;

    /**
     * @var \Goods
     *
     * @ORM\ManyToOne(targetEntity="Goods")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="good_id", referencedColumnName="id")
     * })
     */
    private $good;

    /**
     * @var enum
     *
     * @ORM\Column(name="status", type="enumstatus")
     */
    private $status = 1;


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
     * Set amount
     *
     * @param integer $amount
     * @return BinOrders
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    
        return $this;
    }

    /**
     * Get amount
     *
     * @return integer 
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set coast
     *
     * @param float $coast
     * @return BinOrders
     */
    public function setCoast($coast)
    {
        $this->coast = $coast;
    
        return $this;
    }

    /**
     * Get coast
     *
     * @return float 
     */
    public function getCoast()
    {
        return $this->coast;
    }

    /**
     * Set binClient
     *
     * @param \Nurix\CatalogBundle\Entity\BinClients $binClient
     * @return BinOrders
     */
    public function setBinClient(\Nurix\CatalogBundle\Entity\BinClients $binClient = null)
    {
        $this->binClient = $binClient;
    
        return $this;
    }

    /**
     * Get binClient
     *
     * @return \Nurix\CatalogBundle\Entity\BinClients 
     */
    public function getBinClient()
    {
        return $this->binClient;
    }

    /**
     * Set good
     *
     * @param \Nurix\CatalogBundle\Entity\Goods $good
     * @return BinOrders
     */
    public function setGood(\Nurix\CatalogBundle\Entity\Goods $good = null)
    {
        $this->good = $good;
    
        return $this;
    }

    /**
     * Get good
     *
     * @return \Nurix\CatalogBundle\Entity\Goods 
     */
    public function getGood()
    {
        return $this->good;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return BinOrders
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }
}