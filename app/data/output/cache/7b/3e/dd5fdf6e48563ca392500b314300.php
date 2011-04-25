<?php

/* home.html */
class __TwigTemplate_7b3edd5fdf6e48563ca392500b314300 extends Twig_Template
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
        echo "Stallcount9 - home";
    }

    // line 5
    public function block_content($context, array $blocks = array())
    {
        // line 6
        echo "\t<h1>Stallcount9 tournament management</h1>
  \t
  \t<h2>Open tournaments</h2>
\t<ul>
\t\t";
        // line 10
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context['tournamentList']) ? $context['tournamentList'] : null));
        foreach ($context['_seq'] as $context['_key'] => $context['tournament']) {
            // line 11
            echo "\t\t\t";
            if (($this->getAttribute((isset($context['tournament']) ? $context['tournament'] : null), "state", array(), "any", false, 11) == 1)) {
                // line 12
                echo "\t\t\t\t<li><a href=\"?n=/tournament/detail/";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context['tournament']) ? $context['tournament'] : null), "id", array(), "any", false, 12), "html");
                echo "\">";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context['tournament']) ? $context['tournament'] : null), "title", array(), "any", false, 12), "html");
                echo "</a> <a class=\"action\" href=\"?n=/tournament/remove/";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context['tournament']) ? $context['tournament'] : null), "id", array(), "any", false, 12), "html");
                echo "\">remove</a></li>
\t\t\t";
            }
            // line 14
            echo "\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['tournament'], $context['_parent'], $context['loop']);
        $context = array_merge($_parent, array_intersect_key($context, $_parent));
        // line 15
        echo "\t</ul> \t

\t<br /><br />
  \t
  \t<h2>Active tournaments</h2>
\t
\t<ul>
\t\t";
        // line 22
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context['tournamentList']) ? $context['tournamentList'] : null));
        foreach ($context['_seq'] as $context['_key'] => $context['tournament']) {
            // line 23
            echo "\t\t\t";
            if (($this->getAttribute((isset($context['tournament']) ? $context['tournament'] : null), "state", array(), "any", false, 23) == 2)) {
                // line 24
                echo "\t\t\t\t<li><a href=\"?n=/tournament/detail/";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context['tournament']) ? $context['tournament'] : null), "id", array(), "any", false, 24), "html");
                echo "\">";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context['tournament']) ? $context['tournament'] : null), "title", array(), "any", false, 24), "html");
                echo "</a></li>
\t\t\t";
            }
            // line 26
            echo "\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['tournament'], $context['_parent'], $context['loop']);
        $context = array_merge($_parent, array_intersect_key($context, $_parent));
        // line 27
        echo "\t</ul> \t
\t
\t<br /><br />

\t<h2>Closed tournaments</h2>
  \t<ul>
\t\t";
        // line 33
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context['tournamentList']) ? $context['tournamentList'] : null));
        foreach ($context['_seq'] as $context['_key'] => $context['tournament']) {
            // line 34
            echo "\t\t\t";
            if (($this->getAttribute((isset($context['tournament']) ? $context['tournament'] : null), "state", array(), "any", false, 34) == 3)) {
                // line 35
                echo "\t\t\t\t<li><a href=\"?n=/tournament/detail/";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context['tournament']) ? $context['tournament'] : null), "id", array(), "any", false, 35), "html");
                echo "\">";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context['tournament']) ? $context['tournament'] : null), "title", array(), "any", false, 35), "html");
                echo "</a></li>
\t\t\t";
            }
            // line 37
            echo "\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['tournament'], $context['_parent'], $context['loop']);
        $context = array_merge($_parent, array_intersect_key($context, $_parent));
        // line 38
        echo "  \t</ul>
\t
  \t<a class=\"button\" href=\"?n=/tournament/create\"><span>New tournament</span></a>
  \t

  
";
    }

    public function getTemplateName()
    {
        return "home.html";
    }
}
