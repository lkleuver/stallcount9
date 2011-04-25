<?php

/* division/create.html */
class __TwigTemplate_61c8548bc816d69e1310f812141ca1c8 extends Twig_Template
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
        echo "Stallcount9 - New Division";
    }

    // line 5
    public function block_content($context, array $blocks = array())
    {
        // line 6
        echo "\t<h1>Create new division for ";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['tournament']) ? $context['tournament'] : null), "title", array(), "any", false, 6), "html");
        echo "</h1>
  
  
  \t<form method=\"post\" action=\"?n=division/create/\" name=\"form-division-create\">
  \t\t";
        // line 10
        $this->env->loadTemplate("division/form.html")->display($context);
        // line 11
        echo "  \t\t
  \t\t
\t\t<button name=\"divisionSubmit\" value=\"1\">add</button>
  \t</form>
  
  
  
";
    }

    public function getTemplateName()
    {
        return "division/create.html";
    }
}
