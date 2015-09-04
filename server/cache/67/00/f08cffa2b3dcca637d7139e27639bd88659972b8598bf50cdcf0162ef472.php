<?php

/* login.html */
class __TwigTemplate_6700f08cffa2b3dcca637d7139e27639bd88659972b8598bf50cdcf0162ef472 extends Twig_Template
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
<html class=\"bg-black\">
    <head>
        <meta charset=\"UTF-8\">
        <title>Control panel</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link href=\"//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css\" rel=\"stylesheet\" type=\"text/css\" />
        <link href=\"//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.min.css\" rel=\"stylesheet\" type=\"text/css\" />
        <link href=\"";
        // line 9
        echo twig_escape_filter($this->env, (isset($context["home_url"]) ? $context["home_url"] : null), "html", null, true);
        echo "/template/css/Admin.css\" rel=\"stylesheet\" type=\"text/css\" />
        <!--[if lt IE 9]>
          <script src=\"https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js\"></script>
          <script src=\"https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js\"></script>
        <![endif]-->
    </head>
    <body class=\"bg-black\">

        <div class=\"form-box\" id=\"login-box\">
            <div class=\"header\">PHP code protect<br/> control panel</div>
            <form action=\"\" method=\"post\">
                <div class=\"body bg-gray\">
\t\t\t\t\t";
        // line 21
        if (((isset($context["error"]) ? $context["error"] : null) != false)) {
            // line 22
            echo "\t\t\t\t\t<div class=\"alert alert-danger\" role=\"alert\">Вы ввели не верные данные</div>
\t\t\t\t\t";
        }
        // line 24
        echo "                    <div class=\"form-group\">
                        <input type=\"text\" name=\"name\" class=\"form-control\" placeholder=\"User name\"/>
                    </div>
                    <div class=\"form-group\">
                        <input type=\"password\" name=\"password\" class=\"form-control\" placeholder=\"Password\"/>
                    </div>
                    <div class=\"form-group\">
                        <input type=\"checkbox\" value=\"1\" name=\"remember_me\"/> Запомнить меня
                    </div>
                </div>
                <div class=\"footer\">
                    <button type=\"submit\" class=\"btn bg-olive btn-block\"><i class=\"fa fa-sign-in\"></i> &nbsp; Войти в панель</button>
\t\t\t\t\tВаш ip адрес: ";
        // line 36
        echo twig_escape_filter($this->env, (isset($context["user_ip"]) ? $context["user_ip"] : null), "html", null, true);
        echo "
                </div>
            </form>

        </div>

        <script src=\"//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js\"></script>
        <script src=\"//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js\" type=\"text/javascript\"></script>

    </body>
</html>";
    }

    public function getTemplateName()
    {
        return "login.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  64 => 36,  50 => 24,  46 => 22,  44 => 21,  29 => 9,  19 => 1,);
    }
}
