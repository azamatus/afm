<?php
/**
 * Created by JetBrains PhpStorm.
 * User: root
 * Date: 4/14/13
 * Time: 7:07 PM
 * To change this template use File | Settings | File Templates.
 */
namespace Nurix\CatalogBundle\Controller;

use DateTime;
use Nurix\CatalogBundle\Entity\Goods;
use Nurix\CatalogBundle\Form\Type\ExcelType;
use Sonata\AdminBundle\Controller\CoreController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityNotFoundException;
use Nurix\CatalogBundle\Entity\Characteristic;
use Nurix\CatalogBundle\Entity\CharacteristicSection;
use Nurix\CatalogBundle\Entity\CharacteristicType;
use Sunra\PhpSimple\HtmlDomParser;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends CoreController
{

    public function excelAction(Request $request)
    {

        $form = $this->createForm(new ExcelType());

        if ($request->isMethod('POST')) {
            $form->bind($request);

            if ($form->isValid()) {
                $file = $form['file']->getData();
                $extension = null;
                $original_file = $file->getClientOriginalName();

                if (stripos($original_file, 'xlsx')) {
                    $dir = $this->get('kernel')->getRootDir() . '/../web/price';

                    $filename = sha1(uniqid(mt_rand(), true));
                    $filename = $filename . '.' . $extension;
                    $file->move($dir, $filename);
                    $excel_file = new File($dir . '/' . $filename);

                    $info = $this->parseExcel($excel_file);
                    $added_message = 'Добавлено: ' .$info['added'];
                    $updated_message = 'Обновлено: ' .$info['updated'];
                    $this->get('session')->getFlashBag()->add('notice',$added_message );
                    $this->get('session')->getFlashBag()->add('notice',$updated_message );
                } else {
                    $this->get('session')->getFlashBag()->add('notice', 'Неверный формат');
                }

                $this->redirect($this->generateUrl('nurix_admin_parse_excel'));

            }
        }
        return $this->render('CatalogBundle:Admin:excel.html.twig',
            array('form' => $form->createView(),
                'base_template' => $this->getBaseTemplate(),
                'block' => $this->container->getParameter('sonata.admin.configuration.dashboard_blocks')
            ));
    }

    public function parseExcel(File $file) //TODO: вынести в отдельный слой
    {

        $exelObj = $this->get('xls.load_xls2007')->load($file);
        $sheetData = $exelObj->getActiveSheet()->toArray(null, true, true, true);
        $index = 0;

        $entityManager = $this->getDoctrine()->getManager();

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
            $last_update = new DateTime(date('Y-m-d', strtotime($sheetRow['I'])));
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

                $good = $entityManager->getRepository('CatalogBundle:Goods')->findOneByArticle($article);
                if ($good) {
                    $updated_goods++;
                    $good->setName($name);
                    $good->setLastUpdate($last_update);
                    $good->setPrice($price);
                    $good->setCatalog($subcatalog);
                    $good->setActive(true);
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

                if ($urlYandex){
                    $characters =$entityManager->getRepository('CatalogBundle:Characteristic')->findByGoodId($good->getId());
                    if(!$characters){
                        $this->parseYandex($urlYandex, $good->getId());
                    }
                }
            }
        }
        return array('added'=>$added_goods,'updated'=>$updated_goods);
    }

    public function parseYandex($url, $goodid) //TODO: вынести в отдельный слой
    {
        $good = $this->getDoctrine()->getRepository('CatalogBundle:Goods')->find($goodid);
        if (!$good) {
            Throw new EntityNotFoundException("good not found");
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
                    $repository = $this->getDoctrine()->getRepository('CatalogBundle:CharacteristicSection');
                    $characteristic_section = $repository->findOneBySectionvalue($section_type);
                    if ($characteristic_section) {
                        $sid = $characteristic_section;
                    } else {
                        $section = new CharacteristicSection();
                        $section->setSectionvalue($section_type);

                        $em = $this->getDoctrine()->getManager();
                        $em->persist($section);
                        $em->flush();
                        $sid = $section;
                    }
                } else {
                    $char_type = $html_span->find('.b-properties__label-title', -1)->plaintext;

                    $char = $html_span->find('.b-properties__value', -1)->plaintext;
                    $repository = $this->getDoctrine()->getRepository('CatalogBundle:CharacteristicType');
                    $type = $repository->findOneByName($char_type);

                    if ($type) {
                        $tid = $type;

                    } else {
                        $characteristic_type = new CharacteristicType();
                        $characteristic_type->setName($char_type);
                        $characteristic_type->setSection($sid);

                        $em = $this->getDoctrine()->getManager();
                        $em->persist($characteristic_type);
                        $em->flush();
                        $tid = $characteristic_type;
                    }
                    $characteristic = new Characteristic();
                    $characteristic->setValue($char);
                    $characteristic->setCTypeId($tid);
                    $characteristic->setGood($good);

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($characteristic);
                    $em->flush();

                }
            }

        }
        //return new Response('Характеристики для '.$good->getName().' успешно спарсены');
    }
}