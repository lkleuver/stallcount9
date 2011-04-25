<?php

/* team/form.html */
class __TwigTemplate_94bcbd2844bb76cd69dbd43f2d6179df extends Twig_Template
{
    public function display(array $context, array $blocks = array())
    {
        $context = array_merge($this->env->getGlobals(), $context);

        // line 1
        echo "\t<input type=\"hidden\" name=\"divisionId\" value=\"";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['division']) ? $context['division'] : null), "id", array(), "any", false, 1), "html");
        echo "\" />
\t<ul class=\"formlist\">
  \t\t<li>
  \t\t\t<label>Team name</label>
  \t\t\t<input type=\"text\" name=\"teamName\" value=\"";
        // line 5
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['team']) ? $context['team'] : null), "name", array(), "any", false, 5), "html");
        echo "\" />
  \t\t</li>

  \t</ul>";
    }

    public function getTemplateName()
    {
        return "team/form.html";
    }
}
