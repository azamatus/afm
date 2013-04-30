<?php
namespace Nurix\SliderBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Nurix\SliderBundle\Entity;

class SliderAdmin extends Admin
{
    public function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('title')
            ->add('active')
            ->add('sliderOrder')
            ->add('content')
        ;
    }

    public function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
            ->add('title')
            ->add('sliderOrder')
            ->add('active', null, array('required' => false))
            ->add('content', 'ckeditor', array('attr' => array('class' => 'span10', 'rows' => 20),'config'=>array('width'=>'700px','height'=>'345px','resize_enabled'=>false,'resize_maxHeight' => '345px','resize_minHeight' => '345px')))
            ->end()
        ;
    }

    public function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title')
            ->add('active', 'boolean', array('editable' => true))
            ->add('sliderOrder')
        ;
    }

    public function preUpdate($object)
    {
        $repository = $this->getConfigurationPool()->getContainer()->get('doctrine')->getEntityManager()->getRepository("NurixSliderBundle:Slider");
        $original = (object) $this->getModelManager()->getEntityManager($this->getClass())->getUnitOfWork()->getOriginalEntityData($object);
        if ($original->sliderOrder!=$object->getSliderOrder())
            $repository->updateOrders($object->getSliderOrder(),$object->getId());
    }
}