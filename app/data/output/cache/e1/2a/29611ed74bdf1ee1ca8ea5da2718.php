<?php

/* pool/detail.html */
class __TwigTemplate_e12a29611ed74bdf1ee1ca8ea5da2718 extends Twig_Template
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
        echo "Pool";
    }

    // line 5
    public function block_content($context, array $blocks = array())
    {
        // line 6
        echo "\t<h1>";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['pool']) ? $context['pool'] : null), "Stage", array(), "any", false, 6), "title", array(), "any", false, 6), "html");
        echo " - ";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['pool']) ? $context['pool'] : null), "title", array(), "any", false, 6), "html");
        echo "</h1>
\t
\t<h2>Spots</h2>
\t<ul>
\t";
        // line 10
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context['pool']) ? $context['pool'] : null), "getSpots", array(), "method", false, 10));
        foreach ($context['_seq'] as $context['_key'] => $context['spot']) {
            // line 11
            echo "\t\t<li>";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context['spot']) ? $context['spot'] : null), "rank", array(), "any", false, 11), "html");
            echo " - ";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context['spot']) ? $context['spot'] : null), "title", array(), "any", false, 11), "html");
            echo "</li>
\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['spot'], $context['_parent'], $context['loop']);
        $context = array_merge($_parent, array_intersect_key($context, $_parent));
        // line 13
        echo "\t</ul>
\t
\t<h2>Rounds</h2>
\t<ul class=\"roundlist\">
\t\t";
        // line 17
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context['pool']) ? $context['pool'] : null), "Rounds", array(), "any", false, 17));
        foreach ($context['_seq'] as $context['_key'] => $context['round']) {
            // line 18
            echo "\t\t\t<li>
\t\t\t\t<h3>Round ";
            // line 19
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context['round']) ? $context['round'] : null), "rank", array(), "any", false, 19), "html");
            echo "</h3>
\t\t\t\t<ul class=\"matchlist\">
\t\t\t\t";
            // line 21
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context['round']) ? $context['round'] : null), "Matches", array(), "any", false, 21));
            foreach ($context['_seq'] as $context['_key'] => $context['match']) {
                // line 22
                echo "\t\t\t\t\t<li>";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context['match']) ? $context['match'] : null), "matchName", array(), "any", false, 22), "html");
                echo "</li>
\t\t\t\t";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['match'], $context['_parent'], $context['loop']);
            $context = array_merge($_parent, array_intersect_key($context, $_parent));
            // line 24
            echo "\t\t\t\t</ul>
\t\t\t\t<br />
\t\t\t\t<br />
\t\t\t</li>
\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['round'], $context['_parent'], $context['loop']);
        $context = array_merge($_parent, array_intersect_key($context, $_parent));
        // line 29
        echo "\t</ul>

\t
\t
\t<p>
\t\t<a href=\"?n=/stage/detail/";
        // line 34
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['pool']) ? $context['pool'] : null), "Stage", array(), "any", false, 34), "id", array(), "any", false, 34), "html");
        echo "\">back to stage</a>
\t</p>
  
";
    }

    public function getTemplateName()
    {
        return "pool/detail.html";
    }
}
