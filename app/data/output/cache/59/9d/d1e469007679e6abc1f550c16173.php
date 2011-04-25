<?php

/* tournament/create.html */
class __TwigTemplate_599dd1e469007679e6abc1f550c16173 extends Twig_Template
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
        echo "Stallcount9 - New tournament";
    }

    // line 5
    public function block_content($context, array $blocks = array())
    {
        // line 6
        echo "\t<h1>Create new tournament</h1>
  
  
  \t<form method=\"post\" action=\"?n=tournament/create/\" name=\"form-tournament-create\">
  \t\t";
        // line 10
        $this->env->loadTemplate("tournament/form.html")->display($context);
        // line 11
        echo "  \t\t
  \t\t
\t\t<button name=\"tournamentsubmit\" value=\"1\">Next step</button>
  \t</form>
  
  
  
";
    }

    public function getTemplateName()
    {
        return "tournament/create.html";
    }
}
