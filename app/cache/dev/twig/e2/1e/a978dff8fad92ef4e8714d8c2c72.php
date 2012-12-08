<?php

/* NurixBundle:Home:home.html.twig */
class __TwigTemplate_e21ea978dff8fad92ef4e8714d8c2c72 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("::base.html.twig");

        $this->blocks = array(
            'body' => array($this, 'block_body'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "::base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_body($context, array $blocks = array())
    {
        // line 4
        echo "    Main<br><br>
    <h3>Топ продаж</h3><br>
    <img src=\"";
        // line 6
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/nurix/images/1.jpg"), "html", null, true);
        echo "\" width=\"200\" height=\"250\" alt=\"main\"/>
    <img src=\"";
        // line 7
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/nurix/images/4.jpg"), "html", null, true);
        echo "\" width=\"200\" height=\"250\" alt=\"main\" />
    <img src=\"";
        // line 8
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/nurix/images/2.jpg"), "html", null, true);
        echo "\" width=\"200\" height=\"250\" alt=\"main\" />
    <img src=\"";
        // line 9
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/nurix/images/3.jpg"), "html", null, true);
        echo "\" width=\"240\" height=\"250\" alt=\"main\" />
    <img src=\"";
        // line 10
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/nurix/images/facebook.jpg"), "html", null, true);
        echo "\" width=\"210\" height=\"250\" alt=\"main\" />

";
    }

    public function getTemplateName()
    {
        return "NurixBundle:Home:home.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  49 => 10,  45 => 9,  41 => 8,  37 => 7,  33 => 6,  29 => 4,  26 => 3,);
    }
}
