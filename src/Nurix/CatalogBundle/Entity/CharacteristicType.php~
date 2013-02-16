<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Admin
 * Date: 02.02.13
 * Time: 13:55
 * To change this template use File | Settings | File Templates.
 */
namespace Nurix\CatalogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Nurix\CatalogBundle\Entity\Catalog
 *
 * @ORM\Table(name="CharacteristicType")
 * @ORM\Entity
  */

class CharacteristicType
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
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=100, nullable=false)
     */
    protected $name;

    /**
     * @var string $list
     *
     * @ORM\Column(name="list", type="string", length=100, nullable=true)
     */
    protected $list;

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
}