<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Nurlan
 * Date: 27.01.13
 * Time: 13:36
 * To change this template use File | Settings | File Templates.
 */
namespace Nurix\ArticleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ArticleController extends Controller
{
    public function showArticleAction($type)
    {
        $news = $this->getDoctrine()
            ->getRepository('ArticleBundle:Article')->findBy(array('type'=>$type));
        return $this->render('ArticleBundle:News:index.html.twig',array('news'=>$news));
    }
}
