<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 10.01.14
 * Time: 18:47
 */

namespace Nurix\CatalogBundle\Parser;


use Application\Sonata\MediaBundle\Entity\GalleryHasMedia;
use Application\Sonata\MediaBundle\Entity\Media;
use Doctrine\Common\Util\Debug;
use Doctrine\ORM\EntityManager;
use Sonata\MediaBundle\Model\GalleryManagerInterface;
use Sonata\MediaBundle\Model\MediaManagerInterface;
use Sunra\PHPSimple\HtmlDomParser;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Exception\InvalidArgumentException;

class GoogleParser
{

    /**
     * @var \Sonata\MediaBundle\Model\MediaManagerInterface
     */
    private $mediaManager;
    /**
     * @var \Sonata\MediaBundle\Model\GalleryManagerInterface
     */
    private $galleryManager;
    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(MediaManagerInterface $mediaManager, GalleryManagerInterface $galleryManager, EntityManager $em)
    {

        $this->mediaManager = $mediaManager;
        $this->galleryManager = $galleryManager;
        $this->em = $em;
    }

    public function saveImages($query, $context, $providerName, $default_format, $count)
    {
        $gallery = $this->galleryManager->create();
        $gallery->setContext($context);
        $gallery->setName($query);
        $gallery->setEnabled(true);
        $gallery->setDefaultFormat($default_format);
        $this->galleryManager->update($gallery);

        $i = 0;
        $json = file_get_contents('http://ajax.googleapis.com/ajax/services/search/images?v=1.0&q=' . urlencode($query));

        $data = json_decode($json);
        if ($data->responseStatus == 200)
            foreach ($data->responseData->results as $_m) {

                if ($_m->width>2000&&$_m->height>2000)
                    continue;
                if ($_m->width<210||$_m->height<210)
                    continue;
                $buffer = file_get_contents($_m->url);
                if ($buffer && !empty($buffer)) {

                    $d = "uploads/media/{$i}." . substr($_m->url, -3, 3);

                    if (file_exists($d))
                    {
                        unlink($d);
                    }

                    file_put_contents($d, $buffer);

                    $file = new File($d);
                    $media = new Media();
                    $media->setBinaryContent($file);
                    $media->setName($_m->contentNoFormatting);
                    $media->setContext($context);
                    $media->setProviderName($providerName);

                    $this->mediaManager->save($media);

                    unlink($d);

                    $galleryHasMedia = new GalleryHasMedia();
                    $galleryHasMedia->setMedia($media);
                    $galleryHasMedia->setGallery($gallery);
                    $galleryHasMedia->setPosition($i);
                    $galleryHasMedia->setEnabled(true);

                    $this->em->persist($galleryHasMedia);

                    $gallery->addGalleryHasMedias($galleryHasMedia);

                    $this->galleryManager->update($gallery);

                    $i++;
                }
                if ($i == $count)
                    break;
            }
        if ($i == 0) {
            $this->galleryManager->delete($gallery);
            return null;
        }
        return $gallery;
    }
} 