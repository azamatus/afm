<?php
namespace Nurix\NurixBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\Request;

class MenuBuilder
{
    private $factory;

    /**
     * @param FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public function createMainMenu(Request $request)
    {
        $menu = $this->factory->createItem('root');

        $menu->addChild('home', array('route' => 'nurix_homepage','label'=>'Главная'));
        $menu->addChild('contacts', array('route' => 'nurix_homepage','label'=>'Контакты'));
        $menu->addChild('sitemap', array('route' => 'nurix_homepage','label'=>'Карта сайта'));
        $menu->setChildrenAttribute('class','main_menu');
        return $menu;
    }

    public function createSidebarMenu(Request $request)
    {
        $menu = $this->factory->createItem('sidebar');
        $menu->setChildrenAttribute('class','sidebar');
        $menu->addChild('Catalog', array('route' => 'nurix_homepage','label'=>'Каталог'))->setLinkAttribute('class','catalog_menu');
        $menu->addChild('Catalog2', array('route' => 'nurix_homepage'));

        return $menu;
    }
}