<?php
/**
 * Created by PhpStorm.
 * User: bupychuk
 * Date: 27.03.14
 * Time: 2:35
 */

namespace Strokit\ConfigBundle\Twig;



use Symfony\Component\DependencyInjection\Container;

class ParameterExtension extends \Twig_Extension {

    /**
     * @var Container
     */
    private $container;

    public function __construct($container)
    {

        $this->container = $container;
    }
    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'get_param';
    }

    public function getFunctions()
    {
        return array(
            'get_param' => new \Twig_Function_Method($this, 'getParam')
        );
    }
    public function getParam($param)
    {
        return $this->container->getParameter($param);
    }
}