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

    public function __construct(MediaManagerInterface $mediaManager,GalleryManagerInterface $galleryManager,EntityManager $em)
    {

        $this->mediaManager = $mediaManager;
        $this->galleryManager = $galleryManager;
        $this->em = $em;
    }

    public function saveImages($query, $context, $providerName,$default_format, $count)
    {
        $gallery = $this->galleryManager->create();
        $gallery->setContext($context);
        $gallery->setName($query);
        $gallery->setEnabled(true);
        $gallery->setDefaultFormat($default_format);
        $this->galleryManager->update($gallery);



        if (!$query) throw new InvalidArgumentException("no query");

            $i = 1;

            $url = 'http://www.google.com/search?q=' . urlencode($query) . '&oe=utf-8&rls={moz:distributionID}:{moz:locale}:{moz:official}&client=firefox-a&um=1&ie=UTF-8&tbm=isch&source=og&tbs=isz:m&sa=N&hl=en&tab=wi&sa=N&start=0&ndsp=20';


        $json = file_get_contents('http://ajax.googleapis.com/ajax/services/search/images?v=1.0&q='.urlencode($query));

        $data = json_decode($json);

//        foreach ($data->responseData->results as $result) {
//            $m[] = array('url' => $result->url, 'alt' => $result->title);
//        }

//        print_r($results);

//            $html = HtmlDomParser::file_get_html($url);

//            echo $html;
//        die;
//             imgurl\x3dhttp://mirsladosti.ru/wp-content/uploads/2008/09/19.gif\x26
//            $m = $html->find('table.images_table a > img');
        if ($data && $data->responseData)
            foreach ($data->responseData->results as $_m) {
                //парсит только 2 картинки
                if ($i == $count)
                    return;
                $buffer = file_get_contents($_m->url);
                if ($buffer && !empty($buffer)) {

                    $d = "uploads/media/{$i}." . substr($_m->url, -3, 3);

                    file_put_contents($d, $buffer);

                    $file = new File($d);
                    $media = new Media();
                    $media->setBinaryContent($file);
                    $media->setName($_m->title);
                    $media->setContext($context); // video related to the user
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
            }
        else
        {
            $this->galleryManager->delete($gallery);
            return null;
        }
        return $gallery;
    }
    function get_url_contents($url) {
        $crl = curl_init();

        curl_setopt($crl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)');
        curl_setopt($crl, CURLOPT_URL, $url);
        curl_setopt($crl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($crl, CURLOPT_CONNECTTIMEOUT, 5);

        $ret = curl_exec($crl);
        curl_close($crl);
        return $ret;
    }
} 