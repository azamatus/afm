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
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;

class AdminController extends CoreController
{

    public function excelAction(Request $request)
    {

        $form = $this->createForm(new ExcelType());

        if ($request->isMethod('POST')) {
            $form->bind($request);

            if ($form->isValid()) {
                $file = $form['file']->getData();
                $extension = null;
                $original_file = $file->getClientOriginalName();

                if (stripos($original_file, 'xlsx')) {
                    $dir = $this->get('kernel')->getRootDir() . '/../web/price';

                    $filename = sha1(uniqid(mt_rand(), true));
                    $filename = $filename . '.' . $extension;
                    $file->move($dir, $filename);
                    $excel_file = new File($dir . '/' . $filename);

                    $info = $this->get('catalog.product.parser')->parseExcel($excel_file);
                    $added_message = 'Добавлено: ' . $info['added'];
                    $updated_message = 'Обновлено: ' . $info['updated'];
                    $this->get('session')->getFlashBag()->add('notice', $added_message);
                    $this->get('session')->getFlashBag()->add('notice', $updated_message);
                } else {
                    $this->get('session')->getFlashBag()->add('notice', 'Неверный формат');
                }

                $this->redirect($this->generateUrl('nurix_admin_parse_excel'));

            }
        }
        return $this->render('CatalogBundle:Admin:excel.html.twig',
            array('form' => $form->createView(),
                'base_template' => $this->getBaseTemplate(),
                'block' => $this->container->getParameter('sonata.admin.configuration.dashboard_blocks')
            ));
    }


}