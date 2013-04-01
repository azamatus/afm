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
     *@ORM\JoinColumn(name="cTypeId", referencedColumnName="id")
     * })

     */
    protected $cTypeId;

    /**
     * @var integer $goodId
     * @ORM\ManyToOne(targetEntity="Goods")
     * @ORM\JoinColumns({
     *@ORM\JoinColumn(name="goodId", referencedColumnName="id")
     * })
     */
    protected $goodId;

    /**
     * @var string $value
     *
     * @ORM\Column(name="value", type="string", length=100, nullable=true)
     */
    protected $value;

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
     * @param Nurix\CatalogBundle\Entity\Goods $goodId
     * @return Characteristic
     */
    public function setGoodId(\Nurix\CatalogBundle\Entity\Goods $goodId = null)
    {
        $this->goodId = $goodId;
    
        return $this;
    }

    /**
     * Get goodId
     *
     * @return Nurix\CatalogBundle\Entity\Goods 
     */
    public function getGoodId()
    {
        return $this->goodId;
    }
}