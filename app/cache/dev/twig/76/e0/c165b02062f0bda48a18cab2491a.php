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
        <img src=\"";
        // line 13
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/nurix/images/header.jpg"), "html", null, true);
        echo "\" alt=\"header\"/>

        <div id=\"info\" class=\"text\">
            <a href=\"http//:www.nurix.kg\">Главная</a> |
            <a href=\"http//:www.nurix.kg\">Контакты</a> |
            <a href=\"http//:www.nurix.kg\">Карта сайта</a>
        </div>
        <script language=\"javascript\">
            function del()
            {
               document.forma.poisk.value='';
            }
            function dob()
            {
                if(document.forma.poisk.value=='')
                {document.forma.poisk.value='Поиск...';}
            }
        </script>
        <form id=\"form\" name=\"forma\">
            <input type=\"text\" value=\"Поиск...\" name=\"poisk\" onmouseover=\"del();\" onmouseout=\"dob();\">
        </form>
        <div id=\"logo\">
            <img src=\"";
        // line 35
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/nurix/images/logo.jpg"), "html", null, true);
        echo "\" alt=\"header\"/>
        </div>
        <div id=\"contacts\">
            <span style=\"color: gray; font-size: 14px; font-family: arial;\">+996</span>
            <span style=\"font-size: 18px; font-family: arial;\">555</span>
            <span style=\"font-size: 24px; font-family: arial;\">231</span>
            <span style=\"font-size: 24px; font-family: arial;\">654</span><br>
            <span style=\"color: gray; font-size: 14px; font-family: arial;\">+996</span>
            <span style=\"font-size: 18px; font-family: arial;\">312</span>
            <span style=\"font-size: 24px; font-family: arial;\">987</span>
            <span style=\"font-size: 24px; font-family: arial;\">159</span>
        </div>
        <div align=\"left\" id=\"times\">
            <span style=\"color:gray; font-family: arial; font-size: 12px;\">Время работы:</span><br>
            <span style=\"color:gray; font-family: arial; font-size: 12px;\">c</span>
            <span style=\"color:gray; font-family: arial; font-size: 20px;\">9:00</span>
            <span style=\"color:gray; font-family: arial; font-size: 12px;\">до</span>
            <span style=\"color:gray; font-family: arial; font-size: 20px;\">18:00</span><br>
            <img src=\"";
        // line 53
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/nurix/images/days.jpg"), "html", null, true);
        echo "\" alt=\"header\"/>
        </div>
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
        // line 78
        $this->displayBlock('body', $context, $blocks);
        // line 79
        echo "    </div>
    <footer>
        Footer<br>

        <h3>Nurix.kg</h3>
    </footer>
    \\
</div>


";
        // line 89
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

    // line 78
    public function block_body($context, array $blocks = array())
    {
    }

    // line 89
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
        return array (  159 => 89,  154 => 78,  149 => 7,  143 => 5,  134 => 89,  122 => 79,  120 => 78,  92 => 53,  71 => 35,  46 => 13,  37 => 8,  35 => 7,  31 => 6,  27 => 5,  21 => 1,);
    }
}
