<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Nurlan
 * Date: 31.03.13
 * Time: 13:38
 * To change this template use File | Settings | File Templates.
 */

namespace Nurix\NurixBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('search', null,array('attr'=>array('class' =>'search','placeholder'=>'Поиск...')));
        //$builder->add('dueDate', null, array('widget' => 'single_text'));
    }
    public function getName()
    {
        return 'search';
    }
}