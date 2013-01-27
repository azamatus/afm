<?php

namespace Catalog\CatalogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Catalog\CatalogBundle\Entity\Goods
 *
 * @ORM\Table(name="goods")
 * @ORM\Entity
 */
class Goods
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=50, nullable=false)
     */
    private $name;
    /**
     * @var string $shortDescription
     *
     * @ORM\Column(name="short_description", type="text", nullable=false)
     */
    private $shortDescription;

    /**
     * @var string $fullDesctiption
     *
     * @ORM\Column(name="full_desctiption", type="text", nullable=false)
     */
    private $fullDesctiption;

    /**
     * @var float $price
     *
     * @ORM\Column(name="price", type="decimal", nullable=false)
     */
    private $price;

    /**
     * @var string $imagePath
     *
     * @ORM\Column(name="image_path", type="string", length=50, nullable=false)
     */
    private $imagePath;

    /**
     * @var Catalog
     *
     * @ORM\ManyToOne(targetEntity="Catalog")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="catalog_id", referencedColumnName="id")
     * })
     */
    private $catalog;



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
     * Set name
     *
     * @param string $name
     * @return Goods
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Set shortDescription
     *
     * @param string $shortDescription
     * @return Goods
     */
    public function setShortDescription($shortDescription)
    {
        $this->shortDescription = $shortDescription;
    
        return $this;
    }

    /**
     * Get shortDescription
     *
     * @return string 
     */
    public function getShortDescription()
    {
        return $this->shortDescription;
    }

    /**
     * Set fullDesctiption
     *
     * @param string $fullDesctiption
     * @return Goods
     */
    public function setFullDesctiption($fullDesctiption)
    {
        $this->fullDesctiption = $fullDesctiption;
    
        return $this;
    }

    /**
     * Get fullDesctiption
     *
     * @return string 
     */
    public function getFullDesctiption()
    {
        return $this->fullDesctiption;
    }

    /**
     * Set price
     *
     * @param float $price
     * @return Goods
     */
    public function setPrice($price)
    {
        $this->price = $price;
    
        return $this;
    }

    /**
     * Get price
     *
     * @return float 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set imagePath
     *
     * @param string $imagePath
     * @return Goods
     */
    public function setImagePath($imagePath)
    {
        $this->imagePath = $imagePath;
    
        return $this;
    }

    /**
     * Get imagePath
     *
     * @return string 
     */
    public function getImagePath()
    {
        return $this->imagePath;
    }

    /**
     * Set catalog
     *
     * @param Catalog\CatalogBundle\Entity\Catalog $catalog
     * @return Goods
     */
    public function setCatalog(\Catalog\CatalogBundle\Entity\Catalog $catalog = null)
    {
        $this->catalog = $catalog;
    
        return $this;
    }

    /**
     * Get catalog
     *
     * @return Catalog\CatalogBundle\Entity\Catalog 
     */
    public function getCatalog()
    {
        return $this->catalog;
    }
}