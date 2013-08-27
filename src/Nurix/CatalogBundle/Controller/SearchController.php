<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Nurlan
 * Date: 30.03.13
 * Time: 17:08
 * To change this template use File | Settings | File Templates.
 */

namespace Nurix\CatalogBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SearchController extends Controller
{
    public function indexAction($searchText)
    {
        $repository = $this->getDoctrine()->getRepository('CatalogBundle:Goods');
        $products = $repository->searchGoods($searchText);

        $paginator = $this->get('knp_paginator');

        $pagination = $paginator
            ->paginate($products,
                $this->get('request')->query->get('page',1),
                $this->limitPerPage);

        $pagination->setUsedRoute('nurix_catalog_search');

        if ($this->getRequest()->isXmlHttpRequest()){
            return $this->render('CatalogBundle:Content:getAjaxRandomProductList.html.twig', array( 'pagination' => $pagination));
        }else{
            return $this->render('CatalogBundle:Search:index.html.twig', array('pagination'=>$pagination,'searchText'=>$searchText));
        }
    }
}