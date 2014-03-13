<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 14.03.14
 * Time: 1:16
 */

namespace Nurix\PageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Prezent\Doctrine\Translatable\Annotation as Prezent;
use Prezent\Doctrine\Translatable\Entity\AbstractTranslation;

/**
 * @ORM\Table(value="pages_translations")
 * @ORM\Entity
 */
class PagesTranslation extends AbstractTranslation
{
    /**
     * @Prezent\Translatable(targetEntity="Nurix\PageBundle\Entity\Pages")
     */
    protected $translatable;

    /**
     * @ORM\Column(type="string")
     */
    private $title = "";

    /**
     * @ORM\Column(type="text")
     */
    private $content = "";

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    // Getters and setters
}