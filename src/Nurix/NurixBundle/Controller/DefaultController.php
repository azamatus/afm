<?php

namespace Nurix\NurixBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('NurixBundle:Default:index.html.twig', array('name' => $name));
    }
}
