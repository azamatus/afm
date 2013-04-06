<?php

/**
 * This file is part of the <name> project.
 *
 * (c) <yourname> <youremail>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Sonata\NewsBundle\Entity;

use Sonata\NewsBundle\Entity\BasePost as BasePost;

/**
 * This file has been generated by the Sonata EasyExtends bundle ( http://sonata-project.org/bundles/easy-extends )
 *
 * References :
 *   working with object : http://www.doctrine-project.org/projects/orm/2.0/docs/reference/working-with-objects/en
 *
 * @author <yourname> <youremail>
 */
class Post extends BasePost
{
    /**
     * @var integer $id
     */
    protected $id;

    /**
     * @var boolean $local
     */
    protected $local;

    /**
     * Get id
     *
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set local
     *
     * @param boolean $local
     */
    public function setLocal($local){
        $this->local = $local;
    }

    /**
     * Get local
     *
     * @return boolean $local
     */
    public function getLocal(){
        return $this->local;
    }

    /**
     * Set image
     *
     * @param string $image
     */
    public function setImage($image){
        $this->image = $image;
    }

    /**
     * Get image
     *
     * @return string $image
     */
    public function getImage(){
        return $this->image;
    }
}