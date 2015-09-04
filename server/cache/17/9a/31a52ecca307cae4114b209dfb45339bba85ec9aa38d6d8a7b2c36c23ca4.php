<?php

/* index.html */
class __TwigTemplate_179a31a52ecca307cae4114b209dfb45339bba85ec9aa38d6d8a7b2c36c23ca4 extends Twig_Template
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
        echo "<!DOCTYPE html>
<html>
<head>
\t<meta charset=\"UTF-8\">
\t<title>";
        // line 5
        echo twig_escape_filter($this->env, (isset($context["title"]) ? $context["title"] : null), "html", null, true);
        echo "</title>
\t<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
\t<!-- Bootstrap -->
\t<link href=\"";
        // line 8
        echo twig_escape_filter($this->env, (isset($context["home_url"]) ? $context["home_url"] : null), "html", null, true);
        echo "/template/css/bootstrap.min.css\" rel=\"stylesheet\" type=\"text/css\" />
\t<!-- Theme style -->
\t<link href=\"";
        // line 10
        echo twig_escape_filter($this->env, (isset($context["home_url"]) ? $context["home_url"] : null), "html", null, true);
        echo "/template/css/bootstrap-theme.css\" rel=\"stylesheet\" type=\"text/css\" />
\t<!-- FontAwesome 4.3.0 -->
\t<link href=\"https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css\" rel=\"stylesheet\" type=\"text/css\" />
\t<!-- Ionicons 2.0.0 -->
\t<link href=\"https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css\" rel=\"stylesheet\" type=\"text/css\" />
\t<!-- iCheck -->
\t<link href=\"";
        // line 16
        echo twig_escape_filter($this->env, (isset($context["home_url"]) ? $context["home_url"] : null), "html", null, true);
        echo "/template/plugins/iCheck/flat/blue.css\" rel=\"stylesheet\" type=\"text/css\" />

\t<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
\t<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
\t<!--[if lt IE 9]>
\t<script src=\"https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js\"></script>
\t<script src=\"https://oss.maxcdn.com/respond/1.4.2/respond.min.js\"></script>
\t<![endif]-->
</head>
<body class=\"skin-green-light sidebar-mini\">
<div class=\"wrapper\">

\t<header class=\"main-header\">
\t\t<!-- Logo -->
\t\t<a href=\"";
        // line 30
        echo twig_escape_filter($this->env, (isset($context["home_url"]) ? $context["home_url"] : null), "html", null, true);
        echo "\" class=\"logo\">
\t\t\t<!-- mini logo for sidebar mini 50x50 pixels -->
\t\t\t<span class=\"logo-mini\">A</span>
\t\t\t<!-- logo for regular state and mobile devices -->
\t\t\t<span class=\"logo-lg\">Armature</span>
\t\t</a>
\t\t<!-- Header Navbar: style can be found in header.less -->
\t\t<nav class=\"navbar navbar-static-top\" role=\"navigation\">
\t\t\t<!-- Sidebar toggle button-->
\t\t\t<a href=\"#\" class=\"sidebar-toggle\" data-toggle=\"offcanvas\" role=\"button\">
\t\t\t\t<span class=\"sr-only\">Toggle navigation</span>
\t\t\t</a>
\t\t\t<div class=\"navbar-custom-menu\">
\t\t\t\t<ul class=\"nav navbar-nav\">
\t\t\t\t\t<li class=\"tasks-menu\">
\t\t\t\t\t\t<a href=\"";
        // line 45
        echo twig_escape_filter($this->env, (isset($context["home_url"]) ? $context["home_url"] : null), "html", null, true);
        echo "/?action=logout\">
\t\t\t\t\t\t\t<i class=\"fa fa-sign-out\"></i> ";
        // line 46
        echo twig_escape_filter($this->env, (isset($context["user_name"]) ? $context["user_name"] : null), "html", null, true);
        echo " (Выйти)
\t\t\t\t\t\t</a>
\t\t\t\t\t</li>
\t\t\t\t</ul>
\t\t\t</div>
\t\t</nav>
\t</header>
\t<!-- Left side column. contains the logo and sidebar -->
\t<aside class=\"main-sidebar\">
\t\t<!-- sidebar: style can be found in sidebar.less -->
\t\t<section class=\"sidebar\">

\t\t\t<!-- sidebar menu: : style can be found in sidebar.less -->
\t\t\t<ul class=\"sidebar-menu\">
\t\t\t\t<li";
        // line 60
        if (((isset($context["module"]) ? $context["module"] : null) == "main")) {
            echo " class=\"active\"";
        }
        echo ">
\t\t\t\t<a href=\"";
        // line 61
        echo twig_escape_filter($this->env, (isset($context["home_url"]) ? $context["home_url"] : null), "html", null, true);
        echo "/\">
\t\t\t\t\t<i class=\"fa fa-dashboard\"></i> <span>Панель</span>
\t\t\t\t</a>
\t\t\t\t</li>

\t\t\t\t<li";
        // line 66
        if (((isset($context["module"]) ? $context["module"] : null) == "keys")) {
            echo " class=\"active\"";
        }
        echo ">
\t\t\t\t<a href=\"";
        // line 67
        echo twig_escape_filter($this->env, (isset($context["home_url"]) ? $context["home_url"] : null), "html", null, true);
        echo "/?mod=keys\">
\t\t\t\t\t<i class=\"fa fa-key\"></i> <span>Ключи активации</span>
\t\t\t\t</a>
\t\t\t\t</li>
\t\t\t\t<li";
        // line 71
        if (((isset($context["module"]) ? $context["module"] : null) == "methods")) {
            echo " class=\"active\"";
        }
        echo ">
\t\t\t\t<a href=\"";
        // line 72
        echo twig_escape_filter($this->env, (isset($context["home_url"]) ? $context["home_url"] : null), "html", null, true);
        echo "/?mod=methods\">
\t\t\t\t\t<i class=\"fa fa-archive\"></i> <span>Методы проверки</span>
\t\t\t\t</a>
\t\t\t\t</li>
\t\t\t\t<li";
        // line 76
        if (((isset($context["module"]) ? $context["module"] : null) == "logs")) {
            echo " class=\"active\"";
        }
        echo ">
\t\t\t\t<a href=\"";
        // line 77
        echo twig_escape_filter($this->env, (isset($context["home_url"]) ? $context["home_url"] : null), "html", null, true);
        echo "/?mod=logs\">
\t\t\t\t\t<i class=\"fa fa-binoculars\"></i> <span>Запросы к API</span>
\t\t\t\t</a>
\t\t\t\t</li>
\t\t\t\t<li";
        // line 81
        if (((isset($context["module"]) ? $context["module"] : null) == "users")) {
            echo " class=\"active\"";
        }
        echo ">
\t\t\t\t<a href=\"";
        // line 82
        echo twig_escape_filter($this->env, (isset($context["home_url"]) ? $context["home_url"] : null), "html", null, true);
        echo "/?mod=users\">
\t\t\t\t\t<i class=\"fa fa-users\"></i> <span>Пользователи</span>
\t\t\t\t</a>
\t\t\t\t</li>\t\t\t\t<li";
        // line 85
        if (((isset($context["module"]) ? $context["module"] : null) == "settings")) {
            echo " class=\"active\"";
        }
        echo ">
\t\t\t\t<a href=\"";
        // line 86
        echo twig_escape_filter($this->env, (isset($context["home_url"]) ? $context["home_url"] : null), "html", null, true);
        echo "/?mod=logs\">
\t\t\t\t\t<i class=\"fa fa-stack-exchange\"></i> <span>Настройки</span>
\t\t\t\t</a>
\t\t\t\t</li>
\t\t\t</ul>
\t\t</section>
\t\t<!-- /.sidebar -->
\t</aside>

\t<!-- Content Wrapper. Contains page content -->
\t<div class=\"content-wrapper\">
\t\t";
        // line 97
        if (((isset($context["module"]) ? $context["module"] : null) == "main")) {
            // line 98
            echo "\t\t<!-- Content Header (Page header) -->
\t\t<section class=\"content-header\">
\t\t\t<h1>
\t\t\t\tПанель быстрого доступа
\t\t\t</h1>
\t\t\t<ol class=\"breadcrumb\">
\t\t\t\t<li><a href=\"";
            // line 104
            echo twig_escape_filter($this->env, (isset($context["home_url"]) ? $context["home_url"] : null), "html", null, true);
            echo "/\"><i class=\"fa fa-dashboard\"></i> Главная</a></li>
\t\t\t\t<li class=\"active\">Панель быстрого доступа</li>
\t\t\t</ol>
\t\t</section>

\t\t<!-- Main content -->
\t\t<section class=\"content\">

\t\t\t<!-- Small boxes (Stat box) -->
\t\t\t<div class=\"row\">
\t\t\t\t<div class=\"col-lg-3 col-xs-6\">
\t\t\t\t\t<!-- small box -->
\t\t\t\t\t<div class=\"small-box bg-aqua\">
\t\t\t\t\t\t<div class=\"inner\">
\t\t\t\t\t\t\t<h3>
\t\t\t\t\t\t\t\t";
            // line 119
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["stats"]) ? $context["stats"] : null), "pcp_keys", array()), "html", null, true);
            echo "
\t\t\t\t\t\t\t</h3>
\t\t\t\t\t\t\t<p>
\t\t\t\t\t\t\t\tКлючи активации
\t\t\t\t\t\t\t</p>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<div class=\"icon\">
\t\t\t\t\t\t\t<i class=\"ion ion-bag\"></i>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<a href=\"";
            // line 128
            echo twig_escape_filter($this->env, (isset($context["home_url"]) ? $context["home_url"] : null), "html", null, true);
            echo "/?mod=keys\" class=\"small-box-footer\">
\t\t\t\t\t\t\tПерейти <i class=\"fa fa-arrow-circle-right\"></i>
\t\t\t\t\t\t</a>
\t\t\t\t\t</div>
\t\t\t\t</div><!-- ./col -->
\t\t\t\t<div class=\"col-lg-3 col-xs-6\">
\t\t\t\t\t<!-- small box -->
\t\t\t\t\t<div class=\"small-box bg-green\">
\t\t\t\t\t\t<div class=\"inner\">
\t\t\t\t\t\t\t<h3>
\t\t\t\t\t\t\t\t";
            // line 138
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["stats"]) ? $context["stats"] : null), "pcp_methods", array()), "html", null, true);
            echo "
\t\t\t\t\t\t\t</h3>
\t\t\t\t\t\t\t<p>
\t\t\t\t\t\t\t\tМетоды проверки
\t\t\t\t\t\t\t</p>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<div class=\"icon\">
\t\t\t\t\t\t\t<i class=\"ion ion-stats-bars\"></i>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<a href=\"";
            // line 147
            echo twig_escape_filter($this->env, (isset($context["home_url"]) ? $context["home_url"] : null), "html", null, true);
            echo "/?mod=methods\" class=\"small-box-footer\">
\t\t\t\t\t\t\tПерейти <i class=\"fa fa-arrow-circle-right\"></i>
\t\t\t\t\t\t</a>
\t\t\t\t\t</div>
\t\t\t\t</div><!-- ./col -->
\t\t\t\t<div class=\"col-lg-3 col-xs-6\">
\t\t\t\t\t<!-- small box -->
\t\t\t\t\t<div class=\"small-box bg-yellow\">
\t\t\t\t\t\t<div class=\"inner\">
\t\t\t\t\t\t\t<h3>
\t\t\t\t\t\t\t\t";
            // line 157
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["stats"]) ? $context["stats"] : null), "pcp_logs", array()), "html", null, true);
            echo "
\t\t\t\t\t\t\t</h3>
\t\t\t\t\t\t\t<p>
\t\t\t\t\t\t\t\tЗапросы к API
\t\t\t\t\t\t\t</p>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<div class=\"icon\">
\t\t\t\t\t\t\t<i class=\"ion ion-person-add\"></i>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<a href=\"";
            // line 166
            echo twig_escape_filter($this->env, (isset($context["home_url"]) ? $context["home_url"] : null), "html", null, true);
            echo "/?mod=logs\" class=\"small-box-footer\">
\t\t\t\t\t\t\tПерейти <i class=\"fa fa-arrow-circle-right\"></i>
\t\t\t\t\t\t</a>
\t\t\t\t\t</div>
\t\t\t\t</div><!-- ./col -->
\t\t\t\t<div class=\"col-lg-3 col-xs-6\">
\t\t\t\t\t<!-- small box -->
\t\t\t\t\t<div class=\"small-box bg-red\">
\t\t\t\t\t\t<div class=\"inner\">
\t\t\t\t\t\t\t<h3>
\t\t\t\t\t\t\t\t";
            // line 176
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["stats"]) ? $context["stats"] : null), "pcp_users", array()), "html", null, true);
            echo "
\t\t\t\t\t\t\t</h3>
\t\t\t\t\t\t\t<p>
\t\t\t\t\t\t\t\tПользователи
\t\t\t\t\t\t\t</p>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<div class=\"icon\">
\t\t\t\t\t\t\t<i class=\"ion ion-pie-graph\"></i>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<a href=\"";
            // line 185
            echo twig_escape_filter($this->env, (isset($context["home_url"]) ? $context["home_url"] : null), "html", null, true);
            echo "/?mod=users\" class=\"small-box-footer\">
\t\t\t\t\t\t\tПерейти <i class=\"fa fa-arrow-circle-right\"></i>
\t\t\t\t\t\t</a>
\t\t\t\t\t</div>
\t\t\t\t</div><!-- ./col -->
\t\t\t</div><!-- /.row -->

\t\t\t<!-- Main row -->
\t\t\t<div class=\"row\">
\t\t\t\t<div class=\"col-lg-12\">
\t\t\t\t\t<div class=\"box box-gray\">
\t\t\t\t\t\t<div class=\"box-header with-border\">
\t\t\t\t\t\t\t<h3 class=\"box-title\">Latest Orders</h3>
\t\t\t\t\t\t</div><!-- /.box-header -->
\t\t\t\t\t\t<div class=\"box-body\">
\t\t\t\t\t\t\t<div class=\"table-responsive\">
\t\t\t\t\t\t\t\t<table class=\"table no-margin\">
\t\t\t\t\t\t\t\t\t<thead>
\t\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t\t\t<th>Order ID</th>
\t\t\t\t\t\t\t\t\t\t<th>Item</th>
\t\t\t\t\t\t\t\t\t\t<th>Status</th>
\t\t\t\t\t\t\t\t\t\t<th>Popularity</th>
\t\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t\t</thead>
\t\t\t\t\t\t\t\t\t<tbody>
\t\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t\t\t<td><a href=\"pages/examples/invoice.html\">OR9842</a></td>
\t\t\t\t\t\t\t\t\t\t<td>Call of Duty IV</td>
\t\t\t\t\t\t\t\t\t\t<td><span class=\"label label-success\">Shipped</span></td>
\t\t\t\t\t\t\t\t\t\t<td><div class=\"sparkbar\" data-color=\"#00a65a\" data-height=\"20\"><canvas width=\"34\" height=\"20\" style=\"display: inline-block; width: 34px; height: 20px; vertical-align: top;\"></canvas></div></td>
\t\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t\t\t<td><a href=\"pages/examples/invoice.html\">OR1848</a></td>
\t\t\t\t\t\t\t\t\t\t<td>Samsung Smart TV</td>
\t\t\t\t\t\t\t\t\t\t<td><span class=\"label label-warning\">Pending</span></td>
\t\t\t\t\t\t\t\t\t\t<td><div class=\"sparkbar\" data-color=\"#f39c12\" data-height=\"20\"><canvas width=\"34\" height=\"20\" style=\"display: inline-block; width: 34px; height: 20px; vertical-align: top;\"></canvas></div></td>
\t\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t\t\t<td><a href=\"pages/examples/invoice.html\">OR7429</a></td>
\t\t\t\t\t\t\t\t\t\t<td>iPhone 6 Plus</td>
\t\t\t\t\t\t\t\t\t\t<td><span class=\"label label-danger\">Delivered</span></td>
\t\t\t\t\t\t\t\t\t\t<td><div class=\"sparkbar\" data-color=\"#f56954\" data-height=\"20\"><canvas width=\"34\" height=\"20\" style=\"display: inline-block; width: 34px; height: 20px; vertical-align: top;\"></canvas></div></td>
\t\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t\t\t<td><a href=\"pages/examples/invoice.html\">OR7429</a></td>
\t\t\t\t\t\t\t\t\t\t<td>Samsung Smart TV</td>
\t\t\t\t\t\t\t\t\t\t<td><span class=\"label label-info\">Processing</span></td>
\t\t\t\t\t\t\t\t\t\t<td><div class=\"sparkbar\" data-color=\"#00c0ef\" data-height=\"20\"><canvas width=\"34\" height=\"20\" style=\"display: inline-block; width: 34px; height: 20px; vertical-align: top;\"></canvas></div></td>
\t\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t\t\t<td><a href=\"pages/examples/invoice.html\">OR1848</a></td>
\t\t\t\t\t\t\t\t\t\t<td>Samsung Smart TV</td>
\t\t\t\t\t\t\t\t\t\t<td><span class=\"label label-warning\">Pending</span></td>
\t\t\t\t\t\t\t\t\t\t<td><div class=\"sparkbar\" data-color=\"#f39c12\" data-height=\"20\"><canvas width=\"34\" height=\"20\" style=\"display: inline-block; width: 34px; height: 20px; vertical-align: top;\"></canvas></div></td>
\t\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t\t\t<td><a href=\"pages/examples/invoice.html\">OR7429</a></td>
\t\t\t\t\t\t\t\t\t\t<td>iPhone 6 Plus</td>
\t\t\t\t\t\t\t\t\t\t<td><span class=\"label label-danger\">Delivered</span></td>
\t\t\t\t\t\t\t\t\t\t<td><div class=\"sparkbar\" data-color=\"#f56954\" data-height=\"20\"><canvas width=\"34\" height=\"20\" style=\"display: inline-block; width: 34px; height: 20px; vertical-align: top;\"></canvas></div></td>
\t\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t\t\t<td><a href=\"pages/examples/invoice.html\">OR9842</a></td>
\t\t\t\t\t\t\t\t\t\t<td>Call of Duty IV</td>
\t\t\t\t\t\t\t\t\t\t<td><span class=\"label label-success\">Shipped</span></td>
\t\t\t\t\t\t\t\t\t\t<td><div class=\"sparkbar\" data-color=\"#00a65a\" data-height=\"20\"><canvas width=\"34\" height=\"20\" style=\"display: inline-block; width: 34px; height: 20px; vertical-align: top;\"></canvas></div></td>
\t\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t\t</tbody>
\t\t\t\t\t\t\t\t</table>
\t\t\t\t\t\t\t</div><!-- /.table-responsive -->
\t\t\t\t\t\t</div><!-- /.box-body -->
\t\t\t\t\t\t<div class=\"box-footer clearfix\">
\t\t\t\t\t\t\t<a href=\"javascript::;\" class=\"btn btn-sm btn-info btn-flat pull-left\">Place New Order</a>
\t\t\t\t\t\t\t<a href=\"javascript::;\" class=\"btn btn-sm btn-default btn-flat pull-right\">View All Orders</a>
\t\t\t\t\t\t</div><!-- /.box-footer -->
\t\t\t\t\t</div>

\t\t\t\t</div>

\t\t\t</div><!-- /.row (main row) -->

\t\t</section><!-- /.content -->
\t\t";
        }
        // line 269
        echo "
\t\t";
        // line 270
        if (((isset($context["module"]) ? $context["module"] : null) == "keys")) {
            // line 271
            echo "
\t\t";
            // line 272
            $this->env->loadTemplate("page_keys.html")->display($context);
            // line 273
            echo "
\t\t";
        }
        // line 275
        echo "
\t\t";
        // line 276
        if (((isset($context["module"]) ? $context["module"] : null) == "logs")) {
            // line 277
            echo "
\t\t";
            // line 278
            $this->env->loadTemplate("page_logs.html")->display($context);
            // line 279
            echo "
\t\t";
        }
        // line 281
        echo "\t</div><!-- /.content-wrapper -->
\t<footer class=\"main-footer\">
\t\t<div class=\"pull-right hidden-xs\">
\t\t\tVersion <b>0.2.0</b>
\t\t</div>
\t\tCopyright &copy; <a href=\"https://mofsy.ru\">Mofsy</a> 2014-2015.
\t</footer>
</div><!-- ./wrapper -->

<!-- jQuery 2.1.4 -->
<script src=\"";
        // line 291
        echo twig_escape_filter($this->env, (isset($context["home_url"]) ? $context["home_url"] : null), "html", null, true);
        echo "/template/plugins/jQuery/jQuery-2.1.4.min.js\"></script>
<!-- jQuery UI 1.11.2 -->
<script src=\"http://code.jquery.com/ui/1.11.2/jquery-ui.min.js\" type=\"text/javascript\"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
\t\$.widget.bridge('uibutton', \$.ui.button);
</script>
<!-- Bootstrap JS -->
<script src=\"";
        // line 299
        echo twig_escape_filter($this->env, (isset($context["home_url"]) ? $context["home_url"] : null), "html", null, true);
        echo "/template/js/bootstrap.min.js\" type=\"text/javascript\"></script>
<!-- Slimscroll -->
<script src=\"";
        // line 301
        echo twig_escape_filter($this->env, (isset($context["home_url"]) ? $context["home_url"] : null), "html", null, true);
        echo "/template/plugins/slimScroll/jquery.slimscroll.min.js\" type=\"text/javascript\"></script>
<!-- Admin App -->
<script src=\"";
        // line 303
        echo twig_escape_filter($this->env, (isset($context["home_url"]) ? $context["home_url"] : null), "html", null, true);
        echo "/template/js/app.js\" type=\"text/javascript\"></script>

<!-- Admin dashboard demo (This is only for demo purposes) -->
<script src=\"";
        // line 306
        echo twig_escape_filter($this->env, (isset($context["home_url"]) ? $context["home_url"] : null), "html", null, true);
        echo "/template/js/pages/dashboard.js\" type=\"text/javascript\"></script>

</body>
</html>";
    }

    public function getTemplateName()
    {
        return "index.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  455 => 306,  449 => 303,  444 => 301,  439 => 299,  428 => 291,  416 => 281,  412 => 279,  410 => 278,  407 => 277,  405 => 276,  402 => 275,  398 => 273,  396 => 272,  393 => 271,  391 => 270,  388 => 269,  301 => 185,  289 => 176,  276 => 166,  264 => 157,  251 => 147,  239 => 138,  226 => 128,  214 => 119,  196 => 104,  188 => 98,  186 => 97,  172 => 86,  166 => 85,  160 => 82,  154 => 81,  147 => 77,  141 => 76,  134 => 72,  128 => 71,  121 => 67,  115 => 66,  107 => 61,  101 => 60,  84 => 46,  80 => 45,  62 => 30,  45 => 16,  36 => 10,  31 => 8,  25 => 5,  19 => 1,);
    }
}
