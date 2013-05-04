<?php

namespace Nurix\NurixBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('NurixBundle:Default:index.html.twig', array('name' => $name));
    }

    public function uploadFileAction(Request $request){

        if ($request->isMethod('POST')) {
                $file = $request->files->get('upload');
                $extension = $file->guessExtension();
            if(in_array($extension,array('jpg','jpeg','png'))){
                    $dir = $this->get('kernel')->getRootDir() . '/../web/upload/ckimages';
                    $filename = sha1(uniqid(mt_rand(), true));
                    $filename = $filename . '.' . $extension;
                    $file->move($dir, $filename);
                    return new Response($dir.'/'.$filename);
                }
        }
    }
}
