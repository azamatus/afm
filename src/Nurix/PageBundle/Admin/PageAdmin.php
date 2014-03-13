<?php

namespace Nurix\PageBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Knp\Menu\ItemInterface as MenuItemInterface;

class PageAdmin extends Admin
{
    public function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('url')
            ->add('title')
            ->add('content')
        ;
    }

    public function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Страница')
            ->add('url')
            ->add('translations', 'a2lix_translations', array(
            'fields' => array(                      // [3]
                'title' => array(                   // [3.a]
                    'label' => 'Заголовок',                     // [4]
                ),                      // [3]
                'content' => array(                   // [3.a]
                    'field_type' => 'ckeditor',                 // [4]
                    'label' => 'Контент',                     // [4]
                    'attr' => array('class' => 'span10', 'rows' => 20), 'config_name' => 'my_config',
                )
            )
        ))
//            ->add('title')
//            ->add('content', 'ckeditor', array('attr' => array('class' => 'span10', 'rows' => 20), 'config_name' => 'my_config'))
            ->end()
        ;
    }

    public function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->addIdentifier('url')
            ->add('title')
        ;
    }


}