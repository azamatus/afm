<?php

namespace Nurix\PageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pages
 */
class Pages
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $pages;


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
     * Set pages
     *
     * @param string $pages
     * @return Pages
     */
    public function setPages($pages)
    {
        $this->pages = $pages;
    
        return $this;
    }

    /**
     * Get pages
     *
     * @return string 
     */
    public function getPages()
    {
        return $this->pages;
    }
}
