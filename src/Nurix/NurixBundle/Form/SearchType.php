<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Nurlan
 * Date: 31.03.13
 * Time: 13:38
 * To change this template use File | Settings | File Templates.
 */

namespace Nurix\NurixBundle\Form;

use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SearchType extends AbstractType
{

    /**
     * @var Translator
     */
    private $translator;

    public function __construct($translator)
    {

        $this->translator = $translator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('search', null,array('attr'=>array('placeholder'=>$this->translator->trans('search.text',array(),'messages'))));
        //$builder->add('dueDate', null, array('widget' => 'single_text'));
    }

    public function getName()
    {
        return 'search';
    }

}