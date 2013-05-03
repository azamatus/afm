<?php

namespace Nurix\CatalogBundle\Form\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class BinClientsFormType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('fio','text',array('label'=>'ФИО', 'required'=>true));
        $builder->add('phone','text',array('label'=>'Номер телефона', 'required'=>true));
        $builder->add('email','email',array('label'=>'email', 'required'=>true));
        $builder->add('delivery','checkbox',array('label'=>'Доставить?', 'required'=>false));
        $builder->add('address','text',array('label'=>'Адрес', 'required'=>false));
        $builder->add('delivery_time', 'datetime', array(
            'input'  => 'datetime',
            'widget' => 'choice',
            'years' => range(date('Y'), intval(date('Y'))+1),
            'label' => 'Удобное время для доставки',
            'required' => true,
        ));
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'bin_clients';
    }
}