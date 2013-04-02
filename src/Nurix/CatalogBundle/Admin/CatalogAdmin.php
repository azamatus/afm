<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Nursultan
 * Date: 3/31/13
 * Time: 1:49 PM
 * To change this template use File | Settings | File Templates.
 */
namespace Nurix\CatalogBundle\Admin;
use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;


class CatalogAdmin extends Admin{

    protected function configureShowField(ShowMapper $showMapper)
    {
        $showMapper
                ->add('id',null,array('label'=>'ID'))
                ->add('cname',null,array('label'=>'Заголовок'))
                ->add('active',null,array('label'=>'Активный'))
                ->add('parent','entity');
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
                ->add('cname',null,array('label'=>'Заголовок'))
                ->add('active',null,array('label'=>'Активный','required'=>false))
                ->add('parent','entity', array(
                'class' => 'CatalogBundle:Catalog','required'=>false,
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->where('p.parent is null')
                        /*->setParameter('id', null)*/;
                },
            ));
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
                ->addIdentifier('id')
                ->addIdentifier('cname',null,array('label'=>'Заголовок'))
                ->add('active','checkbox',array('label'=>'Активный','required'=>false))
                ->add('parent','sonata_type_model',array('label'=>'Парент'));
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
                ->add('cname',null,array('label'=>'Заголовок'))
                ->add('parent',null);
    }
}