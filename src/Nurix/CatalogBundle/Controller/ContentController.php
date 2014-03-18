<?php

namespace Nurix\CatalogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Nurix\CatalogBundle\Entity;
use Symfony\Component\HttpFoundation\Response;

class ContentController extends Controller
{
    var $limitPerPage = 12;
    public function showRandomProductListAction()
    {
        /** @var $repository Entity\GoodsRepository */
        $repository = $this->getDoctrine()
            ->getRepository("CatalogBundle:Goods");

        $paginate = $repository->getMainGoods();

        $paginator = $this->get('knp_paginator');

        $pagination = $paginator
            ->paginate($paginate,
            $this->get('request')->query->get('page',1),
                $this->limitPerPage);

        $pagination->setUsedRoute('nurix_catalog_get_rndcatalog');

        if ($this->getRequest()->isXmlHttpRequest()){
            return $this->render('CatalogBundle:Content:getAjaxRandomProductList.html.twig', array( 'pagination' => $pagination));
        }else{
            return $this->render('CatalogBundle:Content:showRandomProductList.html.twig', array( 'pagination' => $pagination, 'title' => "Весь каталог"));
        }

    }

    public function showAvailableProductListAction()
    {
        /** @var $repository Entity\GoodsRepository */
        $repository = $this->getDoctrine()
            ->getRepository("CatalogBundle:Goods");

        $paginate = $repository->getAvailableGoods();

        $paginator = $this->get('knp_paginator');

        $pagination = $paginator
            ->paginate($paginate,
                $this->get('request')->query->get('page',1),
                $this->limitPerPage);

        $pagination->setUsedRoute($this->getRequest()->get('_route'));

        if ($this->getRequest()->isXmlHttpRequest()){
            return $this->render('CatalogBundle:Content:getAjaxRandomProductList.html.twig', array( 'pagination' => $pagination));
        }else{
            return $this->render('CatalogBundle:Content:getcatalog.html.twig', array( 'pagination' => $pagination, 'title' => "В наличии",'subtitle' => "Уточните наличие товара у менеджера"));
        }

    }


    public function showMainPageCatalogListAction()
    {
        $products = $this->getDoctrine()->getRepository('CatalogBundle:Goods')->getSlider();

		return $this->render('CatalogBundle:Content:showMainPageCatalog.html.twig', array('products' => $products,'title' => "Последние обновленные"));

    }

    public function getCatalogAction($cid)
    {
        $catalog=null;
        /** @var $goodsRepository Entity\GoodsRepository */
        $goodsRepository = $this->getDoctrine()
            ->getRepository("CatalogBundle:Goods");
        /** @var $goodsRepository Entity\CatalogRepository */
        $catalogRepository = $this->getDoctrine()
            ->getRepository("CatalogBundle:Catalog");

        if (!$goodsRepository||!$catalogRepository){
            throw new \Exception("Ошибка");
        }

        if ($cid)
        {
            $catalog = $catalogRepository->find($cid);

            if (!$catalog||!$catalog->getActive())
                throw $this->createNotFoundException('Page not found 404');
        }

        $paginate = $goodsRepository->getGoods($cid);

        $paginator = $this->get('knp_paginator');

        $pagination = $paginator
            ->paginate($paginate,
            $this->get('request')->query->get('page',1),
                $this->limitPerPage);

        $pagination->setUsedRoute('nurix_goods_get_catalog');

        if ($this->getRequest()->isXmlHttpRequest()) {
            return $this->render('CatalogBundle:Content:getAjaxRandomProductList.html.twig', array('pagination' => $pagination));
        } else {
            return $this->render('CatalogBundle:Content:getcatalog.html.twig', array('pagination' => $pagination, 'catalog' => $catalog, 'title' => $catalog!=null?$catalog->__toString():"Весь каталог"));
        }
    }
}
