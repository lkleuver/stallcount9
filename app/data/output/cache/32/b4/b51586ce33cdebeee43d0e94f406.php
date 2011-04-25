<?php

/* tournament/form.html */
class __TwigTemplate_32b4b51586ce33cdebeee43d0e94f406 extends Twig_Template
{
    public function display(array $context, array $blocks = array())
    {
        $context = array_merge($this->env->getGlobals(), $context);

        // line 1
        echo "\t<ul class=\"formlist\">
  \t\t<li>
  \t\t\t<label>Tournament name</label>
  \t\t\t<input type=\"text\" name=\"tournamentName\" value=\"";
        // line 4
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['tournament']) ? $context['tournament'] : null), "title", array(), "any", false, 4), "html");
        echo "\" />
  \t\t</li>
  \t\t<li>
  \t\t\t<label>Starting date</label>
  \t\t\t<input type=\"text\" name=\"startDate\" value=\"\" /> (yyyy-mm-dd)
  \t\t</li>
  \t\t<li>
  \t\t\t<label>End date</label>
  \t\t\t<input type=\"text\" name=\"endDate\" value=\"\" />  (yyyy-mm-dd)
  \t\t</li>
  \t</ul>";
    }

    public function getTemplateName()
    {
        return "tournament/form.html";
    }
}
