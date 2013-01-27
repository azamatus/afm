<?php

namespace Nurix\ArticleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NewsController extends Controller
{
    public function allNewsAction($type)
    {
        $news = $this->getDoctrine()
                    ->getRepository('ArticleBundle:Article')->findBy(array('type'=>$type));
        return $this->render('ArticleBundle:News:index.html.twig',array('news'=>$news));
    }
}
