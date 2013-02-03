<?php

namespace Nurix\CatalogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;

class BinController extends Controller
{
    public function binAction()
    {

    }

    public function addAjaxBinAction($id)
    {
        if ($this->getRequest()->isXmlHttpRequest()){

           $product=$this->getDoctrine()
                ->getRepository("CatalogBundle:Goods")
                ->find($id);

            $request = $this->get('request');

            $cookieGoods = $request->cookies->get('cookieGoods');
           if ($product){
                $products = array_merge($cookieGoods,array($product));
                $cookie = new Cookie('cookieGoods',$products , time() + 3600);
                $response = new Response();
                $response->headers->setCookie($cookie);

                return JsonResponse::create(array('title'=>$products[0]->getName()));
            }
            else{

                return JsonResponse::create(array('error'=>true, 'message'=>'Что то не то'));
            }
        }
        return new \Symfony\Component\HttpFoundation\Response();
    }
}