<?php

namespace Nurix\PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageController extends Controller
{
    public function indexAction($url)
    {
        $pages = $this->getDoctrine()
            ->getRepository('NurixPageBundle:Pages')
            ->findBy(array("url"=>$url));
        if(!$pages){
            throw new HttpNotFoundException("Page not found");
        }
        else
        return $this->render('NurixPageBundle:Pages:pages.html.twig', array('pages' => $pages));





    }




}
