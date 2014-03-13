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

    public function createCatalogSideMenu(Request $request,$em)
    {
        $menu = $this->factory->createItem('catalog_sidebar');
        $menu->setCurrentUri($request->getRequestUri());
        $menu->setChildrenAttribute('class','nav');
        $menu->addChild('Home', array('route' => 'nurix_homepage','label'=>'Home'))
            ->setExtra('icon',true);
        $menu->addChild('Catalog', array('route' => 'nurix_goods_get_catalog','routeParameters'=>array('cid'=>null),'label'=>'Каталог'));

        $this->getCatalogMenu($em, $menu);

        $menu->addChild('available', array('route' => 'nurix_catalog_get_available','label'=>'В наличии'));
        $menu->addChild('pages.howToOrder', array('route' => 'nurix_create_pages', 'routeParameters' => array('url' => 'howtoorder')));
        $menu->addChild('pages.conditions', array('route' => 'nurix_create_pages', 'routeParameters' => array('url' => 'conditions')));
        $menu->addChild('pages.contact', array('route' => 'nurix_create_pages', 'routeParameters' => array('url' => 'contact')));
        return $menu;
    }
    /**
     * создает боковое меню каталога
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return mixed
     */

    public function createSiteMapMenu(Request $request,$em)
    {
        $menu = $this->factory->createItem('catalog_sitemap');
        $menu->setCurrentUri($request->getRequestUri());
        $menu->setChildrenAttribute('class','siteMapLinks');

        $this->getCatalogMenu($em, $menu);
        return $menu;
    }

    /**
     * @param $em
     * @param $menu
     */
    private function getCatalogMenu($em, $menu)
    {
        $cm = $em->getRepository("CatalogBundle:Catalog");

        $catalog = $cm->getAll(array('active' => 1, 'parent' => null));

        foreach ($catalog as $category) {
            $cat = $menu->addChild($category->getCname(), array('route' => 'nurix_goods_get_catalog', 'routeParameters' => array('cid' => $category->getId())))->setDisplayChildren(true);
            foreach ($category->getChildren() as $child) {
                if ($child->getActive())
                    $cat->addChild($child->getCname(), array('route' => 'nurix_goods_get_catalog', 'routeParameters' => array('cid' => $child->getId())));
            }
        }
    }
}