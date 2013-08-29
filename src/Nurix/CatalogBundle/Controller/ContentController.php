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

        return $this->getProductListView($pagination, null);

    }


    public function showSliderProductListAction()
    {
        $products = $this->getDoctrine()->getRepository('CatalogBundle:Goods')->getSlider();
        if (count($products)>0)
        return $this->render('CatalogBundle:Content:showCatalogSlider.html.twig', array('products' => $products,'title' => "Последние обновленные"));
    }


    public function catalogAction()
    {
        $catalogs = $this->getDoctrine()->getManager()
            ->getRepository('CatalogBundle:Catalog')->getAll(array('active'=>1, 'parent'=>1));

        return $this->render('CatalogBundle:Content:catalog.html.twig',array('catalogs'=>$catalogs));
    }


    public function getCatalogAction($cid)
    {
        /** @var $goodsRepository Entity\GoodsRepository */
        $goodsRepository = $this->getDoctrine()
            ->getRepository("CatalogBundle:Goods");
        /** @var $goodsRepository Entity\CatalogRepository */
        $catalogRepository = $this->getDoctrine()
            ->getRepository("CatalogBundle:Catalog");

        if (!$goodsRepository||!$catalogRepository){
            throw new \Exception("Ошибка");
        }
        $catalog = $catalogRepository->find($cid);

        if (!$catalog||!$catalog->getActive())
            throw $this->createNotFoundException('Page not found 404');

        $paginate = $goodsRepository->getGoods($cid);

        $paginator = $this->get('knp_paginator');

        $pagination = $paginator
            ->paginate($paginate,
            $this->get('request')->query->get('page',1),
                $this->limitPerPage);

        $pagination->setUsedRoute('nurix_goods_get_catalog');

        return $this->getProductListView($pagination, $catalog);
    }

    /**
     * @param $pagination
     * @param $catalog
     * @return mixed
     */
    public function getProductListView($pagination, $catalog)
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            return $this->render('CatalogBundle:Content:getAjaxRandomProductList.html.twig', array('pagination' => $pagination));
        } else {
            return $this->render('CatalogBundle:Content:getcatalog.html.twig', array('pagination' => $pagination, 'catalog' => $catalog));
        }
    }
}
