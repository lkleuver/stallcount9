<?php

/* team/create.html */
class __TwigTemplate_d66a234a9447aafabbe49854cb9ffdeb extends Twig_Template
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
        echo "New Team foor ";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['division']) ? $context['division'] : null), "title", array(), "any", false, 3), "html");
    }

    // line 5
    public function block_content($context, array $blocks = array())
    {
        // line 6
        echo "\t<h1>New Team for ";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['division']) ? $context['division'] : null), "title", array(), "any", false, 6), "html");
        echo "</h1>
  
  \t
  \t<form method=\"post\" action=\"?n=/team/create\" name=\"form-team-create\">
  \t\t";
        // line 10
        $this->env->loadTemplate("team/form.html")->display($context);
        // line 11
        echo "  \t\t
  \t\t
\t\t<button name=\"teamSubmit\" value=\"1\">add</button>
  \t</form>
  
  \t
  
  
  
";
    }

    public function getTemplateName()
    {
        return "team/create.html";
    }
}
