<?php

/* tournament/detail.html */
class __TwigTemplate_2c21d7b506f55a3011f832c1792e2668 extends Twig_Template
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
        echo "Windmill Windup 2011";
    }

    // line 5
    public function block_content($context, array $blocks = array())
    {
        // line 6
        echo "\t<h1>";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['tournament']) ? $context['tournament'] : null), "title", array(), "any", false, 6), "html");
        echo " detail</h1>

 \t<h2>Divisions</h2>
  \t
  \t";
        // line 10
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context['tournament']) ? $context['tournament'] : null), "Divisions", array(), "any", false, 10));
        foreach ($context['_seq'] as $context['_key'] => $context['division']) {
            // line 11
            echo "\t  \t<div class=\"division\">
\t  \t\t<h2><a class=\"action\"href=\"?n=/division/detail/";
            // line 12
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context['division']) ? $context['division'] : null), "id", array(), "any", false, 12), "html");
            echo "\">";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context['division']) ? $context['division'] : null), "title", array(), "any", false, 12), "html");
            echo "</a></h2>
\t  \t\t
\t  \t\t<a class=\"action\" href=\"?n=/division/detail/";
            // line 14
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context['division']) ? $context['division'] : null), "id", array(), "any", false, 14), "html");
            echo "\">detail</a> <a class=\"action\" href=\"?n=/division/remove/";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context['division']) ? $context['division'] : null), "id", array(), "any", false, 14), "html");
            echo "\">delete</a> <a class=\"action\" href=\"?n=/division/registration/close\">!!close registration</a>
\t  \t</div>
\t ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['division'], $context['_parent'], $context['loop']);
        $context = array_merge($_parent, array_intersect_key($context, $_parent));
        // line 17
        echo "  \t
\t

  
  
  <a class=\"button\" href=\"?n=division/create&tournamentId=";
        // line 22
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['tournament']) ? $context['tournament'] : null), "id", array(), "any", false, 22), "html");
        echo "\"><span>+ Add division</span></a>
    
  
";
    }

    public function getTemplateName()
    {
        return "tournament/detail.html";
    }
}
