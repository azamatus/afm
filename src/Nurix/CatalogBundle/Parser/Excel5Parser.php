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

class Excel5Parser
{
    private $xlsx_service;
    /* @var Registry $doctrine_service */
    private $doctrine_service;


    public function __construct($doctrine_service, $xlsx_service)
    {
        $this->xlsx_service = $xlsx_service;
        $this->doctrine_service = $doctrine_service;
    }

    public function parseExcel(File $file)//бул парсер
    {
        $excelObj = $this->xlsx_service->load($file);
        $sheetData = $excelObj->getActiveSheet()->toArray(null, true, false, true);
        $updated=0;
        $index = 0;

        $entityManager = $this->doctrine_service->getManager();
		/** @var $goodsRepository GoodsRepository */
		$goodsRepository = $entityManager->getRepository('CatalogBundle:Goods');
        $goodsRepository->deactivateAmountAll();

        foreach ($sheetData as $sheetRow) {
            $index++;
            if ($index == 1) continue;
            $article = $sheetRow['B'] ? $sheetRow['B'] : null;
            $count = $sheetRow['D'] ? $sheetRow['D'] : null;

                /* @var Goods $good */
                $good = $goodsRepository->findOneByArticle($article);
                if ($good) {
                    if($good->getAmount()==0)
                        $updated++;
                    $good->setAmount($count + $good->getAmount());
                    $entityManager->flush();
                }
        }
        return array('updated'=>$updated);
    }
}