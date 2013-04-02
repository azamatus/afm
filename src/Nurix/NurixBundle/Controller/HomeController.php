<?php

namespace Nurix\NurixBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    public function homeAction()
    {
        return $this->render('NurixBundle:Home:home.html.twig');
    }
}
