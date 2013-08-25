<?php
namespace Nurix\NurixBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerAware;

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
     * создает главное меню
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return mixed
     */

    public function createMainMenu(Request $request)
    {
        $menu = $this->factory->createItem('main_menu');

        $menu->addChild('home', array('route' => 'nurix_homepage','label'=>'Главная'));
        $menu->addChild('contacts', array('route' => 'nurix_create_pages', 'routeParameters' => array('url' => 'contact'),'label'=>'Контакты'));
        $menu->addChild('sitemap', array('route' => 'nurix_create_pages', 'routeParameters' => array('url' => 'sitemap'),'label'=>'Карта сайта'));
        $menu->setChildrenAttribute('class','main_menu');
        return $menu;
    }

    /**
     * создает боковое меню
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return mixed
     */

    public function createInfoSideMenu(Request $request)
    {
        $menu = $this->factory->createItem('sidebar');
        $menu->setCurrentUri($request->getRequestUri());

        $menu->setChildrenAttribute('class','side_menu');

        $menu->addChild('Interesting',array('label'=>'Интересное'))
            ->setAttribute('class','catalog_menu')
            ->setLabelAttribute('class','f20');

        $this->getInterestingMenu($menu);

        return $menu;
    }



    /**
     * создает Карту сайта
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return mixed
     */

    public function createSiteMapMenu(Request $request)
    {
        $menu = $this->factory->createItem('info_sitemap');
        $menu->setCurrentUri($request->getRequestUri());

        $menu->setChildrenAttribute('class','otherLinks');

        $this->getInterestingMenu($menu);

        return $menu;
    }

    /**
     * @param $menu \Knp\Menu\ItemInterface
     */
    public function getInterestingMenu($menu)
    {
        $menu->addChild('Наши новости', array('route' => 'sonata_news_local_inter', 'routeParameters' => array('type' => 'local')));

        $menu->addChild('Мировые новости', array('route' => 'sonata_news_local_inter', 'routeParameters' => array('type' => 'international')));

        $menu->addChild('О магазине', array('route' => 'nurix_create_pages', 'routeParameters' => array('url' => 'about')));

        $menu->addChild('Контакты', array('route' => 'nurix_create_pages', 'routeParameters' => array('url' => 'contact')));

        $menu->addChild('Условия доставки', array('route' => 'nurix_create_pages', 'routeParameters' => array('url' => 'conditions')));

        $menu->addChild('Способы оплаты', array('route' => 'nurix_create_pages', 'routeParameters' => array('url' => 'payment')));

        $menu->addChild('Справка', array('route' => 'nurix_create_pages', 'routeParameters' => array('url' => 'help')));

        $menu->addChild('Отзывы', array('route' => 'sonata_news_home'));

        $menu->addChild('Оптовым покупателям', array('route' => 'nurix_create_pages', 'routeParameters' => array('url' => 'optom')));
    }
}