<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Mederbek
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

class ReviewsAdmin extends Admin
{
    public function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('author')
            ->add('comment')
            ->add('created')
            ->add('rating');

    }

    public function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('author')
            ->add('comment')
            ->add('rating')
            ->add('created')
            ->end()
        ;
    }

    public function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id', null, array('label' => 'ID'))
            ->add('author', null, array('label' => 'Автор'))
            ->add('comment', null, array('label' => 'Комментарий'))
            ->add('created', 'date', array('label' => 'Создано'))
            ->add('rating', null, array('label' => 'Рейтинг'));

    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('author', null, array('label' => 'Автор'))
            ->add('created', 'doctrine_orm_date_range', array('label' => 'Дата'));
    }

}

