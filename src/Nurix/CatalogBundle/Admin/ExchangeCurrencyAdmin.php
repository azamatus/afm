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

class ExchangeCurrencyAdmin extends Admin
{
    public function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('currency')
            ->add('currencyName')
         ;
    }

    public function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('currency')
            ->add('currencyName')
            ->end()
        ;
    }

    public function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->addIdentifier('currency')
            ->add('currencyName')
        ;
    }



}

