<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Admin
 * Date: 17.02.13
 * Time: 12:50
 * To change this template use File | Settings | File Templates.
 */
namespace Application\Sonata\MediaBundle\Twig;

use Application\Sonata\MediaBundle\Entity\Gallery;
use Sonata\MediaBundle\Model\MediaInterface;
use Sonata\MediaBundle\Twig\Extension\MediaExtension;

class ThumbnailExtension extends MediaExtension
{

    public function getFilters()
    {
        return array(
            'galleryThumb' => new \Twig_Filter_Method($this, 'galleryThumbnailFilter',array(
                'is_safe' => array('html')
            )),
            'thumb' => new \Twig_Filter_Method($this, 'thumbnailFilter',array(
                'is_safe' => array('html')
            )),
        );
    }


    /**
     * @param Gallery $gallery
     * @param string $noImagePath
     * @param string $format
     * @param array  $options
     * @return mixed|string
     */
    public function galleryThumbnailFilter($gallery,$noImagePath,$format='big',$options = array())
    {
        if ($gallery&&$gallery->getGalleryHasMedias()&&count($gallery->getGalleryHasMedias())>0)
        {
            $medias = $gallery->getGalleryHasMedias();
            if ($medias[0]->getMedia())
                return $this->thumbnail($medias[0],$format,$options);
        }

        $provider = $this->getMediaService()
            ->getProvider('sonata.media.provider.image');
        $options = array_merge($options,array('src'=>$noImagePath));
        return $this->render($provider->getTemplate('helper_thumbnail'), array(
            'options'  => $options,
        ));
    }

    public function thumbnailFilter( $media,$noImagePath,$format='big',$options = array())
    {
        $result = $this->path($media,$format,$options);
        if (!$result)
        {
            $result=$noImagePath;

            $provider = $this->getMediaService()
                ->getProvider('sonata.media.provider.image');
            $options = array_merge($options,array('src'=>$result));
            return $this->render($provider->getTemplate('helper_thumbnail'), array(
                'options'  => $options,
            ));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'thumb_extension';
    }
}