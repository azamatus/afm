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
        return $this->render('CatalogBundle:Content:itemInBin.html.twig', array());
    }

    public function addAjaxBinAction($id)
    {
        if ($this->getRequest()->isXmlHttpRequest()){

           $product=$this->getDoctrine()
                ->getRepository("CatalogBundle:Goods")
                ->find($id);

            $request = $this->getRequest();


           if ($product){
               $goods=$request->cookies->get("cookieGoods");
               if (!$goods[$id]||empty($goods[$id]))
                   $goods[$id] = 0;
               $goods[$id]++;
               $response = new Response(json_encode(array(
                   'error' => false,
                   'title' => $product->getName()
               )));

               $cookie = new Cookie("cookieGoods[$id]",$goods[$id], time() + 3600);
               $response->headers->setCookie($cookie);
               $response->headers->set('Content-Type', 'application/json');
               return $response;
            }
            else{

                return JsonResponse::create(array('error'=>true, 'message'=>'Что то не то'));
            }
        }
        return new Response();
    }
}