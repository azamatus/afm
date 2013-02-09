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
        $menu->addChild('contacts', array('route' => 'nurix_default', 'routeParameters' => array('name' => 'Nurlan'),'label'=>'Контакты'));
        $menu->addChild('sitemap', array('route' => 'nurix_default', 'routeParameters' => array('name' => 'Nurlan'),'label'=>'Карта сайта'));
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
        $menu->setChildrenAttribute('class','side_menu');
        $menu->addChild('Interesting',array('label'=>'Интересное'))
            ->setAttribute('class','catalog_menu')
            ->setLabelAttribute('class','f20');
        $menu->addChild('Наши новости',array('route'=>'article_all_news','routeParameters'=>array('type'=>'local')));
        $menu->addChild('Мировые новости',array('route'=>'article_all_news','routeParameters'=>array('type'=>'global')));

        $menu->addChild('О магазине',array('route'=>'article_all_news'));

        $menu->addChild('Контакты',array('route'=>'article_all_news'));

        $menu->addChild('Условия доставки',array('route'=>'article_all_news'));

        $menu->addChild('Способы оплаты',array('route'=>'article_all_news'));

        $menu->addChild('Справка',array('route'=>'article_all_news'));

        $menu->addChild('Отзывы',array('route'=>'article_all_news'));

        $menu->addChild('Оптовым покупателям',array('route'=>'article_all_news'));

        return $menu;
    }
}