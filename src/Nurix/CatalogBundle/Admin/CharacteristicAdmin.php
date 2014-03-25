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

class CharacteristicAdmin extends Admin
{
    protected function configureShowField(ShowMapper $showmapper)
    {
        $showmapper
            ->add('id', null, array('label' => 'ID'))
            ->add('good', null, array('label' => 'Товар'))
            ->add('value', null, array('label' => 'Значение'));

    }

    protected function configureFormFields(FormMapper $formmapper)
    {
        $formmapper
            ->add('cTypeId', 'sonata_type_model', array('label' => 'Тип'))
            ->add('value', null, array('label' => 'Значение'));
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(array('edit','create'));
    }
}