<?php

namespace Nurix\CatalogBundle\Form\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BinClientsFormType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('fio','text',array('label'=>'checkout.fullname', 'label_attr'=>array('class'=>'control-label'), 'required'=>true));
        $builder->add('phone','text',array('label'=>'checkout.phone', 'label_attr'=>array('class'=>'control-label'), 'required'=>true));
        $builder->add('email','email',array('label'=>'checkout.email', 'label_attr'=>array('class'=>'control-label'), 'required'=>true));
        $builder->add('delivery','checkbox',array('label'=>'checkout.needdelivery', 'label_attr'=>array('class'=>'control-label'), 'required'=>false));
        $builder->add('address','text',array('label'=>'checkout.address', 'label_attr'=>array('class'=>'control-label'), 'required'=>false));
        $builder->add('delivery_time', 'datetime', array(
            'input'  => 'datetime',
            'widget' => 'choice',
            'years' => range(date('Y'), intval(date('Y'))+1),
            'label' => 'checkout.datetime',
            'required' => true,
            'label_attr'=>array('class'=>'control-label')
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

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array('translation_domain'=>'CatalogBundle'));
    }


}