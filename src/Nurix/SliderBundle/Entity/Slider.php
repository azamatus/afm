<?php

namespace Nurix\SliderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Slider
 */
class Slider
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $slider;


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
     * Set slider
     *
     * @param string $slider
     * @return Slider
     */
    public function setSlider($slider)
    {
        $this->slider = $slider;
    
        return $this;
    }

    /**
     * Get slider
     *
     * @return string 
     */
    public function getSlider()
    {
        return $this->slider;
    }
}
