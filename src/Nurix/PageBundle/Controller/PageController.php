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
            throw $this->createNotFoundException('Page not found 404');
        }
        else
        return $this->render('NurixPageBundle:Pages:pages.html.twig', array('page' => $pages));





    }




}
