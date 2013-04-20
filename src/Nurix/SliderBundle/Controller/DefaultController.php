<?php

namespace Nurix\SliderBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('NurixSliderBundle:Default:index.html.twig', array('name' => $name));
    }
}