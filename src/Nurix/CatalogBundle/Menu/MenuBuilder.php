<?php
namespace Nurix\CatalogBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerAware;
use Nurix\CatalogBundle\Model\CatalogModel;
use Nurix\CatalogBundle\Entity;

class MenuBuilder extends ContainerAware
{
    private $factory;

    /**
     * @param FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    /**
     * создает боковое меню каталога
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return mixed
     */

    public function createCatalogSideMenu(Request $request, CatalogModel $cm)
    {

        $menu = $this->factory->createItem('catalog_sidebar');
        $menu->setCurrentUri($request->getRequestUri());
        $menu->setChildrenAttribute('class','side_menu');
        $menu->addChild('Catalog', array('route' => 'nurix_goods_get_catalog','routeParameters'=>array('cid'=>null),'label'=>'Каталог'))
            ->setAttribute('class','catalog_menu')
            ->setLinkAttribute('class','f20')
            ->setExtra('currentClass','active');


        $catalog = $cm->getAll(array('active'=>1, 'parent'=>null));

        foreach ($catalog as $category)
        {
            $cat=$menu->addChild($category->getCname(),array('route'=>'nurix_goods_get_catalog','routeParameters'=>array('cid'=>$category->getId())))->setDisplayChildren(true);
            foreach ($category->getChildren() as $child)
            {
                if ($child->getActive())
                    $cat->addChild($child->getCname(),array('route'=>'nurix_goods_get_catalog','routeParameters'=>array('cid'=>$child->getId())));
            }
        }
        return $menu;
    }
}