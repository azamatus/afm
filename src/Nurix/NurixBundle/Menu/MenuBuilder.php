<?php
namespace Nurix\NurixBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

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

    public function mainMenu(Request $request)
    {
        $menu = $this->factory->createItem('root');

        $menu->addChild('Главная', array('route' => 'nurix_homepage'));
        $menu->addChild('Контакты', array('route' => 'nurix_homepage'));
        $menu->addChild('Карта сайта', array('route' => 'nurix_homepage'));
        $menu->setChildrenAttribute('class','ssylka');
        return $menu;
    }

    public function createSidebarMenu(Request $request)
    {
        $menu = $this->factory->createItem('sidebar');

        $menu->addChild('Home', array('route' => 'nurix_homepage'));

        return $menu;
    }
}