<?php

/* stage/detail.html */
class __TwigTemplate_aed7a30e0cda86a32a0e56b05bbfab41 extends Twig_Template
{
    protected $parent;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'content' => array($this, 'block_content'),
        );
    }

    public function getParent(array $context)
    {
        if (null === $this->parent) {
            $this->parent = $this->env->loadTemplate("index.html");
        }

        return $this->parent;
    }

    public function display(array $context, array $blocks = array())
    {
        $context = array_merge($this->env->getGlobals(), $context);

        $this->getParent($context)->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_title($context, array $blocks = array())
    {
        echo "Open Division - Swissdraw";
    }

    // line 5
    public function block_content($context, array $blocks = array())
    {
        // line 6
        echo "\t<h1>";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['stage']) ? $context['stage'] : null), "Division", array(), "any", false, 6), "title", array(), "any", false, 6), "html");
        echo " - ";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['stage']) ? $context['stage'] : null), "title", array(), "any", false, 6), "html");
        echo "</h1>
\t
\t
\t<h2>Pools</h2>
\t
\t<ul class=\"itemlist\">
\t\t";
        // line 12
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context['stage']) ? $context['stage'] : null), "Pools", array(), "any", false, 12));
        foreach ($context['_seq'] as $context['_key'] => $context['pool']) {
            // line 13
            echo "\t\t\t<li><a href=\"?n=/pool/detail/";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context['pool']) ? $context['pool'] : null), "id", array(), "any", false, 13), "html");
            echo "\">";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context['pool']) ? $context['pool'] : null), "title", array(), "any", false, 13), "html");
            echo "</a> <a class=\"action\" href=\"?n=/pool/edit/";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context['pool']) ? $context['pool'] : null), "id", array(), "any", false, 13), "html");
            echo "\">edit</a> <a class=\"action\" href=\"?n=/pool/remove/";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context['pool']) ? $context['pool'] : null), "id", array(), "any", false, 13), "html");
            echo "\">delete</a> ";
            if ($this->getAttribute((isset($context['pool']) ? $context['pool'] : null), "isFinished", array(), "method", false, 13)) {
                echo "(finished)";
            }
            echo " (";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context['pool']) ? $context['pool'] : null), "spots", array(), "any", false, 13), "html");
            echo ")</li>
\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['pool'], $context['_parent'], $context['loop']);
        $context = array_merge($_parent, array_intersect_key($context, $_parent));
        // line 15
        echo "\t</ul>
\t<a class=\"action\" href=\"?n=/pool/create&stageId=";
        // line 16
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['stage']) ? $context['stage'] : null), "id", array(), "any", false, 16), "html");
        echo "\">+ Add pool</a>
\t
\t<p>
\t<a class=\"action\" href=\"?n=/stage/matchups/";
        // line 19
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['stage']) ? $context['stage'] : null), "id", array(), "any", false, 19), "html");
        echo "\">+ Create Matchups</a>
\t</p>
\t
\t<p>
\t\t<a class=\"action\" href=\"?n=/stage/moves/";
        // line 23
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['stage']) ? $context['stage'] : null), "id", array(), "any", false, 23), "html");
        echo "\">Edit moves</a>
\t</p>
\t
\t
\t";
        // line 27
        if ($this->getAttribute((isset($context['stage']) ? $context['stage'] : null), "isFinished", array(), "method", false, 27)) {
            // line 28
            echo "\t\t<p>
\t\t\t<a href=\"?n=/division/nextstage/";
            // line 29
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['stage']) ? $context['stage'] : null), "Division", array(), "any", false, 29), "id", array(), "any", false, 29), "html");
            echo "/?seedingStageId=";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context['stage']) ? $context['stage'] : null), "id", array(), "any", false, 29), "html");
            echo "\">Seed next stage</a>
\t\t</p>
\t";
        }
        // line 32
        echo "\t<p>
\t\t<a href=\"?n=/division/detail/";
        // line 33
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['stage']) ? $context['stage'] : null), "Division", array(), "any", false, 33), "id", array(), "any", false, 33), "html");
        echo "\">back to division</a>
\t</p>
  
";
    }

    public function getTemplateName()
    {
        return "stage/detail.html";
    }
}
