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

        return $this->render('CatalogBundle:Search:index.html.twig', array('products'=>$products,'searchText'=>$searchText));
    }
}