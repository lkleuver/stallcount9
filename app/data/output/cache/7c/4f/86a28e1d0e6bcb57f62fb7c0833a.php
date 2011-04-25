<?php

/* pool/create.html */
class __TwigTemplate_7c4f86a28e1d0e6bcb57f62fb7c0833a extends Twig_Template
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
        echo "New Pool for ";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['stage']) ? $context['stage'] : null), "title", array(), "any", false, 3), "html");
    }

    // line 5
    public function block_content($context, array $blocks = array())
    {
        // line 6
        echo "\t<h1>New Pool for ";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['stage']) ? $context['stage'] : null), "title", array(), "any", false, 6), "html");
        echo "</h1>
  
  \t
  \t<form method=\"post\" action=\"?n=/pool/create\" name=\"form-pool-create\">
  \t\t";
        // line 10
        $this->env->loadTemplate("pool/form.html")->display($context);
        // line 11
        echo "  \t\t
  \t\t
\t\t<button name=\"poolSubmit\" value=\"1\">add</button>
  \t</form>
  
  \t
  
  
  
";
    }

    public function getTemplateName()
    {
        return "pool/create.html";
    }
}
