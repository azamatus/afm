<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Nursultan
 * Date: 5/26/13
 * Time: 1:48 AM
 * To change this template use File | Settings | File Templates.
 */
namespace Nurix\CatalogBundle\Admin;
use Nurix\CatalogBundle\DBAL\EnumStatusType;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class BinClientsAdmin extends Admin{

    protected function configureShowField(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id',null,array('label'=>'ID'));
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('active','choice',array('label'=>'Статус','choices'=>EnumStatusType::toArray()))
            ->add('orders', 'sonata_type_collection',
                array('label' => 'Ссылки', 'by_reference' => false),
                array(
                    'edit' => 'inline',
                    'sortable' => 'pos',
                    'inline' => 'table',
                ));
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id',null,array('label'=>'ID'))
            ->addIdentifier('fio',null,array('label'=>'Ф.И.О'))
            ->add('phone',null,array('label'=>'Телефон'))
            ->add('address',null,array('label'=>'Адрес'))
            ->add('email',null,array('label'=>'E-mail'))
            ->add('deliveryTime',null,array('label'=>'Время доставки'))
            ->add('delivery',null,array('label'=>'Доставка'))
            ->add('active','',array('label'=>'Статус'));
    }
}