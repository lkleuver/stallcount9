<?php

/* stage/create.html */
class __TwigTemplate_3a5f0766ce0148b674f47717e6d7ed64 extends Twig_Template
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
        echo "New stage for Open Division";
    }

    // line 5
    public function block_content($context, array $blocks = array())
    {
        // line 6
        echo "\t<h1>New stage for ";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['division']) ? $context['division'] : null), "title", array(), "any", false, 6), "html");
        echo "</h1>
  
  \t
  \t<form method=\"post\" action=\"?n=/stage/create\" name=\"form-stage-create\">
  \t\t";
        // line 10
        $this->env->loadTemplate("stage/form.html")->display($context);
        // line 11
        echo "  \t\t
  \t\t
\t\t<button name=\"stageSubmit\" value=\"1\">add</button>
  \t</form>
  
  \t
  
  
  
";
    }

    public function getTemplateName()
    {
        return "stage/create.html";
    }
}
