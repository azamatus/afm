<?php

namespace Nurix\CatalogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CharacteristicSection
 *
 * @ORM\Table(name="characteristic_section")
 * @ORM\Entity
 */
class CharacteristicSection
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
     * @ORM\Column(name="SectionValue", type="string", length=100, nullable=true)
     */
    private $sectionvalue;



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
     * Set sectionvalue
     *
     * @param string $sectionvalue
     * @return CharacteristicSection
     */
    public function setSectionvalue($sectionvalue)
    {
        $this->sectionvalue = $sectionvalue;
    
        return $this;
    }

    /**
     * Get sectionvalue
     *
     * @return string 
     */
    public function getSectionvalue()
    {
        return $this->sectionvalue;
    }

    public function __toString()
    {
        return $this->getSectionvalue() ?: '';
    }
}