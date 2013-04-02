<?php

namespace Nurix\CatalogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CharacteristicType
 *
 * @ORM\Table(name="characteristic_type")
 * @ORM\Entity
 */
class CharacteristicType
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
     * @ORM\Column(name="name", type="string", length=100, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="list", type="string", length=100, nullable=true)
     */
    private $list;

    /**
     * @var \Nurix\CatalogBundle\Entity\CharacteristicSection
     *
     * @ORM\ManyToOne(targetEntity="Nurix\CatalogBundle\Entity\CharacteristicSection")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="section", referencedColumnName="id")
     * })
     */
    private $section;



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
     * @return CharacteristicType
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
     * Set list
     *
     * @param string $list
     * @return CharacteristicType
     */
    public function setList($list)
    {
        $this->list = $list;
    
        return $this;
    }

    /**
     * Get list
     *
     * @return string 
     */
    public function getList()
    {
        return $this->list;
    }

    /**
     * Set section
     *
     * @param \Nurix\CatalogBundle\Entity\CharacteristicSection $section
     * @return CharacteristicType
     */
    public function setSection(\Nurix\CatalogBundle\Entity\CharacteristicSection $section = null)
    {
        $this->section = $section;
    
        return $this;
    }

    /**
     * Get section
     *
     * @return \Nurix\CatalogBundle\Entity\CharacteristicSection 
     */
    public function getSection()
    {
        return $this->section;
    }
}