<?php 
include('restrito.php');
include('Connections/conexao.php');
include('funcoes.php');

include('class/html.php');
$HTML = new HTML;

?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Agenda > Minha Agenda</title>
<link rel="stylesheet" href="css/style.default.css" type="text/css" />
<link rel="stylesheet" href="css/bootstrap-fileupload.min.css" type="text/css" />
<link rel="stylesheet" href="css/bootstrap-timepicker.min.css" type="text/css" />
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/jquery-migrate-1.1.1.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.9.2.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/bootstrap-fileupload.min.js"></script>
<script type="text/javascript" src="js/bootstrap-timepicker.min.js"></script>
<script type="text/javascript" src="js/jquery.uniform.min.js"></script>
<script type="text/javascript" src="js/jquery.validate.min.js"></script>
<script type="text/javascript" src="js/jquery.tagsinput.min.js"></script>
<script type="text/javascript" src="js/jquery.autogrow-textarea.js"></script>
<script type="text/javascript" src="js/charCount.js"></script>
<script type="text/javascript" src="js/ui.spinner.min.js"></script>
<script type="text/javascript" src="js/chosen.jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>
<script type="text/javascript" src="js/modernizr.min.js"></script>
<script type="text/javascript" src="js/responsive-tables.js"></script>
<script type="text/javascript" src="js/custom.js"></script>
<script type="text/javascript" src="js/forms.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9" />
</head>

<body>
<?php //include_once('head.php');?>
<div class="mainwrapper">
  <?php include_once('header.php');?>
  <?php include_once('inc_coluna.php');?>
  <div class="rightpanel">
    <ul class="breadcrumbs">
      <li><a href="."><i class="iconfa-home"></i></a> <span class="separator"></span></li>
      <li><a href="">Minha Agenda</a></li>
    </ul>
    <div class="pageheader"> 
      
      <!--    	<a href="add_produto.php"class="btn btn-primary btn-mini searchbar"> <i class="icon-plus"></i> &nbsp; Novo</a>
-->
      <div class="pageicon"><span class="iconfa-edit"></span></div>
      <div class="pagetitle" >
        <h5>Agenda</h5>
        <h1>Minha Agenda</h1>
      </div>
    </div>
    <div class="maincontent">
      <div class="maincontentinner">
        <div class="widget">
          <h4 class="widgettitle"><span class="iconfa-edit"></span>Minha Agenda</h4>
          <div class="widgetcontent">
          <iframe src="calendario/sample.php" frameborder="0" width="100%" height="720" scrolling="no"></iframe>
          </div>
        </div>
        <!--widget-->
<?php include_once('footer.php');?>