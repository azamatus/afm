<?php

namespace Nurix\CatalogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class BinController extends Controller
{
    public function binAction()
    {
        $request = $this->getRequest();
        $goodsIds = $request->cookies->get("cookieGoods");
        $goods = null;
        if (!empty($goodsIds)) {
            $repository = $this->getDoctrine()->getRepository("CatalogBundle:Goods");
            $goods = $repository->getGoodsByIds($goodsIds);
        }

        return $this->render('CatalogBundle:Bin:itemInBin.html.twig', array(
            'goods' => $goods,
            'goodIds' => $goodsIds
        ));
    }

    public function addAjaxBinAction($id)
    {
        if ($this->getRequest()->isXmlHttpRequest()) {

            $product = $this->getDoctrine()
                ->getRepository("CatalogBundle:Goods")
                ->find($id);

            $request = $this->getRequest();

            if ($product) {
                $goods = $request->cookies->get("cookieGoods");
                if (!isset($goods[$id]) || empty($goods[$id]))
                    $goods[$id] = 0;
                $goods[$id]++;
                $response = new Response(json_encode(array(
                    'error' => false,
                    'title' => $product->getName()
                )));

                $cookie = new Cookie("cookieGoods[$id]", $goods[$id], time() + 3600);
                $response->headers->setCookie($cookie);
                $response->headers->set('Content-Type', 'application/json');
                return $response;
            } else {
                return JsonResponse::create(array('error' => true, 'message' => 'Что то не то'));
            }
        }
        return new Response();
    }

    public function binFormAction(Request $request)
    {
        if ($request->isMethod('POST')) {
            $data = $request->request->get('bin');
            $goods = $request->cookies->get("cookieGoods");
            $response = new \Symfony\Component\HttpFoundation\RedirectResponse($this->generateUrl('nurix_bin_item'));
            if(!empty($goods)){
            foreach ($goods as $key => $value) {
                if (!isset($data[$key])) {
                    $response->headers->clearCookie("cookieGoods[$key]");
                }
            }
            }
            if(!empty($data)){
            foreach ($data as $key => $value) {
                if ($value == 0) {
                    $response->headers->clearCookie("cookieGoods[$key]");
                } else {
                    $cookie = new Cookie("cookieGoods[$key]", $value, time() + 3600);
                    $response->headers->setCookie($cookie);
                }
            }
            }
        }
        if ($request->request->get('bin-btn') == 'Оформить заказ') {
            $response->setTargetUrl($this->generateUrl('nurix_homepage'));
            return $response;

        } elseif ($request->request->get('bin-btn') == 'Продолжить покупки') {

            $response->setTargetUrl($this->generateUrl('nurix_homepage'));
            return $response;
        }
    }
}