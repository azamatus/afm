<?php

namespace Nurix\PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageController extends Controller
{
    public function indexAction($url)
    {
        $pages = $this->getDoctrine()
            ->getRepository('NurixPageBundle:Pages')
            ->findOneBy(array("url"=>$url));

        if(!$pages){
            throw new \Exception("Page not found");
        }
        else
        return $this->render('NurixPageBundle:Pages:pages.html.twig', array('page' => $pages));





    }




}
