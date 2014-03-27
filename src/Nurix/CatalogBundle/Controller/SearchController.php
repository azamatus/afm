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

    public function indexAction()
    {

        $form = $this->createForm($this->get('nurix.search_form'));
        $request = $this->getRequest();
        if ($request->isMethod('GET')) {
            $form->submit($request);
            $searchText =$form->get('search')->getData();

            $repository = $this->getDoctrine()->getRepository('CatalogBundle:Goods');
            $products = $repository->searchGoods($searchText);

            $paginator = $this->get('knp_paginator');

            $pagination = $paginator
                ->paginate($products,
                    $this->get('request')->query->get('page',1),
                    $this->getRequest()->cookies->get("cookieQuantity", 12));

            $pagination->setUsedRoute($this->getRequest()->get('_route'));

            return $this->render('CatalogBundle:Search:index.html.twig', array('pagination'=>$pagination,'searchText'=>$searchText,'form'=>$form->createView()));


        }
        else
        {
            Throw new \HttpRequestMethodException('Запрос не верен');
        }
    }

    public function showFormAction()
    {
        $form = $this->createForm($this->get('nurix.search_form'));

        return $this->render('CatalogBundle:Search:searchForm.html.twig',array('form'=>$form->createView()));
    }
}