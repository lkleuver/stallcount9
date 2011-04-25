<?php

/* stage/moves.html */
class __TwigTemplate_7ee6b07836fd5dce656ce03205aa69de extends Twig_Template
{
    protected $parent;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'header' => array($this, 'block_header'),
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
        echo "Edit Moves";
    }

    // line 4
    public function block_header($context, array $blocks = array())
    {
        // line 5
        echo "\t<script type=\"text/javascript\" src=\"app/js/jquery.js\"></script>
\t<script type=\"text/javascript\" src=\"app/js/moves.js\"></script>
";
    }

    // line 8
    public function block_content($context, array $blocks = array())
    {
        // line 9
        echo "\t<h1>";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['stage']) ? $context['stage'] : null), "Division", array(), "any", false, 9), "title", array(), "any", false, 9), "html");
        echo " - ";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['stage']) ? $context['stage'] : null), "title", array(), "any", false, 9), "html");
        echo " - Moves</h1>
\t
\t<span class=\"hidden\" id=\"stageId\">";
        // line 11
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['stage']) ? $context['stage'] : null), "id", array(), "any", false, 11), "html");
        echo "</span>
\t
\t<div style=\"width: 420px; overflow: hidden; float: left; margin-right: 52px;\" id=\"sourceMoves\">
\t\t<h2>Seed stage</h2>
\t\t
\t\t";
        // line 16
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context['seedStage']) ? $context['seedStage'] : null), "Pools", array(), "any", false, 16));
        foreach ($context['_seq'] as $context['_key'] => $context['pool']) {
            // line 17
            echo "\t\t\t<h3>";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context['pool']) ? $context['pool'] : null), "title", array(), "any", false, 17), "html");
            echo " ";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context['pool']) ? $context['pool'] : null), "id", array(), "any", false, 17), "html");
            echo "</h3>
\t\t\t<ul class=\"moves\">
\t\t\t\t";
            // line 19
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context['pool']) ? $context['pool'] : null), "getSpots", array(), "method", false, 19));
            foreach ($context['_seq'] as $context['_key'] => $context['spot']) {
                // line 20
                echo "\t\t\t\t\t<li id=\"pool-";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context['pool']) ? $context['pool'] : null), "id", array(), "any", false, 20), "html");
                echo "-";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context['spot']) ? $context['spot'] : null), "rank", array(), "any", false, 20), "html");
                echo "\">";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context['spot']) ? $context['spot'] : null), "rank", array(), "any", false, 20), "html");
                echo " - ";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context['spot']) ? $context['spot'] : null), "title", array(), "any", false, 20), "html");
                echo " ";
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['spot']) ? $context['spot'] : null), "destinationMove", array(), "any", false, 20), "pool_id", array(), "any", false, 20), "html");
                echo " ";
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['spot']) ? $context['spot'] : null), "destinationMove", array(), "any", false, 20), "destinationSpot", array(), "any", false, 20), "html");
                echo "</li>
\t\t\t\t";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['spot'], $context['_parent'], $context['loop']);
            $context = array_merge($_parent, array_intersect_key($context, $_parent));
            // line 22
            echo "\t\t\t</ul>
\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['pool'], $context['_parent'], $context['loop']);
        $context = array_merge($_parent, array_intersect_key($context, $_parent));
        // line 24
        echo "\t</div>
\t
\t
\t<div style=\"width: 420px; overflow: hidden; float: left;\" id=\"destinationMoves\">
\t\t<h2>Destination</h2>
\t\t
\t\t";
        // line 30
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context['stage']) ? $context['stage'] : null), "Pools", array(), "any", false, 30));
        foreach ($context['_seq'] as $context['_key'] => $context['pool']) {
            // line 31
            echo "\t\t\t<h3>";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context['pool']) ? $context['pool'] : null), "title", array(), "any", false, 31), "html");
            echo " ";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context['pool']) ? $context['pool'] : null), "id", array(), "any", false, 31), "html");
            echo "</h3>
\t\t\t<ul class=\"moves\">
\t\t\t\t";
            // line 33
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context['pool']) ? $context['pool'] : null), "getSpots", array(), "method", false, 33));
            foreach ($context['_seq'] as $context['_key'] => $context['spot']) {
                // line 34
                echo "\t\t\t\t\t<li id=\"pool-";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context['pool']) ? $context['pool'] : null), "id", array(), "any", false, 34), "html");
                echo "-";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context['spot']) ? $context['spot'] : null), "rank", array(), "any", false, 34), "html");
                echo "\">";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context['spot']) ? $context['spot'] : null), "rank", array(), "any", false, 34), "html");
                echo " - ";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context['spot']) ? $context['spot'] : null), "title", array(), "any", false, 34), "html");
                echo " ";
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['spot']) ? $context['spot'] : null), "sourceMove", array(), "any", false, 34), "source_pool_id", array(), "any", false, 34), "html");
                echo " ";
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['spot']) ? $context['spot'] : null), "sourceMove", array(), "any", false, 34), "sourceSpot", array(), "any", false, 34), "html");
                echo "</li>
\t\t\t\t";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['spot'], $context['_parent'], $context['loop']);
            $context = array_merge($_parent, array_intersect_key($context, $_parent));
            // line 36
            echo "\t\t\t</ul>
\t\t\t
\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['pool'], $context['_parent'], $context['loop']);
        $context = array_merge($_parent, array_intersect_key($context, $_parent));
        // line 39
        echo "\t</div>
\t
\t
\t<p>
\t\t<a href=\"?n=/stage/performmoves/";
        // line 43
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['stage']) ? $context['stage'] : null), "id", array(), "any", false, 43), "html");
        echo "\">Perform moves</a>
\t</p>
\t
\t<p>
\t\t<a href=\"?n=/stage/detail/";
        // line 47
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['stage']) ? $context['stage'] : null), "id", array(), "any", false, 47), "html");
        echo "\">Back to stage</a>
\t</p>
\t  
";
    }

    public function getTemplateName()
    {
        return "stage/moves.html";
    }
}
