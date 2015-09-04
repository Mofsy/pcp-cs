<?php

/* page_keys.html */
class __TwigTemplate_23732f281899d78a597149dc435345a7763e5f075177a161c1de8c665999fc3f extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!-- Content Header (Page header) -->
<section class=\"content-header\">
\t<h1>
\t\tКлючи активации
\t</h1>
\t<ol class=\"breadcrumb\">
\t\t<li><a href=\"#\"><i class=\"fa fa-dashboard\"></i> Главная</a></li>
\t\t<li class=\"active\">Ключи активации</li>
\t</ol>
</section>

<!-- Main content -->
<section class=\"content\">
<div class=\"row\">
<div class=\"col-xs-12\">
<div class=\"box\">
<!-- /.box-header -->
<div class=\"box-body table-responsive\">
<table id=\"keys\" class=\"table table-bordered table-striped\">
<thead>
<tr>
\t<th>ID</th>
\t<th>Ключ активации</th>
\t<th>Домен</th>
\t<th>Статус</th>
\t<th>Дата начала</th>
\t<th>Дата окончания</th>
</tr>
</thead>
<tbody>
";
        // line 31
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["keys"]) ? $context["keys"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["key"]) {
            // line 32
            echo "<tr>
\t<td>";
            // line 33
            echo twig_escape_filter($this->env, $this->getAttribute($context["key"], "id", array()), "html", null, true);
            echo "</td>
\t<td>
\t\t";
            // line 35
            echo twig_escape_filter($this->env, $this->getAttribute($context["key"], "key", array()), "html", null, true);
            echo "
\t</td>
\t<td>
\t\t";
            // line 38
            echo twig_escape_filter($this->env, $this->getAttribute($context["key"], "domain", array()), "html", null, true);
            echo "
\t</td>
\t<td>
\t\t";
            // line 41
            if (($this->getAttribute($context["key"], "status", array()) == "0")) {
                echo " <span class=\"badge bg-orange\">Ожидает активации</span>";
            }
            // line 42
            echo "\t\t";
            if (($this->getAttribute($context["key"], "status", array()) == "1")) {
                echo " <span class=\"badge bg-green\">Активен</span>";
            }
            // line 43
            echo "\t\t";
            if (($this->getAttribute($context["key"], "status", array()) == "2")) {
                echo " <span class=\"badge bg-red\">Истек срок</span>";
            }
            // line 44
            echo "\t\t";
            if (($this->getAttribute($context["key"], "status", array()) == "3")) {
                echo " <span class=\"badge bg-green\">Активен</span>";
            }
            // line 45
            echo "\t\t";
            if (($this->getAttribute($context["key"], "status", array()) == "4")) {
                echo " <span class=\"badge bg-green\">Активен</span>";
            }
            // line 46
            echo "\t</td>
\t<td>";
            // line 47
            echo twig_escape_filter($this->env, $this->getAttribute($context["key"], "started", array()), "html", null, true);
            echo "</td>
\t<td>
\t\t";
            // line 49
            if (($this->getAttribute($context["key"], "expires", array()) == "never")) {
                echo " <span class=\"badge bg-green\">Никогда</span>";
            }
            // line 50
            echo "\t\t";
            if (($this->getAttribute($context["key"], "expires", array()) != "never")) {
                echo " ";
                echo twig_escape_filter($this->env, $this->getAttribute($context["key"], "expires", array()), "html", null, true);
            }
            // line 51
            echo "\t\t</td>
</tr>
";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['key'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 54
        echo "</tbody>
</table>
</div>
<!-- /.box-body -->
</div>
<!-- /.box -->
</div>
</div>

</section><!-- /.content -->
<script type=\"text/javascript\">
\t\$( document ).ready((function() {
\t\t\$('#keys').dataTable({
\t\t\t\"oLanguage\": {
\t\t\t\t\"sLengthMenu\": \"_MENU_ на страницу\",
\t\t\t\t\"zeroRecords\": \"Nothing found - sorry\",
\t\t\t\t\"sInfo\": \"Показана страница _PAGE_ из _PAGES_\",
\t\t\t\t\"infoEmpty\": \"No records available\",
\t\t\t\t\"infoFiltered\": \"(найдено из _MAX_ записей)\",
\t\t\t\t\"processing\": \"Полажуйста подождите...\",
\t\t\t\t\"sSearch\": \"Поиск \",
\t\t\t\t\"oPaginate\": {
\t\t\t\t\t\"sFirst\":    \"Первая\",
\t\t\t\t\t\"sPrevious\": \"Назад\",
\t\t\t\t\t\"sNext\":     \"Далее\",
\t\t\t\t\t\"sLast\":     \"Последняя\"
\t\t\t\t}
\t\t\t},
\t\t\t\"lengthMenu\": [[15, 30, 50], [15, 30, 50]],
\t\t\t\"stateSave\": true,
\t\t\t\"bPaginate\": true,
\t\t\t\"bLengthChange\": true,
\t\t\t\"bFilter\": true,
\t\t\t\"bSort\": true,
\t\t\t\"bInfo\": true,
\t\t\t\"bAutoWidth\": true
\t\t});
\t}));
</script>";
    }

    public function getTemplateName()
    {
        return "page_keys.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  125 => 54,  117 => 51,  111 => 50,  107 => 49,  102 => 47,  99 => 46,  94 => 45,  89 => 44,  84 => 43,  79 => 42,  75 => 41,  69 => 38,  63 => 35,  58 => 33,  55 => 32,  51 => 31,  19 => 1,);
    }
}
