<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Nursultan
 * Date: 4/1/13
 * Time: 12:39 PM
 * To change this template use File | Settings | File Templates.
 */
namespace Nurix\CatalogBundle\Admin;
use Application\Sonata\MediaBundle\Entity\Gallery;
use Doctrine\ORM\EntityRepository;
use Nurix\CatalogBundle\Entity\Goods;
use Nurix\CatalogBundle\Parser\GoogleParser;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Knp\Menu\ItemInterface as MenuItemInterface;

class GoodsAdmin extends Admin
{

    protected function configureShowField(ShowMapper $showmapper)
    {
        $showmapper
            ->add('id', null, array('label' => 'ID'))
            ->add('name', null, array('label' => 'Название'))
            ->add('article', null, array('label' => 'Артикул'))
            ->add('catalog', 'sonata_type_collection', array('label' => 'Подкатегория'))
            ->add('short_description', null, array('label' => 'Краткое описание'))
            ->add('full_desctiption', null, array('label' => 'Полное описание'))
            ->add('price', null, array('label' => 'Цена'))
            ->add('imagePath', 'sonata_media_type', array('label' => 'Галерея', 'provider' => 'sonata.media.provider.image', 'context' => 'default'))
            ->add('youtube', 'sonata_media_type', array('label' => 'Youtube', 'provider' => 'sonata.media.provider.youtube', 'context' => 'youtube'))
            ->add('active', null, array('label' => 'Активен'))
            ->add('amount', null, array('label' => 'Количество'))
            ->add('last_update', 'date', array('label' => 'Последнее обновление'))
            ->add('views', null, array('label' => 'Количество просмотров'))
            ->add('characteristic', null, array('label' => 'Характеристика'));

    }

    protected function configureFormFields(FormMapper $formmapper)
    {
        $formmapper
            ->with('General')
            ->add('name', null, array('label' => 'Название'))
            ->add('article', null, array('label' => 'Артикул'))
            ->add('catalog', 'entity', array('label' => 'Подкатегория',
                'class' => 'CatalogBundle:Catalog', 'required' => true,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->where('p.parent is not null');
                },
            ))
            ->add('short_description', 'textarea', array('label' => 'Краткое описание', 'required' => false))
            ->add('full_desctiption', 'textarea', array('label' => 'Полное описание', 'required' => false))
            ->add('price', null, array('label' => 'Цена'))
            ->add('imagePath', 'sonata_type_model_list', array('required' => false, 'label' => 'Галерея'), array('link_parameters' => array('context' => 'default')))
            ->add('youtube', 'sonata_type_model_list', array('required' => false, 'label' => 'Youtube'), array('link_parameters' => array('providers' => 'sonata.media.provider.youtube', 'context' => 'youtube')))
            ->add('active', null, array('label' => 'Активен'))
            ->add('amount', null, array('label' => 'Количество'))
            ->add('review', 'ckeditor', array('label' => 'Обзор', 'config' => array('width' => '700px', 'resize_enabled' => false, 'resize_minHeight' => '345px', 'resize_minWidth' => '700px', 'resize_maxWidth' => '700px'), 'config_name' => 'my_config'))
            ->add('last_update', 'date', array('label' => 'Последнее обновление'))
            ->add('yandex_url', 'text', array('label' => 'Яндекс', 'required' => false))
            ->end()
            ->with('Characteristic')
            ->add('characteristic', 'sonata_type_collection', array(
                // Prevents the "Delete" option from being displayed
                'type_options' => array('delete' => true), 'required' => false, 'by_reference' => false
            ),
                array(
                'edit' => 'inline',
                'inline' => 'table'
                ),
                array('create' => true),
                array('delete' => true))
            ->end();
    }

    protected function configureListFields(ListMapper $listmapper)
    {
        $listmapper
            ->addIdentifier('id', null, array('label' => 'ID'))
            ->add('name', null, array('editable' => true, 'label' => 'Название', 'template' => 'StrokitCoreBundle:Admin:edit_integer.html.twig'))
            ->add('catalog', 'sonata_type_model', array('editable' => true, 'label' => 'Подкатегория'))
            ->add('price', 'decimal', array('editable' => true, 'label' => 'Цена', 'template' => 'StrokitCoreBundle:Admin:edit_integer.html.twig'))
            ->add('active', 'boolean', array('editable' => true, 'label' => 'Активен'))
            ->add('amount', null, array('editable' => true, 'label' => 'Количество', 'template' => 'StrokitCoreBundle:Admin:edit_integer.html.twig'))
            ->add('last_update', 'date', array('editable' => true, 'label' => 'Последнее обновление'))
            ->add('views', null, array('label' => 'Количество просмотров'))
            ->add('imagePath', 'sonata_type_model_list', array('editable' => true, 'label' => 'Галерея'));
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name', null, array('label' => 'Название'))
            ->add('catalog', null, array('label' => 'Подкатегория'), null, array('expanded' => false, 'multiple' => true))
            ->add('price', null, array('label' => 'Цена'))
            ->add('active', null, array('label' => 'Активен'))
            ->add('last_update', 'doctrine_orm_date_range', array('label' => 'Последнее обновление'))
            ->add('imagePath', null, array('label' => 'Галерея'), null, array('expanded' => false, 'empty_value' => ""));
    }


    public function getTemplate($name)
    {
        switch ($name) {
            case 'list':
                return 'CatalogBundle:Admin:goods_list.html.twig';
                break;
            default:
                return parent::getTemplate($name);
                break;
        }
    }

    public function preUpdate($object)
    {

        $url = $object->getYandexUrl();
        $id = $object->getId();
        $container = $this->getConfigurationPool()->getContainer();
        $yandex_info = $container->get('catalog.product.parser')->isValidYandexUrl($url);

        if (isset($url) && $yandex_info['valid']) {
            $entity_manager = $container->get('doctrine')->getEntityManager();
            $repository = $entity_manager->getRepository("CatalogBundle:Characteristic");
            $repository->deleteByGoodId($id);

            $container
                ->get('catalog.product.parser')
                ->parseYandex($url, $id);
        }

        if ($object->getImageId()==null)
        {
            $this->saveGallery($object);
        }
    }

    public function postPersist($object)
    {
        $this->preUpdate($object);
    }

    public function prePersist($object)
    {
        if ($object->getImageId()==null)
        {
            $this->saveGallery($object);
        }
    }
    /**
     * @param $object
     */
    public function saveGallery($object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        /** @var $parser GoogleParser */
        $parser = $container->get('catalog.product.google_parser');
        /** @var $gallery Gallery */
        $gallery = $parser->saveImages($object->getName(), 'default', 'sonata.media.provider.image', 'goods_big', $container->getParameter('good_image_count'));
        if ($gallery != null)
            $object->setImageId($gallery->getId());
    }


    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('excel');
    }

    protected function configureSideMenu(MenuItemInterface $menu, $action, Admin $childAdmin = null)
    {
        if ($this->getRequest()->get('id')!=null && $this->getSubject()->getActive()!=null)
            $menu->addChild('Просмотр товара',array('route' => 'nurix_goods_get_info','routeParameters'=>array('id' => $this->getRequest()->get('id'))));
    }

}