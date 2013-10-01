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

class CharacteristicTypeAdmin extends Admin
{
    protected function configureShowField(ShowMapper $showmapper)
    {
        $showmapper
            ->add('id', null, array('label' => 'ID'))
            ->add('name', null, array('label' => 'Название'))
            ->add('section', null, array('label' => 'Секция'));

    }

    protected function configureFormFields(FormMapper $formmapper)
    {
        $formmapper
            ->add('name', null, array('label' => 'Значение'))
            ->add('section', null, array('label' => 'Секция'));
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id',null,array('label'=>'ID'))
            ->addIdentifier('name', null, array('label' => 'Значение'))
            ->add('section', null, array('label' => 'Секция'));
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name', null, array('label' => 'Значение'))
            ->add('section', null, array('label' => 'Секция'))
        ;
    }
}