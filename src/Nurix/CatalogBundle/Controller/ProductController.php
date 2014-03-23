<?php

namespace Nurix\CatalogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Nurix\CatalogBundle\Entity\Goods;
use Nurix\CatalogBundle\Entity;
use Doctrine\ORM\QueryBuilder;


class ProductController extends Controller
{
    public function getInfoAction($id)
    {
        /** @var $goodRepository Entity\GoodsRepository */
        $goodRepository = $this->getDoctrine()
            ->getRepository('CatalogBundle:Goods');
        $entity = $goodRepository
            ->find($id);
        if (!$entity||!$entity->getActive())
            throw $this->createNotFoundException('Page not found 404');

        $goods = $this->getRequest()->cookies->get("cookieGoods");

        $amount=1;
        if (isset($goods[$id]))
            $amount = $goods[$id];


        $charRepository= $this->getDoctrine()
            ->getRepository("CatalogBundle:Characteristic");

        $mainchar = $charRepository
            ->findBy(array("goodId"=>$id), null, 8);

        $goodRepository->incrementViews($entity->getId());

        /** @var $charRepository Entity\CharacteristicRepository */
        $char = $charRepository->getGoodCharacteristic($id);

        return $this->render('CatalogBundle:Product:product_info.html.twig', array('product' => $entity, 'char'=>$char, 'mainchar' => $mainchar,'amount'=>$amount));
    }
    public function getSameAction(Goods $product)
    {
        $same = $this ->getDoctrine()
            ->getRepository('CatalogBundle:Goods')
            ->getRelativeProducts($product,$this->container->getParameter('related_product_count'));

        return $this->render('CatalogBundle:Product:get_related_items.html.twig', array('products' => $same,'title' => "Похожие позиции"));
    }
}
