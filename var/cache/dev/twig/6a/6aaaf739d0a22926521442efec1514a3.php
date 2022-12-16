<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* slot/affichageSot.html.twig */
class __TwigTemplate_40e9c39b459b70cf629b19db839b3a7e extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'body' => [$this, 'block_body'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_5a27a8ba21ca79b61932376b2fa922d2 = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "slot/affichageSot.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "slot/affichageSot.html.twig"));

        $this->parent = $this->loadTemplate("base.html.twig", "slot/affichageSot.html.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

    }

    // line 2
    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_5a27a8ba21ca79b61932376b2fa922d2 = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "title"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "title"));

        // line 3
        echo "    ";
        echo twig_escape_filter($this->env, (isset($context["title"]) || array_key_exists("title", $context) ? $context["title"] : (function () { throw new RuntimeError('Variable "title" does not exist.', 3, $this->source); })()), "html", null, true);
        echo "
";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

    }

    // line 5
    public function block_body($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_5a27a8ba21ca79b61932376b2fa922d2 = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "body"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "body"));

        // line 6
        echo "    <h1>";
        echo twig_escape_filter($this->env, (isset($context["title"]) || array_key_exists("title", $context) ? $context["title"] : (function () { throw new RuntimeError('Variable "title" does not exist.', 6, $this->source); })()), "html", null, true);
        echo "</h1>

    <div>
        <div>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium atque blanditiis deleniti enim error eum
            expedita incidunt minus nam, numquam odio officia perferendis ratione recusandae rem reprehenderit sed
            temporibus voluptates.
        </div>
        <div>Accusantium deleniti dicta doloremque, dolorum eaque eum eveniet ex facilis ipsa iste neque nobis obcaecati
            optio quam qui quis rerum sapiente sunt temporibus voluptatum? Debitis id iste molestiae officiis quam!
        </div>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Commodi dignissimos dolore earum enim eveniet
            expedita explicabo illo laudantium natus necessitatibus nemo nobis, non officiis optio possimus quod sit
            veritatis voluptatibus!</p>
        <p>Deleniti excepturi minima voluptatem. Autem culpa dolor incidunt. Beatae commodi distinctio doloribus eius
            molestias mollitia repellat repellendus velit veritatis. Animi cupiditate dolorum ea enim hic illo quia,
            reprehenderit sed temporibus.</p>
        <h2>Commentaires (";
        // line 22
        echo twig_escape_filter($this->env, twig_length_filter($this->env, (isset($context["comments"]) || array_key_exists("comments", $context) ? $context["comments"] : (function () { throw new RuntimeError('Variable "comments" does not exist.', 22, $this->source); })())), "html", null, true);
        echo ")</h2>
        <ul>
            ";
        // line 24
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["comments"]) || array_key_exists("comments", $context) ? $context["comments"] : (function () { throw new RuntimeError('Variable "comments" does not exist.', 24, $this->source); })()));
        foreach ($context['_seq'] as $context["_key"] => $context["comment"]) {
            // line 25
            echo "                <li>";
            echo twig_escape_filter($this->env, $context["comment"], "html", null, true);
            echo "</li>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['comment'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 27
        echo "        </ul>
    </div>
";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

    }

    public function getTemplateName()
    {
        return "slot/affichageSot.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  130 => 27,  121 => 25,  117 => 24,  112 => 22,  92 => 6,  82 => 5,  69 => 3,  59 => 2,  36 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends 'base.html.twig' %}
{% block title %}
    {{ title }}
{% endblock %}
{% block body %}
    <h1>{{ title }}</h1>

    <div>
        <div>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium atque blanditiis deleniti enim error eum
            expedita incidunt minus nam, numquam odio officia perferendis ratione recusandae rem reprehenderit sed
            temporibus voluptates.
        </div>
        <div>Accusantium deleniti dicta doloremque, dolorum eaque eum eveniet ex facilis ipsa iste neque nobis obcaecati
            optio quam qui quis rerum sapiente sunt temporibus voluptatum? Debitis id iste molestiae officiis quam!
        </div>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Commodi dignissimos dolore earum enim eveniet
            expedita explicabo illo laudantium natus necessitatibus nemo nobis, non officiis optio possimus quod sit
            veritatis voluptatibus!</p>
        <p>Deleniti excepturi minima voluptatem. Autem culpa dolor incidunt. Beatae commodi distinctio doloribus eius
            molestias mollitia repellat repellendus velit veritatis. Animi cupiditate dolorum ea enim hic illo quia,
            reprehenderit sed temporibus.</p>
        <h2>Commentaires ({{ comments | length }})</h2>
        <ul>
            {% for comment in comments %}
                <li>{{ comment }}</li>
            {% endfor %}
        </ul>
    </div>
{% endblock %}", "slot/affichageSot.html.twig", "C:\\source\\PhpstormProjects\\SymfonyInitial\\SymfoRagoroProject\\templates\\slot\\affichageSot.html.twig");
    }
}
