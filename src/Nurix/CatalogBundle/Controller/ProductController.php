<?php

namespace Nurix\CatalogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Nurix\CatalogBundle\Entity;
use Doctrine\ORM\QueryBuilder;

class ProductController extends Controller
{
    public function getInfoAction($id)
    {
        $entity = $this->getDoctrine()
            ->getRepository('CatalogBundle:Goods')
            ->find($id);
        $gallery = $entity->getYoutube();

        $mainchar = $this -> getDoctrine()
            ->getRepository("CatalogBundle:Characteristic")
            ->findBy(array("goodId"=>$id), null, 8);

        $repository= $this->getDoctrine()
            ->getRepository("CatalogBundle:Characteristic");

        $char = $repository->getGoodCharacteristic($id);



        return $this->render('CatalogBundle:Product:product_info.html.twig', array('product' => $entity, 'char'=>$char, 'mainchar' => $mainchar,'gallery'=>$gallery));
    }
    public function getSameAction()
    {
        $same = $this ->getDoctrine()
            ->getRepository('CatalogBundle:Goods')
            ->findAll();

        return $this->render('CatalogBundle:Content:showCatalogSlider.html.twig', array('products' => $same,'title' => "Похожие позиции"));
    }
}
