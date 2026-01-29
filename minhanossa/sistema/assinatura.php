<?php 
include('restrito.php');
include('Connections/conexao.php');
include('funcoes.php');

$currentPage = 'usuario.php';

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
if($_GET['buscaLogin'] <> ''){
	$sql = "and login LIKE '%".$_GET['buscaLogin']."%'";
}
if($_GET['buscaNome'] <> ''){
	$sql .= "and nome LIKE '%".$_GET['buscaNome']."%'";
}
if($_GET['buscaEmail'] <> ''){
	$sql .= "and email LIKE '%".$_GET['buscaEmail']."%'";
}
if($_GET['buscaStatus'] <> ''){
	$sql .= "and status = '%".$_GET['buscaStatus']."%'";
}

mysql_select_db($database_conexao, $conexao);
$query_rs_usuario = "SELECT * FROM tbl_admin WHERE id is not null $sql ORDER BY nome ASC";
$rs_usuario = mysql_query($query_rs_usuario, $conexao) or die(mysql_error());
$row_rs_usuario = mysql_fetch_assoc($rs_usuario);
$totalRows_rs_usuario = mysql_num_rows($rs_usuario);
?>
<!DOCTYPE html>
<html>
<head>

<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Assinatura</title>

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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>

<body>
<?php //include_once('head.php');?>

<style>
       th{font-size:10px !important;}
	   .validadeAssinatura{
		  background:#496949 !important;
		  width:100px;
		  height:50px;
		  color:#FFFFFF;
		  margin:10px 10px;
		  padding:7px 10px;
		  border-radius:7px;
		  }
       </style>

<div class="mainwrapper">
<?php include_once('header.php');?>
<?php include_once('inc_coluna.php');?>
<div class="rightpanel">
  <ul class="breadcrumbs">
    <li><a href="."><i class="iconfa-home"></i></a> <span class="separator"></span></li>
    <li><a href="assinatura.php">Assinatura</a></li>
    
  </ul>
  <div class="pageheader">
    <!--<form action="results.html" method="post" class="searchbar" />
                <input type="text" name="keyword" placeholder="To search type and hit enter..." />
            </form>-->
    <div class="pageicon"><span class="iconfa-edit"></span></div>
    <div class="pagetitle">
      <h5>Administração</h5>
      <h1>Assinatura</h1>
    </div>
  </div>
  <!--pageheader-->
  <div class="maincontent">
    <div class="maincontentinner">
      <div class="widget">
        <h4 class="widgettitle"><span class="iconfa-shopping-cart"></span>Assinatura</h4>
        <div class="widgetcontent">
          <form class="stdform" action="" method="get" name="formSearchUsuario" />
          
         <p align="right">
          
          Validade da Assinatura<br>
          <span class="validadeAssinatura">
          	18/04/2016
          </span>
         
         </p>
          <p> 
          <div class="row">
              <div class="col-md-12">
              	<div class="col-md-3">
                    Plano<br>
                    <div class="input-prepend">
                        <select name="plano" class="uniformselect">
                            	<option value="" />Free - R$ 5,00 ao mês
                                <option value="" />Lite - R$ 40,00 ao mês
                                <option value="" />Professional - R$ 80,00
                                <option value="" />Premium - R$ 140,00 ao mês
                                <option value="" />Ultimate - R$ 240,00 ao mês
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    Qnt. Lojas<br>
                    <div class="input-prepend">
                        <input type="text" name="qntLojas" class="input-small" disabled />
                    </div>
                </div>
                <div class="col-md-2">
                    Qnt. meses<br>
                    <div class="input-prepend">
                        <input type="text" name="qntMeses" class="input-small" />
                    </div>
                </div>
                <div class="col-md-2">
                    Total<br>
                    <div class="input-prepend">
                        <input type="text" name="total" class="input-small" disabled />
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="input-prepend">
                        <img src="images/botao_paypal.png" alt="">
                    </div>
                </div>
              </div>
          </div>
          </p>
       
       
          </form>
          <div class="divider30"></div>
          <h3>Pagamentos Realizados</h3>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th width="11%">Id Transação</th>
                <th width="13%">Data</th>
                <th width="8%">Plano</th>
                <th width="10%">Quantidade</th>
                <th width="11%">Valor Unitário</th>
                <th width="11%">Valor Total</th>
                <th width="11%">Tipo Pagamento</th>
                <th width="12%">Status Transação</th>
                <th width="13%">Status Pagamento</th>
              </tr>
            </thead>
            <tbody>
            	
                <tr>
                <td></td>
                <td>18/03/2016 14:49:05	</td>
                <td>Free</td>
                <td>1</td>
                <td>5,00</td>
                <td>5,00</td>
                <td></td>
                <td>Pendente</td>
                <td>INPROGRESS</td>
              </tr>
         
			
              <tr>
                <td>7GF56687YD411771C</td>
                <td>18/03/2016 14:49:07	</td>
                <td>Free</td>
                <td>1</td>
                <td>5,00</td>
                <td>5,00</td>
                <td>INSTANT</td>
                <td>Sucesso</td>
                <td>COMPLETED</td>
              </tr>
          
              
            </tbody>
          </table>
          <h3>Formas de Pagamentos disponíveis no Paypal</h3>
          <div>
          <img src="images/americanexpress.png" alt="">
          <img src="images/mastercard.png" alt="">
          <img src="images/visa.png" alt="">
          </div>
        </div>
       
            </div><!--widget-->
        <?php include_once('footer.php');?>