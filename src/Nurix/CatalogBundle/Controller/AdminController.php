<?php
/**
 * Created by JetBrains PhpStorm.
 * User: root
 * Date: 4/14/13
 * Time: 7:07 PM
 * To change this template use File | Settings | File Templates.
 */
namespace Nurix\CatalogBundle\Controller;

use Nurix\CatalogBundle\Form\Type\ExcelType;
use Sonata\AdminBundle\Controller\CoreController;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends CoreController{

    public function indexAction(Request $request){

        $form = $this->createForm(new ExcelType());

        if($request->isMethod('POST')){
            $form->bind($request);

            if($form->isValid()){
                $file = $form['file']->getData();
                $extension='undefined';
                $original_file = $file->getClientOriginalName();

                if(stripos($original_file,'xlsx')){
                    $extension = 'xlsx';
                }elseif(stripos($original_file,'xls')){
                    $extension = 'xls';
                }

                if( $extension > 'x' ){
                    $dir = $this->get('kernel')->getRootDir(). '/../web/price';

                    $filename = sha1(uniqid(mt_rand(), true));
                    $filename= $filename.'.'.$extension;
                    $file->move($dir,$filename);
                    $this->get('session')->getFlashBag()->add('notice','Успех');
                }
                else{
                    $this->get('session')->getFlashBag()->add('notice','Неверный формат');
                }

                $this->redirect($this->generateUrl('nurix_admin_index'));

            }
        }
        return $this->render('CatalogBundle:Admin:index.html.twig',
            array('form'=>$form->createView(),
                'base_template'=>$this->getBaseTemplate(),
                'block'=>$this->container->getParameter('sonata.admin.configuration.dashboard_blocks')
            ));
    }
}