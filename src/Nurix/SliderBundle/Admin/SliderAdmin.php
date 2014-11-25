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
            ->add('description')
            ->add('active')
            ->add('sliderOrder')
            ->add('url')
        ;
    }

    public function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('title')
            ->add('description')
            ->add('sliderOrder','integer')
            ->add('active', null, array('required' => false))
            ->add('url')
            ->add('image', 'sonata_type_model_list', array('required' => true), array('link_parameters' => array('context' => 'slider')))
        ;
    }

    public function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title')
            ->addIdentifier('description')
            ->add('active', 'boolean', array('editable' => true))
            ->add('sliderOrder')
        ;
    }

    public function preUpdate($object)
    {
        $repository = $this->getConfigurationPool()->getContainer()->get('doctrine')->getManager()->getRepository("NurixSliderBundle:Slider");
        $original = (object) $this->getModelManager()->getEntityManager($this->getClass())->getUnitOfWork()->getOriginalEntityData($object);
        if ($original->sliderOrder!=$object->getSliderOrder())
            $repository->updateOrders($object->getSliderOrder(),$object->getId());
    }
}