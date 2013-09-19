<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Nursultan
 * Date: 4/1/13
 * Time: 12:39 PM
 * To change this template use File | Settings | File Templates.
 */
namespace Nurix\CatalogBundle\Admin;
use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

class ExchangeAdmin extends Admin
{
    public function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('currency')
            ->add('exchangeRate')
            ->add('date')
        ;
    }

    public function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('currency',null, array('label'=>'Валюта','required'=>false))
            ->add('exchangeRate')
            ->add('date')
            ->end()
        ;
    }

    public function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('currency',null, array('label'=>'Валюта'))
            ->add('exchangeRate',null, array('editable'=>true, 'label'=>'Курсы', 'template'=>'StrokitCoreBundle:Admin:edit_integer.html.twig'))
            ->add('date')
        ;
    }

    public function getTemplate($name)
    {
        switch ($name) {
            case 'list':
                return 'StrokitCoreBundle:Admin:base_layout.html.twig';
                break;
            default:
                return parent::getTemplate($name);
                break;
        }
    }



}

