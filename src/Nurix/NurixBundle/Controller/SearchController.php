<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Nurlan
 * Date: 30.03.13
 * Time: 17:08
 * To change this template use File | Settings | File Templates.
 */

namespace Nurix\NurixBundle\Controller;


use Nurix\NurixBundle\Form\SearchType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;

class SearchController extends Controller
{
    public function indexAction()
    {

        $form = $this->createForm(new SearchType());
        $request = $this->getRequest();
        if ($request->isMethod('POST')) {
            $form->bind($request);
        $searchText =$form->get('search')->getData();
        return $this->render('NurixBundle:Search:index.html.twig',array('searchText'=>$searchText));
        }
        else
        {
            Throw new \HttpRequestMethodException('Запрос не верен');
        }
    }

    public function showFormAction()
    {
        $form = $this->createForm(new SearchType());

        return $this->render('NurixBundle:Search:searchForm.html.twig',array('form'=>$form->createView()));
    }
}