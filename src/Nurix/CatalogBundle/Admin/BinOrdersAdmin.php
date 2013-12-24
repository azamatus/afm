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
use Sonata\AdminBundle\Form\FormMapper;

class BinOrdersAdmin extends Admin{

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('amount',null,array('label'=>'Количество'))
            ->add('good',null,array('label'=>'Товар'))
            ->add('coast',null,array('label'=>'Цена'))
            ->add('status','choice',array('label'=>'Статус','choices'=>EnumStatusType::toArray()));
    }
}