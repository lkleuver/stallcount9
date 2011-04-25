<?php

/* stage/form.html */
class __TwigTemplate_0d34ac78979aad637d42371495be4ba7 extends Twig_Template
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
  \t\t\t<label>Stage name</label>
  \t\t\t<input type=\"text\" name=\"stageTitle\" value=\"";
        // line 5
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['stage']) ? $context['stage'] : null), "title", array(), "any", false, 5), "html");
        echo "\" />
  \t\t</li>

  \t</ul>";
    }

    public function getTemplateName()
    {
        return "stage/form.html";
    }
}
