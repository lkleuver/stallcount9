<?php

/* index.html */
class __TwigTemplate_0c4baad38582a1f39c1633cac85e41b8 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'header' => array($this, 'block_header'),
            'content' => array($this, 'block_content'),
        );
    }

    public function display(array $context, array $blocks = array())
    {
        $context = array_merge($this->env->getGlobals(), $context);

        // line 1
        echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"nl\" lang=\"nl\">
<head>
\t<meta http-equiv=\"content-language\" content=\"nl\" />
 \t<meta http-equiv=\"Content-Type\" content=\"text/html;charset=utf-8\" />
\t<title>";
        // line 6
        $this->displayBlock('title', $context, $blocks);
        echo "</title>
\t<link rel=\"shortcut icon\" href=\"/favicon.ico\" type=\"image/x-icon\" />
\t<link rel=\"stylesheet\" type=\"text/css\" href=\"skin/default/style/master.css\"  />
\t";
        // line 9
        $this->displayBlock('header', $context, $blocks);
        // line 10
        echo "</head>
<body>
\t
\t<div id=\"stallcount9\">
\t\t<div id=\"sc9-menu\" class=\"menubar\"><a href=\"index.php\">home</a></div>
\t\t";
        // line 15
        $this->displayBlock('content', $context, $blocks);
        // line 19
        echo "\t
\t</div>
</body>
</html>";
    }

    // line 6
    public function block_title($context, array $blocks = array())
    {
        echo "Stallcount9";
    }

    // line 9
    public function block_header($context, array $blocks = array())
    {
    }

    // line 15
    public function block_content($context, array $blocks = array())
    {
        // line 16
        echo "\t\t\t<h1>Hello world</h1>
\t\t\t<p> twig test </p>
\t\t";
    }

    public function getTemplateName()
    {
        return "index.html";
    }
}
