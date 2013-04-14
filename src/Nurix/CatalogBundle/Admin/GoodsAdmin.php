<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Nursultan
 * Date: 4/1/13
 * Time: 12:39 PM
 * To change this template use File | Settings | File Templates.
 */
namespace Nurix\CatalogBundle\Admin;
use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class GoodsAdmin extends Admin {

    protected function configureShowField(ShowMapper $showmapper)
    {
        $showmapper
                ->add('id',null,array('label'=>'ID'))
                ->add('name',null,array('label'=>'Название'))
                ->add('catalog','sonata_type_collection',array('label'=>'Каталог'))
                ->add('short_description',null,array('label'=>'Краткое описание'))
                ->add('full_desctiption',null,array('label'=>'Полное описание'))
                ->add('price',null,array('label'=>'Цена'))
                ->add('imagePath','sonata_media_type',array('label'=>'Галерея','provider'=>'sonata.media.provider.image','context'=>'goods'))
                ->add('youtube','sonata_media_type',array('label'=>'Youtube','provider'=>'sonata.media.provider.youtube','context'=>'youtube'))
                ->add('active',null,array('label'=>'Активен'))
                ->add('amount',null,array('label'=>'Количество'))
                ->add('characteristic',null,array('label'=>'Характеристика'));
    }

    protected function configureFormFields(FormMapper $formmapper)
    {
        $formmapper
                ->add('name',null,array('label'=>'Название'))
                ->add('catalog','entity', array('label'=>'Подкатегория',
                    'class' => 'CatalogBundle:Catalog','required'=>true,
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('p')
                            ->where('p.parent is not null');},
                        ))
                ->add('short_description','textarea',array('label'=>'Краткое описание'))
                ->add('full_desctiption','textarea',array('label'=>'Полное описание'))
                ->add('price',null,array('label'=>'Цена'))
                ->add('imagePath', 'sonata_type_model_list', array('required'=>false,'label'=>'Галерея'), array('link_parameters' => array('context' => 'goods')))
                ->add('youtube','sonata_type_model_list',array('required'=>false,'label'=>'Youtube'), array('link_parameters'=>array('context'=>'youtube')))
                ->add('active',null,array('label'=>'Активен'))
                ->add('amount',null,array('label'=>'Количество'));
    }

    protected function configureListFields(ListMapper $listmapper)
    {
        $listmapper
                ->add('id',null,array('label'=>'ID'))
                ->addIdentifier('name',null,array('label'=>'Название'))
                ->add('catalog','sonata_type_model',array('label'=>'Подкатегория'))
                ->add('price',null,array('label'=>'Цена'))
                ->add('active',null,array('label'=>'Активен'))
                ->add('amount',null,array('label'=>'Количество'));
    }
}