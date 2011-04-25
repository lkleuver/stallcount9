<?php

/* division/form.html */
class __TwigTemplate_c59097b74511c0db9905980a6cb39de5 extends Twig_Template
{
    public function display(array $context, array $blocks = array())
    {
        $context = array_merge($this->env->getGlobals(), $context);

        // line 1
        echo "\t<input type=\"hidden\" name=\"tournamentId\" value=\"";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['tournament']) ? $context['tournament'] : null), "id", array(), "any", false, 1), "html");
        echo "\" />
\t<ul class=\"formlist\">
  \t\t<li>
  \t\t\t<label>Division name</label>
  \t\t\t<input type=\"text\" name=\"divisionTitle\" value=\"";
        // line 5
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['division']) ? $context['division'] : null), "title", array(), "any", false, 5), "html");
        echo "\" />
  \t\t</li>

  \t</ul>";
    }

    public function getTemplateName()
    {
        return "division/form.html";
    }
}
