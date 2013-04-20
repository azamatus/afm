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

class AdminController extends CoreController{

    public function indexAction(Request $request){

        $form = $this->createForm(new ExcelType());

        if($request->isMethod('POST')){
            $form->bind($request);

            if($form->isValid()){
                $file = $form['file']->getData();
                $extension='undefined';
                $original_file = $file->getClientOriginalName();

                if(stripos($original_file,'xlsx')){
                    $extension = 'xlsx';
                }elseif(stripos($original_file,'xls')){
                    $extension = 'xls';
                }

                if( $extension >='xls' ){
                    $dir = $this->get('kernel')->getRootDir(). '/../web/price';

                    $filename = sha1(uniqid(mt_rand(), true));
                    $filename= $filename.'.'.$extension;
                    $file->move($dir,$filename);
                    $excel_file = new File($dir .'/'.  $filename);

                    $this->parseExcel($excel_file);

                    $this->get('session')->getFlashBag()->add('notice','Успех');
                }
                else{
                    $this->get('session')->getFlashBag()->add('notice','Неверный формат');
                }

                $this->redirect($this->generateUrl('nurix_admin_index'));

            }
        }
        return $this->render('CatalogBundle:Admin:index.html.twig',
            array('form'=>$form->createView(),
                'base_template'=>$this->getBaseTemplate(),
                'block'=>$this->container->getParameter('sonata.admin.configuration.dashboard_blocks')
            ));
    }

    public function parseExcel( File $file){

        $exelObj = $this->get('xls.load_xls2007')->load($file);
        $sheetData = $exelObj->getActiveSheet()->toArray(null,true,true,true);
        $tmp=0;

        foreach($sheetData as $array){

            $tmp++;
            if($tmp==1) continue;
            $article = $array['A']?$array['A']:'No Article';
            $model = $array['B']?$array['B']:'No Model';
            $last_update =new DateTime(date('Y-m-d',strtotime($array['I'])));
            $price = (integer)$array['L'];
            $yandex = $array['Q'];


            $good = new Goods();
            $good->setArticle($article);
            $good->setModel($model);
            $good->setName($model);
            $good->setLastUpdate($last_update);
            $good->setPrice($price);
            $em = $this->getDoctrine()->getManager();
            $em->persist($good);
            $em->flush();

            $id = $good->getId();

            if($yandex) $this->parseYandex($yandex,$id);
        }
    }

    public function parseYandex($url, $goodid)
    {
        $good = $this->getDoctrine()->getRepository('CatalogBundle:Goods')->find($goodid);
        if (!$good)
        {
            Throw new EntityNotFoundException("good not found");
        }
        $html =HtmlDomParser::file_get_html($url);
        foreach ($html->find('table.l-page_layout_72-20 .b-properties') as $table) {
            $sid = 0;
            foreach ($table->find('tr') as $tr) {
                $section_type = null;
                $html_span = HtmlDomParser::str_get_html($tr);
                $section_type = $html_span->find('.b-properties__title', -1);

                if($section_type!=null){
                    $section_type = $section_type->plaintext;
                    $repository = $this->getDoctrine()->getRepository('CatalogBundle:CharacteristicSection');
                    $characteristic_section =$repository->findOneBySectionvalue($section_type);
                    if($characteristic_section){
                        $sid = $characteristic_section;
                    }
                    else{
                        $section = new CharacteristicSection();
                        $section->setSectionvalue($section_type);

                        $em = $this->getDoctrine()->getManager();
                        $em->persist($section);
                        $em->flush();
                        $sid =$section;
                    }
                }
                else{
                    $char_type = $html_span->find('.b-properties__label-title', -1)->plaintext;

                    $char = $html_span->find('.b-properties__value', -1)->plaintext;
                    $repository = $this->getDoctrine()->getRepository('CatalogBundle:CharacteristicType');
                    $type=$repository->findOneByName($char_type);

                    if($type){
                        $tid = $type;

                    }else{
                        $characteristic_type = new CharacteristicType();
                        $characteristic_type->setName($char_type);
                        $characteristic_type->setSection($sid);

                        $em = $this->getDoctrine()->getManager();
                        $em->persist($characteristic_type);
                        $em->flush();
                        $tid =$characteristic_type;
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