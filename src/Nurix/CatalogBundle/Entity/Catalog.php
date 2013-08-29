<?php

namespace Nurix\CatalogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Nurix\CatalogBundle\Entity\Catalog
 *
 * @ORM\Table(name="catalog")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Nurix\CatalogBundle\Entity\CatalogRepository")
 */
class Catalog
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
     * @var string $cname
     *
     * @ORM\Column(name="cname", type="string", length=100, nullable=false)
     */
    private $cname;

    /**
     * @var boolean $active
     *
     * @ORM\Column(name="active", type="boolean", nullable=false)
     */
    private $active;

    /**
     * @var string $goods_alias
     *
     * @ORM\Column(name="goods_alias", type="string", length=255, nullable=true);
     */
    private $goods_alias;

    /**
     * @var integer $parent_id
     *
     * @ORM\Column(name="parent_id", type="integer", nullable=true)
     */
    private $parent_id;

    /**
     * @var Catalog
     *
     * @ORM\ManyToOne(targetEntity="Catalog")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     * })
     */
    private $parent;


    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Catalog", mappedBy="parent", cascade={"persist", "remove" }, orphanRemoval=true)
     */
    protected $children;



    public function getChildren(){

        return $this->children;
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
     * Set cname
     *
     * @param string $cname
     * @return Catalog
     */
    public function setCname($cname)
    {
        $this->cname = $cname;
    
        return $this;
    }

    /**
     * Get cname
     *
     * @return string 
     */
    public function getCname()
    {
        return $this->cname;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return Catalog
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
     * Set parent
     *
     * @param Nurix\CatalogBundle\Entity\Catalog $parent
     * @return Catalog
     */
    public function setParent(\Nurix\CatalogBundle\Entity\Catalog $parent = null)
    {
        $this->parent = $parent;
    
        return $this;
    }

    /**
     * Get parent
     *
     * @return Nurix\CatalogBundle\Entity\Catalog
     */
    public function getParent()
    {
        return $this->parent;
    }

    public function __toString()
    {
        if ($this->getParent()!=null)
            return $this->getParent().' / '.$this->cname;
        else
            return $this->cname.'';
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add children
     *
     * @param \Nurix\CatalogBundle\Entity\Catalog $children
     * @return Catalog
     */
    public function addChildren(\Nurix\CatalogBundle\Entity\Catalog $children)
    {
        $this->children[] = $children;
    
        return $this;
    }

    /**
     * Remove children
     *
     * @param \Nurix\CatalogBundle\Entity\Catalog $children
     */
    public function removeChildren(\Nurix\CatalogBundle\Entity\Catalog $children)
    {
        $this->children->removeElement($children);
    }

    /**
     * Set parent_id
     *
     * @param integer $parentId
     * @return Catalog
     */
    public function setParentId($parentId)
    {
        $this->parent_id = $parentId;
    
        return $this;
    }

    /**
     * Get parent_id
     *
     * @return integer 
     */
    public function getParentId()
    {
        return $this->parent_id;
    }

    /**
     * Set goods_alias
     *
     * @param string $goodsAlias
     * @return Catalog
     */
    public function setGoodsAlias($goodsAlias)
    {
        $this->goods_alias = $goodsAlias;
    
        return $this;
    }

    /**
     * Get goods_alias
     *
     * @return string 
     */
    public function getGoodsAlias()
    {
        return $this->goods_alias;
    }
}