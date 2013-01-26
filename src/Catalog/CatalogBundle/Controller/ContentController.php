<?php

namespace Catalog\CatalogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Catalog\CatalogBundle\Entity;

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
}
