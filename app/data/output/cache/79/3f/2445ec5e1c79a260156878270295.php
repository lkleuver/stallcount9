<?php

/* pool/edit.html */
class __TwigTemplate_793f2445ec5e1c79a260156878270295 extends Twig_Template
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
        echo "Edit Pool ";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['pool']) ? $context['pool'] : null), "title", array(), "any", false, 3), "html");
        echo " for ";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['stage']) ? $context['stage'] : null), "title", array(), "any", false, 3), "html");
    }

    // line 5
    public function block_content($context, array $blocks = array())
    {
        // line 6
        echo "\t<h1>Edit Pool ";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['pool']) ? $context['pool'] : null), "title", array(), "any", false, 6), "html");
        echo " for ";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['stage']) ? $context['stage'] : null), "title", array(), "any", false, 6), "html");
        echo "</h1>
  
  \t
  \t<form method=\"post\" action=\"?n=/pool/edit/";
        // line 9
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['pool']) ? $context['pool'] : null), "id", array(), "any", false, 9), "html");
        echo "\" name=\"form-pool-edit\">
  \t\t";
        // line 10
        $this->env->loadTemplate("pool/form.html")->display($context);
        // line 11
        echo "
\t\t<button name=\"poolSubmit\" value=\"1\">update</button>
  \t</form>
  
  \t
  
  
  
";
    }

    public function getTemplateName()
    {
        return "pool/edit.html";
    }
}
