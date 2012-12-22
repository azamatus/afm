<?php

namespace Catalog\CatalogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Catalog\CatalogBundle\Entity\Categories;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        $category = new Categories();

        return $this->render('CatalogBundle:Default:index.html.twig', array('name' => $name));
    }
}
