<?php

namespace Nurix\PageBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Prezent\Doctrine\Translatable\Annotation as Prezent;
use Prezent\Doctrine\Translatable\Entity\AbstractTranslatable;
use Nurix\PageBundle\Entity\PagesTranslation;
use Strokit\CoreBundle\DBAL\BaseTranslatable;

/**
 * Pages
 *
 * @ORM\Table(value="pages")
 * @ORM\Entity
 */
class Pages extends BaseTranslatable
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=200)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="position", type="pagetype_enum", nullable=false)
     */
    private $position;

    /**
     * @Prezent\Translations(targetEntity="Nurix\PageBundle\Entity\PagesTranslation")
     */
    protected $translations;

    public function __construct()
    {
        $this->translations = new ArrayCollection();
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
     * Set url
     *
     * @param string $url
     * @return Pages
     */
    public function setUrl($url)
    {
        $this->url = $url;
    
        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    // Proxy getters and setters

    public function getTitle()
    {
        return $this->getFieldTranslation('title');
    }

    public function setTitle($title)
    {
        $this->translate()->setTitle($title);
        return $this;
    }

    public function getContent()
    {
        return $this->translate()->getContent();
    }

    public function setContent($content)
    {
        $this->translate()->setContent($content);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCurrentLocale()
    {
        return $this->currentLocale;
    }

    /**
     * @param mixed $currentLocale
     */
    public function setCurrentLocale($currentLocale)
    {
        $this->currentLocale = $currentLocale;
    }

    /**
     * @return string
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param string $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }
}
