<?php

namespace Nurix\CatalogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Nurix\CatalogBundle\Entity;

class ContentController extends Controller
{
    public function showRandomProductListAction()
    {
        $products = $this->getDoctrine()->getRepository('CatalogBundle:Goods')->findAll();
        return $this->render('CatalogBundle:Content:showRandomProductList.html.twig', array('products' => $products));
    }


    public function showSliderProductListAction()
    {
        $products = $this->getDoctrine()->getRepository('CatalogBundle:Goods')->findAll();
        return $this->render('CatalogBundle:Content:showCatalogSlider.html.twig', array('products' => $products));
    }


    public function catalogAction()
    {
        $catalogs = $this->get('catalog.model')->getAll(array('active'=>1, 'parent'=>1));

        return $this->render('CatalogBundle:Content:catalog.html.twig',array('catalogs'=>$catalogs));
    }


    public function getCatalogAction($cid)
    {
        $catalog = $this->getDoctrine()->getManager()
            ->getRepository('CatalogBundle:Catalog');

        if (!$catalog){
            throw new \Exception("Ошибка");
        }
            $products = $catalog->getGoods($cid);
            return $this->render('CatalogBundle:Content:getcatalog.html.twig',array('products'=>$products));

    }


        public  function  getItemAction($gid){
        $item = $this->getDoctrine()
            ->getRepository('CatalogBundle:Goods')
            ->find($gid);

        return $this->render('CatalogBundle:Content:getitem.html.twig',array('item'=>$item));
    }
}
