<?php

/* division/detail.html */
class __TwigTemplate_4fa9c8825863007f9420599ddad6fcf9 extends Twig_Template
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
        echo "Stallcount9 - Open Division";
    }

    // line 5
    public function block_content($context, array $blocks = array())
    {
        // line 6
        echo "\t<h1>";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['division']) ? $context['division'] : null), "Tournament", array(), "any", false, 6), "title", array(), "any", false, 6), "html");
        echo " ";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['division']) ? $context['division'] : null), "title", array(), "any", false, 6), "html");
        echo "</h1>
\t<h2>Stages</h2>
\t
\t
\t<ul class=\"itemlist\">
\t\t";
        // line 11
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context['division']) ? $context['division'] : null), "Stages", array(), "any", false, 11));
        foreach ($context['_seq'] as $context['_key'] => $context['stage']) {
            // line 12
            echo "\t\t\t<li><a href=\"?n=/stage/detail/";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context['stage']) ? $context['stage'] : null), "id", array(), "any", false, 12), "html");
            echo "\">";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context['stage']) ? $context['stage'] : null), "title", array(), "any", false, 12), "html");
            echo "</a> <a class=\"action\" href=\"?n=/stage/remove/";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context['stage']) ? $context['stage'] : null), "id", array(), "any", false, 12), "html");
            echo "\">delete</a></li>
\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['stage'], $context['_parent'], $context['loop']);
        $context = array_merge($_parent, array_intersect_key($context, $_parent));
        // line 14
        echo "\t</ul>
\t<a class=\"action\" href=\"?n=/stage/create&divisionId=";
        // line 15
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['division']) ? $context['division'] : null), "id", array(), "any", false, 15), "html");
        echo "\">+ Add stage</a>
\t
\t<br /><br />
\t
\t<h2>Teams</h2>
  \t<ul class=\"itemlist\">
\t\t";
        // line 21
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context['division']) ? $context['division'] : null), "Teams", array(), "any", false, 21));
        foreach ($context['_seq'] as $context['_key'] => $context['team']) {
            // line 22
            echo "\t\t\t<li><a href=\"?n=/team/detail/";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context['team']) ? $context['team'] : null), "id", array(), "any", false, 22), "html");
            echo "\">";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context['team']) ? $context['team'] : null), "name", array(), "any", false, 22), "html");
            echo "</a> <a class=\"action\" href=\"?n=/team/edit/";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context['team']) ? $context['team'] : null), "id", array(), "any", false, 22), "html");
            echo "\">edit</a> <a class=\"action\" href=\"?n=/team/remove/";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context['team']) ? $context['team'] : null), "id", array(), "any", false, 22), "html");
            echo "\">delete</a></li>
\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['team'], $context['_parent'], $context['loop']);
        $context = array_merge($_parent, array_intersect_key($context, $_parent));
        // line 24
        echo " \t</ul>
  \t\t
 \t<a class=\"action\" href=\"?n=/team/create&divisionId=";
        // line 26
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['division']) ? $context['division'] : null), "id", array(), "any", false, 26), "html");
        echo "\">+ Add team</a><br /><br />
 \t<a class=\"action\" href=\"?n=/division/schedule/";
        // line 27
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['division']) ? $context['division'] : null), "id", array(), "any", false, 27), "html");
        echo "\">+ Schedule</a> 
  
";
    }

    public function getTemplateName()
    {
        return "division/detail.html";
    }
}
