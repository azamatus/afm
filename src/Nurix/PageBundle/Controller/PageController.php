<?php

namespace Nurix\PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('NurixPageBundle:Page:index.html.twig', array('name' => $name));
    }
}
