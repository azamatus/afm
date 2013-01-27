<?php

namespace Nurix\CatalogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Nurix\CatalogBundle\Entity\Categories;
use Doctrine\ORM\QueryBuilder;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        $repository = $this->getDoctrine()->getRepository("CatalogBundle:Categories");
        $categories = $repository->findAll();
        return $this->render('CatalogBundle:Default:index.html.twig', array('name' => $name, 'categories'=>$categories));

    }
}
