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

    public function __construct($doctrine_service, $xlsx_service)
    {
        $this->xlsx_service = $xlsx_service;
        $this->doctrine_service = $doctrine_service;
    }

    public function parseExcel(File $file)
    {

        $exelObj = $this->xlsx_service->load($file);
        $sheetData = $exelObj->getActiveSheet()->toArray(null, true, false, true);
        $index = 0;

        $entityManager = $this->doctrine_service->getManager();

		/** @var $goodsRepository GoodsRepository */
		$goodsRepository = $entityManager->getRepository('CatalogBundle:Goods');
		$goodsRepository->deactivateAll();
        $catalogs = $entityManager->getRepository('CatalogBundle:Catalog')->findAll();
        $goods_alias = array();

        $added_goods = 0;
        $updated_goods = 0;

        foreach ($catalogs as $catalog) {
            $goods_alias[$catalog->getId()] = explode(',', $catalog->getGoodsAlias());
        }

        foreach ($sheetData as $sheetRow) {

            $index++;
            if ($index == 1) continue;
            $article = $sheetRow['A'] ? $sheetRow['A'] : null;
            $name = $sheetRow['B'] ? $sheetRow['B'] : null;
            $last_update = new DateTime(date('Y-m-d', mktime(0,0,0,1,$sheetRow['I']-1,1900)));
            $price = (float)$sheetRow['L'];
            $urlYandex = $sheetRow['Q'];
            $subcatalog = null;
            if (!empty($article)) {

                foreach ($goods_alias as $catalog_id => $aliases) {
                    foreach ($aliases as $alias) {
                        if (!empty($alias))
                            if (strpos($name, $alias) !== false) {
                                $subcatalog = $entityManager->getRepository('CatalogBundle:Catalog')->find($catalog_id);
                                break;
                            }
                    }
                }

                /* @var Goods $good */
                $good = $goodsRepository->findOneByArticle($article);

                if ($good) {
                    $updated_goods++;
                    $good->setLastUpdate($last_update);
                    $good->setPrice($price);
                    $good->setActive(true);


                    if ($good->getCatalog()==null)
                    $good->setCatalog($subcatalog);

                    $entityManager->flush();


                } else {
                    $added_goods++;
                    $good = new Goods();
                    $good->setArticle($article);
                    $good->setName($name);
                    $good->setActive(true);
                    $good->setLastUpdate($last_update);
                    $good->setPrice($price);
                    $good->setCatalog($subcatalog);

                    $entityManager->persist($good);
                    $entityManager->flush();


                }

                if ($urlYandex) {
                    $characters = $entityManager->getRepository('CatalogBundle:Characteristic')->findByGoodId($good->getId());
                    if (!$characters) {
                        $this->parseYandex($urlYandex, $good->getId());
                    }
                }
            }
        }
        return array('added' => $added_goods, 'updated' => $updated_goods);
    }

    public function parseYandex($url, $goodid)
    {
            $yandex_info = $this->isValidYandexUrl($url);
            if($yandex_info['valid']){
                $url = $yandex_info['url'];
                $good = $this->doctrine_service->getRepository('CatalogBundle:Goods')->find($goodid);
                if (!$good) {
                    Throw new EntityNotFoundException("Товар не найдена");
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