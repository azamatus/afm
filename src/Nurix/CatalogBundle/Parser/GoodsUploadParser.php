<?php
/**
 * Created by PhpStorm.
 * User: Mederbek
 * Date: 2/19/14
 * Time: 9:30 PM
 */

namespace Nurix\CatalogBundle\Parser;

use DateTime;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Nurix\CatalogBundle\Entity\Goods;
use Nurix\CatalogBundle\Entity\GoodsRepository;
use Symfony\Component\HttpFoundation\File\File;
use Sunra\PhpSimple\HtmlDomParser;

class GoodsUploadParser
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
        $excelObj = $this->xlsx_service->load($file);
        $sheetData = $excelObj->getActiveSheet()->toArray(null, true, false, true);
        $last_update = new DateTime(date('Y-m-d', mktime()));

        $index = 0;
        $updated_goods = 0;
        $added_goods = 0;
        $category = null;
        $subcatalog = null;

        $entityManager = $this->doctrine_service->getManager();

        /** @var $goodsRepository GoodsRepository */
        $goodsRepository = $entityManager->getRepository('CatalogBundle:Goods');
        $catalogs = $entityManager->getRepository('CatalogBundle:Catalog')->findAll();
        $goods_alias = array();

        foreach ($catalogs as $catalog) {
            $goods_alias[$catalog->getId()] = explode(',', $catalog->getGoodsAlias());
        }

        foreach ($sheetData as $sheetRow) {
            $index++;
            if ($index < 6) continue;

            $article = $sheetRow['A'] ? $sheetRow['A'] : null;
            $price = (float)$sheetRow['B'];

            if ($article[0] == '_') {
                $category = trim($article, "_");
                continue;
            }

            if (!empty($article)) {

                foreach ($goods_alias as $catalog_id => $aliases) {
                    foreach ($aliases as $alias) {
                        if (!empty($alias))
                            if (strpos($category, $alias) !== false) {
                                $subcatalog = $entityManager->getRepository('CatalogBundle:Catalog')->find($catalog_id);
                                break;
                            }
                    }
                }

                /* @var Goods $good */
                $good = $goodsRepository->findOneByArticle($article);

                if ($good) {
                    $updated_goods++;

                    $good->setPrice($price);
                    $good->setLastUpdate($last_update);

                    if ($good->getCatalog()==null)
                        $good->setCatalog($subcatalog);

                    $entityManager->flush();

                } else {
                    $added_goods++;

                    $good = new Goods();
                    $good->setName($article);
                    $good->setArticle($article);
                    $good->setPrice($price);
                    $good->setLastUpdate($last_update);
                    $good->setCatalog($subcatalog);

                    $entityManager->persist($good);
                    $entityManager->flush();
                }
            }
        }
        return array('added' => $added_goods, 'updated' => $updated_goods);
    }
}