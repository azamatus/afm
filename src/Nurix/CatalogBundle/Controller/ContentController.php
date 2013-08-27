<?php

namespace Nurix\CatalogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Nurix\CatalogBundle\Entity;

class ContentController extends Controller
{
    var $limitPerPage = 12;
    public function showRandomProductListAction()
    {
        $repository = $this->getDoctrine()
            ->getRepository("CatalogBundle:Goods");

        $paginate = $repository->paginateGoods();

        $paginator = $this->get('knp_paginator');

        $pagination = $paginator
            ->paginate($paginate,
            $this->get('request')->query->get('page',1),
                $this->limitPerPage);

        $pagination->setUsedRoute('nurix_catalog_get_rndcatalog');

        if ($this->getRequest()->isXmlHttpRequest()){
            return $this->render('CatalogBundle:Content:getAjaxRandomProductList.html.twig', array( 'pagination' => $pagination));
        }else{
            return $this->render('CatalogBundle:Content:showRandomProductList.html.twig', array( 'pagination' => $pagination));
        }

    }


    public function showSliderProductListAction()
    {
        $products = $this->getDoctrine()->getRepository('CatalogBundle:Goods')->getSlider();
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
        $repository = $this->getDoctrine()
            ->getRepository("CatalogBundle:Catalog");

        if (!$repository){
            throw new \Exception("Ошибка");
        }

        $paginate = $repository->getGoods($cid);

        $paginator = $this->get('knp_paginator');

        $pagination = $paginator
            ->paginate($paginate,
            $this->get('request')->query->get('page',1),
                $this->limitPerPage);

        $pagination->setUsedRoute('nurix_goods_get_catalog');

        if ($this->getRequest()->isXmlHttpRequest()){
            return $this->render('CatalogBundle:Content:getAjaxRandomProductList.html.twig', array('pagination' => $pagination));
        } else{
            return $this->render('CatalogBundle:Content:getcatalog.html.twig', array('pagination' => $pagination));
        }
        }
    }
