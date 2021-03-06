<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Admin
 * Date: 02.02.13
 * Time: 14:22
 * To change this template use File | Settings | File Templates.
 */
namespace Nurix\CatalogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Nurix\CatalogBundle\Entity\Characteristic
 *
 * @ORM\Table(name="characteristic")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Nurix\CatalogBundle\Entity\CharacteristicRepository")
 */

class Characteristic
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;
    /**
     * @var integer $cTypeId
     *
     * @ORM\ManyToOne(targetEntity="CharacteristicType")
     * @ORM\JoinColumns({
     *@ORM\JoinColumn(name="cTypeId", referencedColumnName="id", nullable=false)
     * })

     */
    protected $cTypeId;


    /**
     * @var string $value
     *
     * @ORM\Column(name="value", type="string", length=255, nullable=true)
     */
    protected $value;

    /**
     * @var integer $goodId
     *
     * @ORM\Column(name="goodId", type="integer")
     */
    protected $goodId;

    /**
     * @var Goods
     *
     * @ORM\ManyToOne(targetEntity="Goods", inversedBy="characteristic")
     * @ORM\JoinColumns({
     *@ORM\JoinColumn(name="goodId", referencedColumnName="id", nullable=false)
     * })
     */
    protected $good;

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
     * Set value
     *
     * @param string $value
     * @return Characteristic
     */
    public function setValue($value)
    {
        $this->value = $value;
    
        return $this;
    }

    /**
     * Get value
     *
     * @return string 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set cTypeId
     *
     * @param Nurix\CatalogBundle\Entity\CharacteristicType $cTypeId
     * @return Characteristic
     */
    public function setCTypeId(\Nurix\CatalogBundle\Entity\CharacteristicType $cTypeId = null)
    {
        $this->cTypeId = $cTypeId;
    
        return $this;
    }

    /**
     * Get cTypeId
     *
     * @return Nurix\CatalogBundle\Entity\CharacteristicType 
     */
    public function getCTypeId()
    {
        return $this->cTypeId;
    }

    /**
     * Set goodId
     *
     * @param integer $goodId
     * @return Characteristic
     */
    public function setGoodId($goodId)
    {
        $this->goodId = $goodId;

        return $this;
    }

    /**
     * Get goodId
     *
     * @return integer
     */
    public function getGoodId()
    {
        return $this->goodId;
    }

    /**
     * Set good
     *
     * @param \Nurix\CatalogBundle\Entity\Goods $good
     * @return Characteristic
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

    public function __toString()
    {
        return $this->getCTypeId()->getName(). " ==> ".$this->getValue();
    }
}