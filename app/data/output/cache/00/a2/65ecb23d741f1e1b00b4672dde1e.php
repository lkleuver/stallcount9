<?php

/* pool/form.html */
class __TwigTemplate_00a265ecb23d741f1e1b00b4672dde1e extends Twig_Template
{
    public function display(array $context, array $blocks = array())
    {
        $context = array_merge($this->env->getGlobals(), $context);

        // line 1
        echo "\t<input type=\"hidden\" name=\"stageId\" value=\"";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['stage']) ? $context['stage'] : null), "id", array(), "any", false, 1), "html");
        echo "\" />
\t<ul class=\"formlist\">
  \t\t<li>
  \t\t\t<label>Pool title</label>
  \t\t\t<input type=\"text\" name=\"poolTitle\" value=\"";
        // line 5
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['pool']) ? $context['pool'] : null), "title", array(), "any", false, 5), "html");
        echo "\" />
  \t\t</li>
  \t\t<li>
  \t\t\t<label>Spots</label>
  \t\t\t<input type=\"text\" name=\"poolSpots\" value=\"";
        // line 9
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['pool']) ? $context['pool'] : null), "spots", array(), "any", false, 9), "html");
        echo "\" />
  \t\t</li>
\t\t<li>
  \t\t\t<label>Pool Ruleset</label>
  \t\t\t<select name=\"poolRulesetId\">
  \t\t\t\t";
        // line 14
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context['poolRulesets']) ? $context['poolRulesets'] : null));
        foreach ($context['_seq'] as $context['_key'] => $context['rs']) {
            // line 15
            echo "  \t\t\t\t\t<option value=\"";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context['rs']) ? $context['rs'] : null), "id", array(), "any", false, 15), "html");
            echo "\">";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context['rs']) ? $context['rs'] : null), "title", array(), "any", false, 15), "html");
            echo "</option>
  \t\t\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['rs'], $context['_parent'], $context['loop']);
        $context = array_merge($_parent, array_intersect_key($context, $_parent));
        // line 17
        echo "  \t\t\t</select>
  \t\t\t
  \t\t</li>
  \t</ul>";
    }

    public function getTemplateName()
    {
        return "pool/form.html";
    }
}
