<?php
/**
 * Created by JetBrains PhpStorm.
 * User: root
 * Date: 4/28/13
 * Time: 11:14 PM
 * To change this template use File | Settings | File Templates.
 */
namespace Nurix\CatalogBundle\Parser;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\Common\Util\Debug;
use Nurix\CatalogBundle\Entity\Goods;
use Doctrine\ORM\EntityNotFoundException;
use Nurix\CatalogBundle\Entity\Characteristic;
use Nurix\CatalogBundle\Entity\CharacteristicSection;
use Nurix\CatalogBundle\Entity\CharacteristicType;
use Nurix\CatalogBundle\Entity\GoodsRepository;
use Symfony\Component\HttpFoundation\File\File;
use Sunra\PhpSimple\HtmlDomParser;

class Parser
{
    private $xlsx_service;
    /* @var Registry $doctrine_service */
    private $doctrine_service;
    private $googleParser;
    private $imageCount;

    public function __construct($doctrine_service, $xlsx_service,$googleParser,$imageCount)
    {
        $this->xlsx_service = $xlsx_service;
        $this->doctrine_service = $doctrine_service;
        $this->googleParser = $googleParser;
        $this->imageCount = $imageCount;
    }

    public function parseYandex($url, $goodid)
    {
            $yandex_info = $this->isValidYandexUrl($url);
            if($yandex_info['valid']){
                $url = $yandex_info['url'];
                $good = $this->doctrine_service->getRepository('CatalogBundle:Goods')->find($goodid);
                if (!$good) {
                    Throw new EntityNotFoundException("Товар не найден");
                }
                $html = HtmlDomParser::file_get_html($url);
                foreach ($html->find('table.l-page_layout_72-20 .b-properties') as $table) {
                    $sid = 0;
                    foreach ($table->find('tr') as $tr) {
                        $section_type = null;
                        $html_span = HtmlDomParser::str_get_html($tr);
                        $section_type = $html_span->find('.b-properties__title', -1);

                        if ($section_type != null) {
                            $section_type = $section_type->plaintext;
                            $repository = $this->doctrine_service->getRepository('CatalogBundle:CharacteristicSection');
                            $characteristic_section = $repository->findOneBySectionvalue($section_type);
                            if ($characteristic_section) {
                                $sid = $characteristic_section;
                            } else {
                                $section = new CharacteristicSection();
                                $section->setSectionvalue($section_type);

                                $em = $this->doctrine_service->getManager();
                                $em->persist($section);
                                $em->flush();
                                $sid = $section;
                            }
                        } else {
                            $char_type = $html_span->find('.b-properties__label-title', -1)->plaintext;

                            $char = $html_span->find('.b-properties__value', -1)->plaintext;
                            $repository = $this->doctrine_service->getRepository('CatalogBundle:CharacteristicType');
                            $type = $repository->findOneByName($char_type);

                            if ($type) {
                                $tid = $type;

                            } else {
                                $characteristic_type = new CharacteristicType();
                                $characteristic_type->setName($char_type);
                                $characteristic_type->setSection($sid);

                                $em = $this->doctrine_service->getManager();
                                $em->persist($characteristic_type);
                                $em->flush();
                                $tid = $characteristic_type;
                            }
                            $characteristic = new Characteristic();
                            $characteristic->setValue($char);
                            $characteristic->setCTypeId($tid);
                            $characteristic->setGood($good);

                            $em = $this->doctrine_service->getManager();
                            $em->persist($characteristic);
                            $em->flush();

                        }
                    }

                }
            }
    }

    public function isValidYandexUrl($url){
        $pattern = '/^http:\/\/market\.yandex.ru\/model(-spec)?\.xml\?modelid=([0-9]+)&hid=([0-9]+)$/';
        $valid = false;
        if(preg_match($pattern,$url,$matches)){
            $url = 'http://market.yandex.ru/model-spec.xml?modelid='. $matches[2].'&hid='.$matches[3];
            $valid= true;
        }
        elseif($url==null)
            $valid=true;
        return array('valid'=>$valid,'url'=>$url);

    }
}