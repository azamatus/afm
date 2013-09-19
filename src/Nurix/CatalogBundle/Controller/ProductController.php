<?php

namespace Nurix\CatalogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Nurix\CatalogBundle\Entity\Goods;
use Nurix\CatalogBundle\Entity;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductController extends Controller
{
    public function getInfoAction($id)
    {
        $entity = $this->getDoctrine()
            ->getRepository('CatalogBundle:Goods')
            ->find($id);
        if (!$entity||!$entity->getActive())
            throw $this->createNotFoundException('Page not found 404');

        $goods = $this->getRequest()->cookies->get("cookieGoods");

        $amount=1;
        if (isset($goods[$id]))
            $amount = $goods[$id];

        $mainchar = $this -> getDoctrine()
            ->getRepository("CatalogBundle:Characteristic")
            ->findBy(array("goodId"=>$id), null, 8);

        $repository= $this->getDoctrine()
            ->getRepository("CatalogBundle:Characteristic");

        $char = $repository->getGoodCharacteristic($id);

        return $this->render('CatalogBundle:Product:product_info.html.twig', array('product' => $entity, 'char'=>$char, 'mainchar' => $mainchar,'amount'=>$amount));
    }
    public function getSameAction(Goods $product)
    {
        $same = $this ->getDoctrine()
            ->getRepository('CatalogBundle:Goods')
            ->getSamePositionsForGood($product);

        return $this->render('CatalogBundle:Content:showCatalogSlider.html.twig', array('products' => $same,'title' => "Похожие позиции"));
    }
}
