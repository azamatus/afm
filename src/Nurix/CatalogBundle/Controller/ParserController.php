<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Nursultan
 * Date: 3/30/13
 * Time: 2:17 PM
 * To change this template use File | Settings | File Templates.
 */
namespace Nurix\CatalogBundle\Controller;
use Doctrine\ORM\EntityNotFoundException;
use Nurix\CatalogBundle\Entity\Characteristic;
use Nurix\CatalogBundle\Entity\CharacteristicSection;
use Nurix\CatalogBundle\Entity\CharacteristicType;
use Sunra\PhpSimple\HtmlDomParser;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ParserController extends Controller {

    public function parseYandex($url, $goodid)
    {
        $good = $this->getDoctrine()->getRepository('CatalogBundle:Goods')->find($goodid);
        if ($good==null)
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
                    $characteristic->setGoodId($good);

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($characteristic);
                    $em->flush();
                }
            }

        }
        return new Response('Характеристики для '.$good->getName().' успешно спарсены');
    }

}