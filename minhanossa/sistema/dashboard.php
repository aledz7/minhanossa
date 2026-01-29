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
<?php include_once('head.php');?>

<div class="mainwrapper">
<?php include_once('header.php');?>
<?php include_once('inc_coluna.php');?>
<div class="rightpanel">
  <ul class="breadcrumbs">
    <li><a href="."><i class="iconfa-home"></i></a> <span class="separator"></span></li>
    <li><a href="dashboard.php">Vendas</a></li>
    
  </ul>
  <div class="pageheader">
    <!--<form action="results.html" method="post" class="searchbar" />
                <input type="text" name="keyword" placeholder="To search type and hit enter..." />
            </form>-->
    <div class="pageicon"><span class="iconfa-edit"></span></div>
    <div class="pagetitle">
      <h5>Dashboard</h5>
      <h1>Dashboard</h1>
    </div>
  </div>
  <!--pageheader-->
  <div class="maincontent">
    <div class="maincontentinner">
      <div class="widget">
        <h4 class="widgettitle"><span class="iconfa-bar-chart"></span>Dashboard de Vendas</h4>
        <div class="widgetcontent">
          <form class="stdform" action="" method="get" name="formSearchUsuario" />
          
          <p>          
          <span class="field">
          
          <div class="row">
              <div class="col-md-3">
              	<input type="date" name="buscaDataInicio" class="input-large" placeholder="Data Início" />
              </div>
              <div class="col-md-3">
              	<input type="date" name="buscaDataInicio" class="input-large" placeholder="Data Fim" />
              </div>
              <div class="col-md-2">
              	<select name="buscaLoja" class="uniformselect">
                    <option value="A">Louise Noivas</option>
                    <option value="I">Inativo</option>
              	</select>
              </div>
              <div class="col-md-2">
              	<a href="add_usuario.php" class="btn btn-primary btn-mini"> <i class="icon-search"></i>&nbsp; Consultar</a>
              </div>
          </div>
          </span>
          </p>
         </form>
         
          <div class="divider30"></div>
       
          <table class="table table-bordered">
            <tbody>
            
            
			  <tr>
                <td colspan="5"><h3>Vendas Mensais</h3></td>
              </tr>
              <tr>
                <td colspan="5"></td>
              </tr>
              
            </tbody>
          </table>
        </div>
        <!--widgetcontent-<?php
mysql_free_result($rs_usuario);
?>->
            </div><!--widget-->
        <?php include_once('footer.php');?>