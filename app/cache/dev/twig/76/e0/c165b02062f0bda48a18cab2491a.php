<?php

/* ::base.html.twig */
class __TwigTemplate_76e0c165b02062f0bda48a18cab2491a extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'stylesheets' => array($this, 'block_stylesheets'),
            'body' => array($this, 'block_body'),
            'javascripts' => array($this, 'block_javascripts'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html>
<head>
    <meta charset=\"UTF-8\"/>
    <title>";
        // line 5
        $this->displayBlock('title', $context, $blocks);
        echo "</title>
    <link href=\"";
        // line 6
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/nurix/css/mainframe.css"), "html", null, true);
        echo " \" type=\"text/css\" rel=\"stylesheet\"/>
    ";
        // line 7
        $this->displayBlock('stylesheets', $context, $blocks);
        // line 8
        echo "    <link rel=\"icon\" type=\"image/x-icon\" href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("favicon.ico"), "html", null, true);
        echo "\"/>
</head>
<body>
<div class=\"mainframe\">
    <header>
        Header
        <h1>Nurix</h1>
    </header>
    <div class=\"leftColumn\">
        <div class=\"catalog\">
            <h4>Каталог</h4>
            Аудиотехника<br>
            Видеотехника<br>
            Оргтехника<br>
            Ноутбуки<br>
            Нетбуки<br>
            ...<br>
        </div>
        <div class=\"interesting\">
            <h4>Интересное</h4>
            Наши новости<br>
            Мировые новости<br>
            О нас<br>
            ...<br>
        </div>
        <div class=\"feedbacks\">
            feedbacks
        </div>
    </div>
    <div class=\"content\">
        ";
        // line 38
        $this->displayBlock('body', $context, $blocks);
        // line 39
        echo "    </div>
    <footer>
        Footer<br>

        <h3>Nurix.kg</h3>
    </footer>
    \\
</div>


";
        // line 49
        $this->displayBlock('javascripts', $context, $blocks);
        echo "\\

</body>
</html>
";
    }

    // line 5
    public function block_title($context, array $blocks = array())
    {
        echo "Welcome!";
    }

    // line 7
    public function block_stylesheets($context, array $blocks = array())
    {
    }

    // line 38
    public function block_body($context, array $blocks = array())
    {
    }

    // line 49
    public function block_javascripts($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return "::base.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  110 => 49,  105 => 38,  100 => 7,  94 => 5,  85 => 49,  73 => 39,  71 => 38,  35 => 7,  31 => 6,  27 => 5,  21 => 1,  49 => 10,  45 => 9,  41 => 8,  37 => 8,  33 => 6,  29 => 4,  26 => 3,);
    }
}
