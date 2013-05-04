<?php

namespace Nurix\CatalogBundle\Controller;

use Application\Sonata\UserBundle\Entity\User;
use Nurix\CatalogBundle\Entity\BinClients;
use Nurix\CatalogBundle\Entity\BinOrders;
use Nurix\CatalogBundle\Form\Type\BinClientsFormType;
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
            'goodCount' => $goodsIds
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
                $amount = $request->query->get('amount', 1);
                $productPage = $request->query->get('productPage');
                if($productPage=="true")
                    $goods[$id]=$amount;
                else
                    $goods[$id]++;
                $response = new Response();
                $cookie = new Cookie("cookieGoods[$id]", $goods[$id], time() + 3600);
                $response->headers->setCookie($cookie);
                $response->send();
//                $response->headers->set('Content-Type', 'application/json');
//                return $response;
                return $this->render('CatalogBundle:Bin:addAjaxBin.html.twig', array(
                    'tovar' => $product
                ));
            } else {
//                return JsonResponse::create(array('error' => true, 'message' => 'Что то не то'));
                throw new \Exception('Что то не так');
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
            if (!empty($goods)) {
                foreach ($goods as $key => $value) {
                    if (!isset($data[$key])) {
                        $response->headers->clearCookie("cookieGoods[$key]");
                    }
                }
            }
            if (!empty($data)) {
                foreach ($data as $key => $value) {
                    if ($value == 0) {
                        $response->headers->clearCookie("cookieGoods[$key]");
                    } else {
                        $cookie = new Cookie("cookieGoods[$key]", $value, time() + 3600);
                        $response->headers->setCookie($cookie);
                    }
                }
            }
        if ($request->request->get('bin-btn') == 'Оформить заказ') {
            $response->setTargetUrl($this->generateUrl('nurix_bin_order_form'));
            return $response;

        } elseif ($request->request->get('bin-btn') == 'Продолжить покупки') {
            $response->setTargetUrl($this->generateUrl('nurix_homepage'));
            return $response;
        }
        }
    }

    public function mainBinAction(){
        $request = $this->getRequest();
        $goodsIds = $request->cookies->get("cookieGoods");
        $goods = null;
        if (!empty($goodsIds)) {
            $repository = $this->getDoctrine()->getRepository("CatalogBundle:Goods");
            $goods = $repository->getGoodsByIds($goodsIds);
        }
        $sum=0;
        $kol=0;
        if($goods){
            foreach($goods as $good)
            {
                $k=$goodsIds[$good->getId()];
                $kol+=$k;
                $sum+=($good->getPrice()*$k);
            }
        }
        return $this->render('CatalogBundle:Bin:mainBin.html.twig',array('count'=>$kol,'sum'=>$sum));
    }

    public function binOrderFormAction(Request $request){
        $goodsIds = $request->cookies->get("cookieGoods");
        if (empty($goodsIds)) {
            return $this->redirect($this->generateUrl("nurix_bin_item"));
        }

        $binClients = new BinClients();
        $binClients->setDeliveryTime(new \DateTime());
        /** @var $user User */
        $user = $this->getUser();
        if (!is_null($user)){
            $binClients->setUser($user);
            $binClients->setFio($user->getFullname());
            $binClients->setEmail($user->getEmail());
            $binClients->setPhone($user->getPhone());
            $binClients->setAddress($user->getAddress());

        }
        $form = $this->createForm(new BinClientsFormType(), $binClients);

        if ($request->isMethod("POST")){
            $form->bindRequest($request);
            if ($form->isValid()){
                $em = $this->getDoctrine()->getEntityManager();
                $binClients->setDateOrder(new \DateTime());
                $em->persist($binClients);
                $em->flush();

                $repository = $this->getDoctrine()->getRepository("CatalogBundle:Goods");
                $goods = $repository->getGoodsByIds($goodsIds);
                if (!empty($goods)){
                    foreach ($goods as $good){
                        $binOrders = new BinOrders();
                        $binOrders->setBinClient($binClients);
                        $binOrders->setGood($good);
                        $binOrders->setAmount($goodsIds[$good->getId()]);
                        $binOrders->setCoast($good->getPrice());
                        $em->persist($binOrders);
                    }
                    $em->flush();
                }

                $this->get('session')->setFlash('notice', 'Ваш заказ принят');
            }
        }
        return $this->render("CatalogBundle:Bin:binOrderForm.html.twig", array(
            "form"  => $form->createView()
        ));
    }
}