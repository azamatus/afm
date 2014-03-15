<?php

namespace Nurix\SliderBundle\Entity;

use Application\Sonata\MediaBundle\Entity\Media;
use Doctrine\ORM\Mapping as ORM;

/**
 * Slider
 *
 * @ORM\Table(name="slider")
 * @ORM\Entity(repositoryClass="Nurix\SliderBundle\Entity\SliderRepository")
     */
class Slider
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean", nullable=false)
     */
    private $active;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=120, nullable=false)
     */
    private $title;

    /**
     * @var Media
     *
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="image_id", referencedColumnName="id")
     * })
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", nullable=true)
     */
    private $url;


    /**
     * @var integer
     *
     * @ORM\Column(name="slider_order", type="integer", nullable=false)
     */
    private $sliderOrder;



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
     * Set active
     *
     * @param boolean $active
     * @return Slider
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
     * Set title
     *
     * @param string $title
     * @return Slider
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Slider
     */
    public function setImage($content)
    {
        $this->image = $content;
    
        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set sliderOrder
     *
     * @param integer $sliderOrder
     * @return Slider
     */
    public function setSliderOrder($sliderOrder)
    {
        $this->sliderOrder = $sliderOrder;
    
        return $this;
    }

    /**
     * Get sliderOrder
     *
     * @return integer 
     */
    public function getSliderOrder()
    {
        return $this->sliderOrder;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }
}