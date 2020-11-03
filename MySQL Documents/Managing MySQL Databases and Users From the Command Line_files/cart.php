 <!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Shopping Cart - A2 Hosting</title>

<link href="/templates/a2hosting-seven/css/all.min.css?v=397b1b" rel="stylesheet">
<link href="/templates/a2hosting-seven/css/custom.css" rel="stylesheet">
<link rel="stylesheet" href="https://www.a2hosting.com/css/my.css">


<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<script type="text/javascript">
    var csrfToken = 'a6d2d61acd6da932b38408f7700056bbb0aa9fe3',
        markdownGuide = 'Markdown Guide',
        locale = 'en',
        saved = 'saved',
        saving = 'autosaving',
        whmcsBaseUrl = "",
        requiredText = 'Required',
        recaptchaSiteKey = "";
</script>
<script src="/templates/a2hosting-seven/js/scripts.min.js?v=397b1b"></script>
<script src="https://www.a2hosting.com/js/jquery.main.js"></script>
<script src="https://www.a2hosting.com/js/URI.js"></script>
<script src="https://www.a2hosting.com/js/layout_main.js"></script>


<script type="text/javascript">
  /* <![CDATA[ */
  goog_snippet_vars = function() {
    var w = window;
    w.google_conversion_id = 1071532724;
    w.google_conversion_label = "jlkbCLeE72gQtJX5_gM";
    w.google_remarketing_only = false;
  }
  // DO NOT CHANGE THE CODE BELOW.
  goog_report_conversion = function(url) {
    goog_snippet_vars();
    window.google_conversion_format = "3";
    var opt = new Object();
    opt.onload_callback = function() {
    if (typeof(url) != 'undefined') {
      window.location = url;
    }
  }
  var conv_handler = window['google_trackConversion'];
  if (typeof(conv_handler) == 'function') {
    conv_handler(opt);
  }
}
/* ]]> */
</script>
<script src="//www.googleadservices.com/pagead/conversion_async.js"></script>
<script src="https://www.a2hosting.com/js/a2_livechat.js?v=397b1b"></script>

<script type="text/javascript" src="https://www.a2hosting.com/js/a2_gdpr.js"></script>
<style>
                        #MGLoader{
                            background-color:  rgba(0, 0, 0, 0.1);
                            position:absolute;
                            top:0;
                            left: -30%;
                            top: -30%;
                            width:160%;
                            height:130%;
                            z-index: 60000;
                        }
                        #MGLoader img{
                            position: fixed;
                            top:50%;
                            left:50%;
                            width:300px;
                            margin-left: -150px;
                        }
                    </style>
<script type="text/javascript">
                        $(document).ready(function(){
                            $("body").on("hidden.bs.modal", function (e) {
                                $(".modal-backdrop").hide();
                            });
                            $("body").prepend("<div id=\"MGLoader\" style=\"display:none;\"><div><img src=\"modules/addons/DeveloperAccess/templates/clientarea/default/assets/img/ajax-loader.gif\" alt=\"Loading ...\" /></div></div>");
                            $("body").prepend("<div class=\"modal fade\" id=\"errormodal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"errormodal\"><div class=\"modal-dialog\" role=\"document\"><div class=\"modal-content\"><div class=\"modal-header\"><button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button><h4 class=\"modal-title\" id=\"errormodal\">Error</h4></div><div class=\"modal-body\">Something has gone wrong. Check logs and contact admin</div></div></div></div>");
                            $("body").on("click", "li[menuitemname=\"LoginbacktoPrimaryAccount\"] a, a[href=\"#log-back-da\"]", function(){
                                $.ajax({
                                    url: "index.php?m=DeveloperAccess&mg-page=Home&mg-action=getA2Hash&json=1",
                                    error: function(data) {
                                        $("body #errormodal").modal("show");
                                        $("#MGLoader").hide();
                                    },
                                    beforeSend: function() {
                                        $("#MGLoader").show();
                                    },
                                    success: function(data) {
                                        var startString = "JSONRESPONSE#";
                                        var stopString = "#ENDJSONRESPONSE";
                                        var old = data;
                                        var start = data.indexOf(startString);
                                        if(start != "-1"){
                                            data = data.substr(start+startString.length,data.indexOf(stopString)-start-startString.length);
                                            var config = jQuery.parseJSON(data);
                                            $("body").prepend("<form method=\"post\" action=\"dologin.php\" role=\"form\" style=\"display: none;\" class=\"return-form-developer-access\"><input type=\"hidden\" name=\"email\" class=\"form-control\" value="+config.data.email+"><input type=\"hidden\" name=\"timestamp\" value="+config.data.timestamp+"><input type=\"hidden\" name=\"hash\" value="+config.data.hash+"></form>");
                                            $("body .return-form-developer-access").submit();

                                        } else {
                                            $("body #errormodal").modal("show");
                                        }
                                        jQuery("body #MGLoader").hide();
                                    }
                                });
                                return false;
                            });
                        });
                    </script>
<script type='text/javascript'>
                jQuery(document).ready(function() {
                    jQuery('a.sc_feature_link').click(function(){
                        window.open(jQuery(this).attr('href'),'null','location=no,toolbar=no,menubar=no,scrollbars=yes,resizable=yes,addressbar=0,titlebar=no,directories=no,channelmode=no,status=no')
                        return false;
                    })
                });
            </script>


<link rel="stylesheet" type="text/css" href="/assets/css/fontawesome-all.min.css" />
</head>
<body role="document">

<div id="comm100-button-13"></div>
<script type="text/javascript">
  var Comm100API=Comm100API||{};(function(t){function e(e){var a=document.createElement("script"),c=document.getElementsByTagName("script")[0];a.type="text/javascript",a.async=!0,a.src=e+t.site_id,c.parentNode.insertBefore(a,c)}t.chat_buttons=t.chat_buttons||[],t.chat_buttons.push({code_plan:13,div_id:"comm100-button-13"}),t.site_id=100018000,t.main_code_plan=13,e("https://livechat.a2hosting.com/chatserver/livechat.ashx?siteId="),setTimeout(function(){t.loaded||e("https://livechat.a2hosting.com/chatserver/livechat.ashx?siteId=")},5e3)})(Comm100API||{})
</script>

<div id="wrapper">
<header id="header">
<div class="topbar clearfix">
<div class="container">
&nbsp; <div class="language-select">
<select class="language hidden" data-jcf='{"wrapNative": false, "wrapNativeOnMobile": false}' id="language-select">
<option data-image="https://www.a2hosting.com/images/2015/flags/United-States.png" site="https://www.a2hosting.com" class="location location-us" currency="USD" value="us" language="english" SELECTED>UNITED STATES - ENGLISH</option>
<option data-image="https://www.a2hosting.com/images/2015/flags/Brazil.png" site="https://www.a2hosting.com.br" class="location location-br" currency="BRL" value="br" language="portuguese-br">BRASIL - PORTUGUÊS</option>
<option data-image="https://www.a2hosting.com/images/2015/flags/Canada.png" site="https://www.a2hosting.ca" class="location location-ca" currency="CAD" value="ca">CANADA - ENGLISH</option>
<option data-image="https://www.a2hosting.com/images/2015/flags/Colombia.png" site="https://www.a2hosting.com.co" class="location location-co" currency="USD" value="co" language="spanish">COLOMBIA - ESPAÑOL</option>
<option data-image="https://www.a2hosting.com/images/2015/flags/India.png" site="https://www.a2hosting.in" class="location location-in" currency="INR" value="in" language="english">INDIA - ENGLISH</option>
<option data-image="https://www.a2hosting.com/images/2015/flags/Mexico.png" site="https://www.a2hosting.com.mx" class="location location-mx" currency="MXN" value="mx" language="spanish">MÉXICO - ESPAÑOL</option>
<option data-image="https://www.a2hosting.com/images/2015/flags/Singapore.png" site="https://www.a2hosting.sg" class="location location-sg" currency="SGD" value="sg" language="english">SINGAPORE - ENGLISH</option>
<option data-image="https://www.a2hosting.com/images/2015/flags/South-Africa.png" site="https://www.a2hosting.co.za" class="location location-za" currency="ZAR" value="za" language="english">SOUTH AFRICA - ENGLISH</option>
<option data-image="https://www.a2hosting.com/images/2015/flags/Spain.png" site="https://www.a2hosting.es" class="location location-es" currency="EUR" value="es" language="spanish">ESPAÑA - ESPAÑOL</option>
<option data-image="https://www.a2hosting.com/images/2015/flags/United-Kingdom.png" site="https://www.a2hosting.co.uk" class="location location-uk" currency="GBP" value="uk" language="english">UNITED KINGDOM - ENGLISH</option>
</select>
</div>
<div class="currency-select">
<select class="currency hidden" data-jcf='{"wrapNative": false, "wrapNativeOnMobile": false}' id="currency-select">
<option class="currency currency-USD" value="USD" selected>USD $</option>
<option class="currency currency-BRL" value="BRL">BRL R$</option>
<option class="currency currency-CAD" value="CAD">CAD $</option>
<option class="currency currency-EUR" value="EUR">EUR €</option>
<option class="currency currency-GBP" value="GBP">GBP £</option>
<option class="currency currency-INR" value="INR">INR ₹</option>
<option class="currency currency-MXN" value="MXN">MXN $</option>
<option class="currency currency-SGD" value="SGD">SGD S$</option>
<option class="currency currency-ZAR" value="ZAR">ZAR R</option>
</select>
</div>
<nav class="navbar text-center rightnav">
<div class="navbar-header">
<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
<span class="sr-only">Toggle navigation</span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
</button>
</div>
<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
<ul class="nav navbar-nav black-bar">
<li>
<a href="https://www.a2hosting.com/support" class="support support-link" role="button" aria-haspopup="true" aria-expanded="false">
<span class="black-bar-icon icon-user"></span>
SALES & SUPPORT
</a>
</li>
<li>
<a href="javascript: comm100_livechat_open_link();">
<span class="black-bar-icon glyphicon glyphicon-chat"></span>
CHAT
</a>
</li>
<li>
<a href="/cart.php?a=view" class="cart cart-link">
<span class="black-bar-icon icon-cart"></span>
CART
</a>
</li>
<li>
<a href="/clientarea.php" class="login login-link">
<span class="black-bar-icon icon-link"></span>
LOGIN
</a>
</li>
<li class="header-search">
<a href="#" class="search">
<span class="black-bar-icon icon-search"></span>
</a>
<form id="search_box" class="popup" method="post" action="https://www.a2hosting.com">
<input type="hidden" name="token" value="a6d2d61acd6da932b38408f7700056bbb0aa9fe3" />
<div class='hiddenFields'>
<input type="hidden" name="params" value="eyJyZXF1aXJlZCI6ImtleXdvcmRzIn0" />
<input type="hidden" name="ACT" value="47" />
<input type="hidden" name="site_id" value="1" />
</div>
<fieldset>
<input name="keywords" type="text" class="form-control">
<input name="submit" type="submit" class="btn btn-default search-submit-button" value="SEARCH">
</fieldset>
</form>
</li>
</ul>
</div>
</nav>
</div>
</div>
<nav class="navbar navbar-default" id="nav">
<div class="navbar-header">
<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2">
<span class="sr-only">Toggle navigation</span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
</button>
</div>
<div class="container">
<div class="row flex-row">
<div class="col-sm-2 col-md-3">
<div class="logo header-logo">
<a href="/"><img src="https://www.a2hosting.com/images/2015/logo.png" alt="A2 HOSTING OUR SPEED, YOUR SUCCESS"></a>
</div>
</div>
<div class="col-sm-10 col-md-9">
<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
<ul class="nav nav-justified green-bar">
<li class="nav-item"><a href="https://www.a2hosting.com/web-hosting">SHARED HOSTING</a></li>
<li class="nav-item">
<a href="https://www.a2hosting.com/vps-hosting" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">VPS HOSTING</a>
<div class="dropdown-menu">
<div class="container">
<ul class="text-uppercase list-unstyled">
<li class="subnav-item"><a href="https://www.a2hosting.com/vps-hosting">COMPARE VPS PLANS</a></li>
<li class="subnav-item"><a href="https://www.a2hosting.com/vps-hosting/unmanaged">UNMANAGED VPS</a></li>
<li class="subnav-item"><a href="https://www.a2hosting.com/vps-hosting/managed">MANAGED VPS</a></li>
<li class="subnav-item"><a href="https://www.a2hosting.com/vps-hosting/core">CORE VPS</a></li>
</ul>
</div>
</div>
</li>
<li class="nav-item"><a href="https://www.a2hosting.com/reseller-hosting">RESELLER HOSTING</a></li>
<li class="nav-item">
<a href="https://www.a2hosting.com/dedicated-server-hosting" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">DEDICATED HOSTING</a>
<div class="dropdown-menu">
<div class="container">
<ul class="text-uppercase list-unstyled">
<li class="subnav-item"><a href="https://www.a2hosting.com/dedicated-server-hosting">COMPARE SERVERS</a></li>
<li class="subnav-item"><a href="https://www.a2hosting.com/dedicated-server-hosting/unmanaged">UNMANAGED SERVERS</a></li>
<li class="subnav-item"><a href="https://www.a2hosting.com/dedicated-server-hosting/managed">MANAGED SERVERS</a></li>
<li class="subnav-item"><a href="https://www.a2hosting.com/dedicated-server-hosting/core">CORE SERVERS</a></li>
</ul>
</div>
</div>
</li>
<li class="nav-item"><a href="https://www.a2hosting.com/domains">DOMAINS</a></li>
<li class="nav-item"><a href="https://www.a2hosting.com/solutions">SOLUTIONS</a></li>
</ul>
</div>
</div>
</div>
</div>
</nav>
<div class="navbar navbar-default" id="whmcs-nav">
<div class="navbar-header">
<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-3">
<span>Navigate</span>
</button>
</div>
<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-3">
<div class="container">
<ul class="nav nav-justified green-bar">
<li class="nav-item"><a href="/index.php">Home</a></li>
<li class="nav-item"><a href="https://www.a2hosting.com/kb">Knowledgebase</a></li>
<li class="nav-item"><a href="https://www.a2hosting.com/blog">Blog</a></li>
<li class="nav-item"><a href="/networkissues.php">Network Issues</a></li>
<li class="nav-item"><a href="https://www.a2hosting.com/contact">Contact Us</a></li>
<li class="nav-item">
<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Account <span class="caret"></span></a>
<div class="dropdown-menu">
<div class="container">
<ul class="text-uppercase list-unstyled">
<li class="subnav-item"><a href="/clientarea.php">Login</a></li>
<li class="subnav-item"><a href="/register.php">Register</a></li>
<li class="subnav-item"><a href="/pwreset.php">Forgot Password?</a></li>
</ul>
</div>
</div>
</li>
</ul>
</div>
</div>
</div>
</header>
<section id="main-body" class="container">
<div class="row">

<div class="col-xs-12 main-content">
<link rel="stylesheet" type="text/css" href="/templates/orderforms/a2-cart-seven/css/all.min.css?v=397b1b" />
<script type="text/javascript" src="/templates/orderforms/a2-cart-seven/js/scripts.min.js?v=397b1b"></script>
<div id="order-standard_cart">
<div class="row">
<div class="pull-md-right col-md-9">
<div class="header-lined">
<h1>
Web Hosting
</h1>
</div>
</div>
<div class="col-md-3 pull-md-left sidebar hidden-xs hidden-sm">
<div menuItemName="Categories" class="panel panel-sidebar">
<div class="panel-heading">
<h3 class="panel-title">
<i class="fas fa-shopping-cart"></i>&nbsp;
Categories
<i class="fas fa-chevron-up panel-minimise pull-right"></i>
</h3>
</div>
<div class="list-group">
<a menuItemName="Web Hosting" href="/cart.php?gid=7" class="list-group-item active" id="Secondary_Sidebar-Categories-Web_Hosting">
Web Hosting
</a>
<a menuItemName="Windows Web Hosting" href="/cart.php?gid=29" class="list-group-item" id="Secondary_Sidebar-Categories-Windows_Web_Hosting">
Windows Web Hosting
</a>
<a menuItemName="Managed WordPress Hosting" href="/cart.php?gid=35" class="list-group-item" id="Secondary_Sidebar-Categories-Managed_WordPress_Hosting">
Managed WordPress Hosting
</a>
<a menuItemName="Reseller Hosting" href="/cart.php?gid=8" class="list-group-item" id="Secondary_Sidebar-Categories-Reseller_Hosting">
Reseller Hosting
</a>
<a menuItemName="Windows Reseller" href="/cart.php?gid=30" class="list-group-item" id="Secondary_Sidebar-Categories-Windows_Reseller">
Windows Reseller
</a>
<a menuItemName="VPS Hosting" href="/cart.php?gid=19" class="list-group-item" id="Secondary_Sidebar-Categories-VPS_Hosting">
VPS Hosting
</a>
<a menuItemName="Managed VPS Hosting" href="/cart.php?gid=18" class="list-group-item" id="Secondary_Sidebar-Categories-Managed_VPS_Hosting">
Managed VPS Hosting
</a>
<a menuItemName="Windows VPS" href="/cart.php?gid=33" class="list-group-item" id="Secondary_Sidebar-Categories-Windows_VPS">
Windows VPS
</a>
<a menuItemName="Managed VPS Hosting with Root" href="/cart.php?gid=31" class="list-group-item" id="Secondary_Sidebar-Categories-Managed_VPS_Hosting_with_Root">
Managed VPS Hosting with Root
</a>
<a menuItemName="Flex Dedicated Servers" href="/cart.php?gid=24" class="list-group-item" id="Secondary_Sidebar-Categories-Flex_Dedicated_Servers">
Flex Dedicated Servers
</a>
<a menuItemName="Managed Flex Dedicated Servers" href="/cart.php?gid=21" class="list-group-item" id="Secondary_Sidebar-Categories-Managed_Flex_Dedicated_Servers">
Managed Flex Dedicated Servers
</a>
<a menuItemName="Managed Flex Dedicated Servers with Root" href="/cart.php?gid=32" class="list-group-item" id="Secondary_Sidebar-Categories-Managed_Flex_Dedicated_Servers_with_Root">
Managed Flex Dedicated Servers with Root
</a>
<a menuItemName="Additional Services" href="/cart.php?gid=20" class="list-group-item" id="Secondary_Sidebar-Categories-Additional_Services">
Additional Services
</a>
<a menuItemName="Support Requests" href="/cart.php?gid=25" class="list-group-item" id="Secondary_Sidebar-Categories-Support_Requests">
Support Requests
</a>
<a menuItemName="Sucuri Services" href="/cart.php?gid=34" class="list-group-item" id="Secondary_Sidebar-Categories-Sucuri_Services">
Sucuri Services
</a>
<a menuItemName="SSL Certificates" href="/cart.php?gid=37" class="list-group-item" id="Secondary_Sidebar-Categories-SSL_Certificates">
SSL Certificates
</a>
</div>
</div>
<div menuItemName="Actions" class="panel panel-sidebar">
<div class="panel-heading">
<h3 class="panel-title">
<i class="fas fa-plus"></i>&nbsp;
Actions
<i class="fas fa-chevron-up panel-minimise pull-right"></i>
</h3>
</div>
<div class="list-group">
<a menuItemName="Domain Registration" href="/cart.php?a=add&domain=register" class="list-group-item" id="Secondary_Sidebar-Actions-Domain_Registration">
<i class="fas fa-globe fa-fw"></i>&nbsp;
Register a New Domain
</a>
<a menuItemName="Domain Transfer" href="/cart.php?a=add&domain=transfer" class="list-group-item" id="Secondary_Sidebar-Actions-Domain_Transfer">
<i class="fas fa-share fa-fw"></i>&nbsp;
Transfer in a Domain
</a>
<a menuItemName="View Cart" href="/cart.php?a=view" class="list-group-item" id="Secondary_Sidebar-Actions-View_Cart">
<i class="fas fa-shopping-cart fa-fw"></i>&nbsp;
View Cart
</a>
</div>
</div>
<div menuItemName="Choose Currency" class="panel panel-sidebar">
<div class="panel-heading">
<h3 class="panel-title">
<i class="fas fa-plus"></i>&nbsp;
Choose Currency
<i class="fas fa-chevron-up panel-minimise pull-right"></i>
</h3>
</div>
<div class="panel-body">
<form method="post" action="cart.php?gid=7">
<input type="hidden" name="token" value="a6d2d61acd6da932b38408f7700056bbb0aa9fe3" />
<select name="currency" onchange="submit()" class="form-control"><option value="12">BRL</option><option value="6">CAD</option><option value="5">EUR</option><option value="7">GBP</option><option value="8">INR</option><option value="9">MXN</option><option value="13">SGD</option><option value="1" selected>USD</option><option value="10">ZAR</option> </select>
</form>
</div>
</div>
</div>
<div class="col-md-9 pull-md-right">
<div class="categories-collapsed visible-xs visible-sm clearfix">
<div class="pull-left form-inline">
<form method="get" action="/cart.php">
<select name="gid" onchange="submit()" class="form-control">
<optgroup label="Product Categories">
<option value="7" selected="selected">Web Hosting</option>
<option value="29">Windows Web Hosting</option>
<option value="35">Managed WordPress Hosting</option>
<option value="8">Reseller Hosting</option>
<option value="30">Windows Reseller</option>
<option value="19">VPS Hosting</option>
<option value="18">Managed VPS Hosting</option>
<option value="33">Windows VPS</option>
<option value="31">Managed VPS Hosting with Root</option>
<option value="24">Flex Dedicated Servers</option>
<option value="21">Managed Flex Dedicated Servers</option>
<option value="32">Managed Flex Dedicated Servers with Root</option>
<option value="20">Additional Services</option>
<option value="25">Support Requests</option>
<option value="34">Sucuri Services</option>
<option value="37">SSL Certificates</option>
</optgroup>
<optgroup label="Actions">
<option value="registerdomain">Register a New Domain</option>
<option value="transferdomain">Transfer in a Domain</option>
<option value="viewcart">View Cart</option>
</optgroup>
</select>
</form>
</div>
<div class="pull-right form-inline">
<form method="post" action="cart.php?gid=7">
<input type="hidden" name="token" value="a6d2d61acd6da932b38408f7700056bbb0aa9fe3" />
<select name="currency" onchange="submit()" class="form-control">
<option value="">Choose Currency</option>
<option value="12">BRL</option>
<option value="6">CAD</option>
<option value="5">EUR</option>
<option value="7">GBP</option>
<option value="8">INR</option>
<option value="9">MXN</option>
<option value="13">SGD</option>
<option value="1" selected>USD</option>
<option value="10">ZAR</option>
</select>
</form>
</div>
</div>
<div class="products" id="products">
<div class="row row-eq-height">
<div class="col-md-6">
<div class="product clearfix" id="product1">
<header>
<span id="product1-name">Lite Web Hosting</span>
</header>
<div class="product-desc">
<p id="product1-description">
<span class="unlimited-unmetered to-uppercase">UNLIMITED</span> Disk Space<br />
<span class="unlimited-unmetered to-uppercase">UNLIMITED</span> Monthly Data Transfer<br />
25 Email Addresses<br />
5 MySQL Databases<br />
1 Domain<br />
5 Subdomains<br />
25 Parked Domains<br />
cPanel Access<br />
</p>
<ul>
</ul>
</div>
<footer>
<div class="product-pricing" id="product1-price">
Starting from
<br />
<span class="price">
$9.99
</span><br>
Monthly
<br>
</div>
<a href="cart.php?a=add&pid=160" class="btn btn-orange btn-sm" id="product1-order-button">
<i class="fas fa-shopping-cart"></i>
Order Now
</a>
</footer>
</div>
</div>
<div class="col-md-6">
<div class="product clearfix" id="product2">
<header>
<span id="product2-name">Swift Web Hosting</span>
</header>
<div class="product-desc">
<p id="product2-description">
* UltraFast Solid State Drive Storage *<br />
<span class="unlimited-unmetered to-uppercase">UNLIMITED</span> Disk Space<br />
<span class="unlimited-unmetered to-uppercase">UNLIMITED</span> Monthly Data Transfer<br />
UNLIMITED Email Addresses<br />
UNLIMITED MySQL Databases<br />
UNLIMITED Domains<br />
cPanel Access<br />
</p>
<ul>
</ul>
</div>
<footer>
<div class="product-pricing" id="product2-price">
Starting from
<br />
<span class="price">
$12.99
</span><br>
Monthly
<br>
</div>
<a href="cart.php?a=add&pid=162" class="btn btn-orange btn-sm" id="product2-order-button">
<i class="fas fa-shopping-cart"></i>
Order Now
</a>
</footer>
</div>
</div>
</div>
<div class="row row-eq-height">
<div class="col-md-6">
<div class="product clearfix" id="product3">
<header>
<span id="product3-name">Turbo Web Hosting</span>
</header>
<div class="product-desc">
<p id="product3-description">
<span class="unlimited-unmetered to-uppercase">UNLIMITED</span> Disk Space<br />
<span class="unlimited-unmetered to-uppercase">UNLIMITED</span> Monthly Data Transfer<br />
UNLIMITED Email Addresses<br />
UNLIMITED MySQL Databases<br />
UNLIMITED Domains<br />
cPanel Access<br />
LIGHTSPEED Web Server<br />
SSD Storage<br />
</p>
<ul>
</ul>
</div>
<footer>
<div class="product-pricing" id="product3-price">
Starting from
<br />
<span class="price">
$24.99
</span><br>
Monthly
<br>
</div>
<a href="cart.php?a=add&pid=164" class="btn btn-orange btn-sm" id="product3-order-button">
<i class="fas fa-shopping-cart"></i>
Order Now
</a>
</footer>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="clearfix"></div>
</section>
<section class="newsletter-block">
<div class="container">
<div class="row">
<div class="col-md-5 col-sm-12">
<div class="text">
<h2 class="newsletter-title">Newsletter</h2>
<p class="newsletter-content">Web development tips, marketing strategies and A2 Hosting news sent to your inbox.</p>
</div>
</div>
<div class="col-md-7 col-sm-12">
<form action="https://a2hosting.getresponse360.com/add_subscriber.html" accept-charset="utf-8" method="post" class="newsletter-form">
<input type="hidden" name="token" value="a6d2d61acd6da932b38408f7700056bbb0aa9fe3" />
<div class="row">
<div class="col col-sm-8">
<input type="email" class="form-control" name="email" placeholder="Enter your email address">
</div>
<div class="col col-sm-4">
<input type="submit" value="SIGN UP" class="btn btn-default btn-block btn-lg text-uppercase">
</div>
</div>


<input type="hidden" name="campaign_token" value="n5CMl" />
</form>
<ul class="socialnetworks list-inline">
<li><a href="https://www.facebook.com/a2webhosting/" class="icon-facebook footer-social-button"></a></li>
<li><a href="https://twitter.com/a2hosting" class="icon-twitter footer-social-button"></a></li>
<li><a href="https://www.linkedin.com/company/a2-hosting" class="icon-linkedin footer-social-button"></a></li>
<li><a href="https://www.youtube.com/user/A2HostingHelp" class="icon-youtube footer-social-button"></a></li>
</ul>
</div>
</div>
</div>
</section>
<div id="footer_container" class="footer-area">
<div class="container">
<div class="row">
<div class="col-sm-12">
<div class="holder">
<div class="links">
<strong class="heading text-uppercase"><a class="footer-heading-link" href="#">Hosting</a></strong>
<ul class="list-unstyled">
<li><a href="https://www.a2hosting.com/web-hosting">Web Hosting</a></li>
<li><a href="https://www.a2hosting.com/wordpress-hosting">WordPress Hosting</a></li>
<li><a href="https://www.a2hosting.com/wordpress-hosting/managed">Managed WordPress Hosting</a></li>
<li><a href="https://www.a2hosting.com/reseller-hosting">Reseller Hosting</a></li>
<li><a href="https://www.a2hosting.com/vps-hosting">VPS Hosting</a></li>
<li><a href="https://www.a2hosting.com/managed-vps-hosting">Managed VPS Hosting</a></li>
<li><a href="https://www.a2hosting.com/cloud-vps-hosting">Cloud VPS Hosting</a></li>
<li><a href="https://www.a2hosting.com/dedicated-server-hosting">Dedicated Server Hosting</a></li>
<li>
<a href="https://www.a2hosting.com/email-hosting">Email Hosting</a>
</li>
</ul>
</div>
<div class="links">
<strong class="heading text-uppercase"><a class="footer-heading-link" href="#">Features</a></strong>
<ul class="list-unstyled">
<li>
<a href="https://www.a2hosting.com/developer-friendly-hosting">Developer Friendly Hosting</a>
</li>
<li><a href="https://www.a2hosting.com/domains">Domain Registration</a></li>
<li><a href="https://www.a2hosting.com/domains/transfer">Domain Transfer</a></li>
<li><a href="https://www.a2hosting.com/ssl-certificates">SSL Certificates</a></li>
<li><a href="https://www.a2hosting.com/swiftservers-fast-hosting">SwiftServers Fast Hosting</a></li>
<li><a href="https://www.a2hosting.com/compare">Compare Hosting</a></li>
</ul>
</div>
<div class="links">
<strong class="heading text-uppercase"><a class="footer-heading-link" href="#">Services</a></strong>
<ul class="list-unstyled">
<li><a href="https://www.a2hosting.com/blog-hosting">Blog Hosting</a></li>
<li><a href="https://www.a2hosting.com/cms-hosting">CMS Hosting</a></li>
<li>
<a href="https://www.a2hosting.com/crm-hosting">CRM Hosting</a>
</li>
<li><a href="https://www.a2hosting.com/ecommerce-hosting">eCommerce Hosting</a></li>
<li><a href="https://www.a2hosting.com/forum-hosting">Forum Hosting</a></li>
<li><a href="https://www.a2hosting.com/linux-hosting">Linux Hosting</a></li>
<li><a href="https://www.a2hosting.com/wiki-hosting">Wiki Hosting</a></li>
<li><a href="https://www.a2hosting.com/windows-hosting">Windows Hosting</a></li>
</ul>
</div>
<div class="links">
<strong class="heading text-uppercase"><a class="footer-heading-link" href="#">Support</a></strong>
<ul class="list-unstyled">
<li><a href="https://my.a2hosting.com/submitticket.php">Submit a Support Ticket</a></li>
<li><a href="https://my.a2hosting.com/contact.php">Contact Sales</a></li>
<li><a href="https://www.a2hosting.com/kb">Knowledgebase</a></li>
<li><a href="https://www.a2hosting.com/blog">A2 Hosting Blog</a></li>
<li><a href="https://www.a2hosting.com/99.9-uptime-commitment">99.9% Uptime Commitment</a></li>
<li><a href="https://www.a2hosting.com/anytime-money-back-guarantee">Anytime Money Back Guarantee</a></li>
</ul>
</div>
<div class="links">
<strong class="heading text-uppercase"><a class="footer-heading-link" href="#">Company</a></strong>
<ul class="list-unstyled">
<li><a href="https://www.a2hosting.com/about">About A2 Hosting</a></li>
<li><a href="https://www.a2hosting.com/reviews">A2 Hosting Reviews</a></li>
<li><a href="https://www.a2hosting.com/about/affiliate-program">Affiliate Program</a></li>
<li><a href="https://www.a2hosting.com/about/careers">Careers</a></li>
<li><a href="https://www.a2hosting.com/about/data-center">Data Centers</a></li>
<li><a href="https://www.a2hosting.com/about/policies">Policies</a></li>
<li><a href="https://www.a2hosting.com/about/policies/terms-of-service">Terms Of Service</a></li>
<li><a href="https://www.a2hosting.com/about/policies/privacy">Privacy Policy</a></li>
<li><a href="https://www.a2hosting.com/locations">Locations</a></li>
<li><a href="https://www.a2hosting.com/about/refer-a-friend">Refer-A-Friend</a></li>
</ul>
</div>
</div>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<div class="payment-methods">
<strong class="title">Payment accepted</strong>
<ul class="list-inline"></ul>
</div>
</div>
<div class="col-sm-6">
<ul class="approved-items list-inline">
<li>
<a href="https://www.bbb.org/eastern-michigan/business-reviews/internet-web-hosting/a2-hosting-inc-in-ann-arbor-mi-49003294/#bbbonlineclick" target="_blank">
<img data-cfsrc="/images/2015/endorsement-bbb-accredited-business.jpg" alt="BBB Accredited Business" style="display:none;visibility:hidden;"><noscript><img src="https://www.a2hosting.com/images/2015/endorsement-bbb-accredited-business.jpg" alt="BBB Accredited Business"></noscript>
</a>
</li>
<li>
<a href="https://www.glassdoor.com/Overview/Working-at-A2-Hosting-EI_IE236750.11,21.htm" target="_blank">
<img src="https://www.glassdoor.com/api/widget/verticalStarRating.htm?e=236750" alt="glassdoor"></a>
</li>
</ul>
</div>
</div>
</div>
<div id="gdpr_notice">
<div class="container">
<div class="row">
<p>We use cookies to personalize the website for you and to analyze the use of our website. You consent to this by clicking on "I consent" or by continuing your use of this website. Further information about cookies can be found in our <a href="https://www.a2hosting.com/about/website-privacy">Privacy Policy</a>.</p>
<p class="bottom-align"><button class="btn btn-primary" value="consent">I consent</button></p>
</div>
</div>
</div>
</div>
<footer id="footer">
<div class="container">
<span class="copyright">Copyright &copy; <a href="https://www.a2hosting.com/">A2 HOSTING</a> 2019</span>
</div>
</footer>
</div>
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-344424-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-344424-1', {
	'optimize_id': 'GTM-T535N7P',
    'linker': {
      'domains': ["www.a2hosting.com","www.a2hosting.com.mx","www.a2hosting.in","www.a2hosting.co.uk","www.a2hosting.co.za","www.a2hosting.com.br","www.a2hosting.es","www.a2hosting.sg","www.a2hosting.com.co","www.a2hosting.ca"]
    }
  });

  gtag('config', 'AW-1071532724', {
	'linker': {
		'domains': ["www.a2hosting.com","www.a2hosting.com.mx","www.a2hosting.in","www.a2hosting.co.uk","www.a2hosting.co.za","www.a2hosting.com.br","www.a2hosting.es","www.a2hosting.sg","www.a2hosting.com.co","www.a2hosting.ca"]
	}
  });
</script>
<script type="text/javascript">
			if (navigator.userAgent.match(/IEMobile\/10\.0/)) {
			var msViewportStyle = document.createElement('style')
			msViewportStyle.appendChild(
			document.createTextNode(
			 '@-ms-viewport{width:auto!important}'
			)
			)
			document.querySelector('head').appendChild(msViewportStyle)
			}
	</script>
<script>
		var ie = /MSIE (\d+)/.exec(navigator.userAgent);
		ie = ie? ie[1] : null;
		if(ie != null && ie < 11) {
			$('#header').append('<div class="alert alert-warning old-browser-notice"><div class="notice-content"><h4>Please Note</h4><span class="notice-text">Your browser is <strong>no longer supported by Microsoft</strong>. As a result some parts of this web site will not render properly.We recommend upgrading to a modern browser such as Chrome, Firefox or Microsoft Edge.</span></div></div>');
			$('.old-browser-notice').show();
		}
	</script>
<script>
 var intervalID = setInterval(function() {
	 $('#fb_xdm_frame_https').css('display', 'none');
	 if($('#fb_xdm_frame_https').css('display') == 'none') { clearInterval(intervalID); }
	 } , 100);
</script>

<script>
!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function()
{n.callMethod? n.callMethod.apply(n,arguments):n.queue.push(arguments)}
;if(!f._fbq)f._fbq=n;
n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
document,'script','//connect.facebook.net/en_US/fbevents.js');
fbq('init', '475481482662863');
fbq('track', "PageView");
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=475481482662863&ev=PageView&noscript=1"
/></noscript>


<script>
    (function(h,o,t,j,a,r){
        h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
        h._hjSettings={hjid:83166,hjsv:6};
        a=o.getElementsByTagName('head')[0];
        r=o.createElement('script');r.async=1;
        r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
        a.appendChild(r);
    })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
</script>

<script>
	(function(w,d,t,r,u){var f,n,i;w[u]=w[u]||[],f=function(){var o={ti:"5039590"};
	o.q=w[u],w[u]=new UET(o),w[u].push("pageLoad")},n=d.createElement(t),n.src=r,n.async=1,n.onload=n.onreadystatechange=function(){
	var s=this.readyState;
	s&&s!=="loaded"&&s!=="complete"||(f(),n.onload=n.onreadystatechange=null)},i=d.getElementsByTagName(t)[0],i.parentNode.insertBefore(n,i)})(window,document,"script","//bat.bing.com/bat.js","uetq");
</script>
<noscript>
		<img src="//bat.bing.com/action/0?ti=5039590&Ver=2" height="0" width="0" style="display:none; visibility: hidden;" />
</noscript>

<script type="text/javascript">
	document.write(unescape("%3Cscript id='pap_x2s6df8d' src='" + (("https:" == document.location.protocol) ? "https://" : "http://") +
	"affiliates.a2hosting.com/scripts/trackjs.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
    if (typeof PostAffTracker != "undefined") {
		PostAffTracker.setAccountId('default1');
		PostAffTracker.disableTrackingMethod('F');
		try {
			PostAffTracker.track();
		} catch (err) { }
	}
</script>
</div>
<div class="modal system-modal fade" id="modalAjax" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content panel panel-primary">
<div class="modal-header panel-heading">
<button type="button" class="close" data-dismiss="modal">
<span aria-hidden="true">&times;</span>
<span class="sr-only">Close</span>
</button>
<h4 class="modal-title">Title</h4>
</div>
<div class="modal-body panel-body">
Loading...
</div>
<div class="modal-footer panel-footer">
<div class="pull-left loader">
<i class="fas fa-circle-notch fa-spin"></i> Loading...
</div>
<button type="button" class="btn btn-default" data-dismiss="modal">
Close
</button>
<button type="button" class="btn btn-primary modal-submit">
Submit
</button>
</div>
</div>
</div>
</div>
<script type="text/javascript">
			function process_country(code) {
				$.getJSON('/?m=a2_paymentgw_selector&country_code=' + code, function (data) {
					$('input[name="paymentmethod"]').each(function () {
						var found = false;
						
						for (var i = 0; i < data.length; i++) {
							if (data[i].gateway_id == $(this).val()) {
								found = true;
								break;
							}
							
						}
						
						if (!found) {
							$(this).parent().parent().hide();
						}
					});
					
					$('input[name="paymentmethod"]:visible').first().next().click();
					$('input[name="paymentmethod"]').last().parent().parent().parent().append('<div id="show-payment-gateways"><button class="btn btn-xs">Show All Payment Gateways</button></div>');
					
					$('#show-payment-gateways button').click(function (e) {
						e.preventDefault();
						$('input[name="paymentmethod"]').parent().parent().show();
					});
				});
			}
		
			$(document).ready(function () {
				a2.country(process_country);
			});
		</script>
</body>
</html>
