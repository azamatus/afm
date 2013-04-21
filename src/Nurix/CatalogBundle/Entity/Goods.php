<?php

namespace Nurix\CatalogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Nurix\CatalogBundle\Entity\Goods
 *
 * @ORM\Table(name="goods")
 * @ORM\Entity(repositoryClass="Nurix\CatalogBundle\Entity\GoodsRepository")
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
     * @ORM\Column(name="name", type="string", length=50, nullable=true)
     */
    private $name;
    /**
     * @var string $shortDescription
     *
     * @ORM\Column(name="short_description", type="text", nullable=true)
     */
    private $shortDescription;

    /**
     * @var string $fullDesctiption
     *
     * @ORM\Column(name="full_desctiption", type="text", nullable=true)
     */
    private $fullDesctiption;

    /**
     * @var float $price
     *
     * @ORM\Column(name="price", type="decimal", nullable=false)
     */
    private $price;

    /**
     * @var integer $image_id
     *
     * @ORM\Column(name="image_id", type="integer", nullable=true)
     */
    private $image_id;

    /**
     * @var Gallery
     *
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Gallery")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="image_id", referencedColumnName="id")
     * })
     */
    private $imagePath;

    /**
     * @var boolean $active
     *
     * @ORM\Column(name="active", type="boolean", nullable=true)
     */
    private $active;

    /**
     * @var integer
     *
     * @ORM\Column(name="amount", type="integer", nullable=true)
     */
    private $amount;

    /**
     * @var string $article
     *
     * @ORM\Column(name="article", type="string", length=50, nullable=false, unique=true)
     */
    private $article;

    /**
     * @var \DateTime $last_update
     *
     * @ORM\Column(name="last_update", type="datetime", nullable=false)
     */
    private $last_update;

    /**
     * @var string $review
     *
     * @ORM\Column(name="review", type="text", nullable=true)
     */
    private $review;

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
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Characteristic", mappedBy="good", cascade={"persist", "remove" }, orphanRemoval=true)
     */
    protected $characteristic;

    /**
     * @var Gallery
     *
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Gallery")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="youtube_id", referencedColumnName="id")
     * })
     */
    private $youtube;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->videos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->characteristic = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set image_id
     *
     * @param integer $imageId
     * @return Goods
     */
    public function setImageId($imageId)
    {
        $this->image_id = $imageId;
    
        return $this;
    }

    /**
     * Get image_id
     *
     * @return integer 
     */
    public function getImageId()
    {
        return $this->image_id;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return Goods
     */
    public function setActive($active)
    {
        $this->active = $active;
    
        return $this;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set amount
     *
     * @param integer $amount
     * @return Goods
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
     * Set imagePath
     *
     * @param \Application\Sonata\MediaBundle\Entity\Gallery $imagePath
     * @return Goods
     */
    public function setImagePath(\Application\Sonata\MediaBundle\Entity\Gallery $imagePath = null)
    {
        $this->imagePath = $imagePath;
    
        return $this;
    }

    /**
     * Get imagePath
     *
     * @return \Application\Sonata\MediaBundle\Entity\Gallery 
     */
    public function getImagePath()
    {
        return $this->imagePath;
    }

    /**
     * Set catalog
     *
     * @param \Nurix\CatalogBundle\Entity\Catalog $catalog
     * @return Goods
     */
    public function setCatalog(\Nurix\CatalogBundle\Entity\Catalog $catalog = null)
    {
        $this->catalog = $catalog;
    
        return $this;
    }

    /**
     * Get catalog
     *
     * @return \Nurix\CatalogBundle\Entity\Catalog 
     */
    public function getCatalog()
    {
        return $this->catalog;
    }

    /**
     * Set youtube
     *
     * @param \Application\Sonata\MediaBundle\Entity\Gallery $youtube
     * @return Goods
     */
    public function setYoutube(\Application\Sonata\MediaBundle\Entity\Gallery $youtube = null)
    {
        $this->youtube = $youtube;

        return $this;
    }

    /**
     * Get youtube
     *
     * @return \Application\Sonata\MediaBundle\Entity\Gallery 
     */
    public function getYoutube()
    {
        return $this->youtube;
    }

    /**
     * Add characteristic
     *
     * @param \Nurix\CatalogBundle\Entity\Characteristic $characteristic
     * @return Goods
     */
    public function addCharacteristic(\Nurix\CatalogBundle\Entity\Characteristic $characteristic)
    {
        $this->characteristic[] = $characteristic;
    
        return $this;
    }

    /**
     * Remove characteristic
     *
     * @param \Nurix\CatalogBundle\Entity\Characteristic $characteristic
     */
    public function removeCharacteristic(\Nurix\CatalogBundle\Entity\Characteristic $characteristic)
    {
        $this->characteristic->removeElement($characteristic);
    }

    /**
     * Get characteristic
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCharacteristic()
    {
        return $this->characteristic;
    }

    /**
     * Set article
     *
     * @param string $article
     * @return Goods
     */
    public function setArticle($article)
    {
        $this->article = $article;
    
        return $this;
    }

    /**
     * Get article
     *
     * @return string 
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * Set last_update
     *
     * @param \DateTime $lastUpdate
     * @return Goods
     */
    public function setLastUpdate($lastUpdate)
    {
        $this->last_update = $lastUpdate;
    
        return $this;
    }

    /**
     * Get last_update
     *
     * @return \DateTime 
     */
    public function getLastUpdate()
    {
        return $this->last_update;
    }

    /**
     * Set review
     *
     * @param string $review
     * @return Goods
     */
    public function setReview($review)
    {
        $this->review = $review;
    
        return $this;
    }

    /**
     * Get review
     *
     * @return string 
     */
    public function getReview()
    {
        return $this->review;
    }
}