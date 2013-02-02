<?php

namespace Nurix\ArticleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ArticleController extends Controller
{
    public function listAction($type)
    {
        if ($type != 'local' && $type != 'global' ){
            return $this->redirect($this->generateUrl("nurix_homepage"));
        }

        $news = $this->getDoctrine()
            ->getRepository('ArticleBundle:Article')->findBy(array('type'=>$type));

        return $this->render('ArticleBundle:Article:index.html.twig',array('news'=>$news));
    }

    public function showAction($id){
        $article = $this->getDoctrine()
            ->getRepository('ArticleBundle:Article')->find($id);

        if (!$article){
            throw new \Exception('Новость не найдена');
        }

        return $this->render("ArticleBundle:Article:show.html.twig", array(
            "article"   => $article
        ));
    }
}
