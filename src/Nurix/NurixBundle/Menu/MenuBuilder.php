<?php
namespace Nurix\NurixBundle\Menu;

use Doctrine\ORM\EntityManager;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerAware;

class MenuBuilder extends ContainerAware
{
    private $factory;
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @param FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory,$em)
    {
        $this->factory = $factory;
        $this->em = $em;
    }

    /**
     * создает главное меню
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return mixed
     */

    public function createMainMenu(Request $request,\Nurix\CatalogBundle\Menu\MenuBuilder $catalogMenuBuilder)
    {
        $menu = $this->factory->createItem('main');
        $menu->setCurrentUri($request->getRequestUri());
        $menu->setChildrenAttribute('class','nav navbar-nav collapse navbar-collapse');
        $menu->addChild('Home', array('route' => 'nurix_homepage','label'=>'Главный'));
        $menu->addChild('Catalog', array('route' => 'nurix_goods_get_catalog','routeParameters'=>array('cid'=>null),'label'=>'Весь каталог'));

        $catalogMenuBuilder->getCatalogMenu($this->em, $menu);

        $menu->addChild('available', array('route' => 'nurix_catalog_get_available','label'=>'В наличии'));

        $this->getPagesMenu($menu, 'top');
        return $menu;
    }

    /**
     * создает боковое меню
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return mixed
     */

    public function createBottomMenu(Request $request)
    {
        $menu = $this->factory->createItem('bottom');
        $menu->setCurrentUri($request->getRequestUri());

        $menu->setChildrenAttribute('class','unstyled');

        $this->getPagesMenu($menu, 'bottom');
        return $menu;
    }

    private function getPagesMenu(ItemInterface $menu,$position)
    {
        $pagesRepository=$this->em->getRepository('NurixPageBundle:Pages');
        $pages = $pagesRepository->findBy(array('position'=>$position));

        foreach ($pages as $page)
        {
            $menu->addChild($page->getTitle(), array('route' => 'nurix_create_pages', 'routeParameters' => array('url' => $page->getUrl())));
        }

    }
}