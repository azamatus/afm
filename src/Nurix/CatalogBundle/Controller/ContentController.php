<?php

namespace Nurix\CatalogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Nurix\CatalogBundle\Entity;

class ContentController extends Controller
{
    public function showRandomProductListAction()
    {
        $repository = $this->getDoctrine()
            ->getRepository("CatalogBundle:Goods");

        $paginate = $repository->paginateGoods();

        $paginator = $this->get('knp_paginator');

        $pagination = $paginator
            ->paginate($paginate,
            $this->get('request')->query->get('page',1),3);

        return $this->render('CatalogBundle:Content:showRandomProductList.html.twig', array( 'pagination' => $pagination));

    }


    public function showSliderProductListAction()
    {
        $products = $this->getDoctrine()->getRepository('CatalogBundle:Goods')->findAll();
        return $this->render('CatalogBundle:Content:showCatalogSlider.html.twig', array('products' => $products,'title' => "Топ продаж"));
    }


    public function catalogAction()
    {
        $catalogs = $this->getDoctrine()->getManager()
            ->getRepository('CatalogBundle:Catalog')->getAll(array('active'=>1, 'parent'=>1));

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
}
