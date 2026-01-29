<?php 
include('restrito.php');
include('Connections/conexao.php');
include('funcoes.php');

$currentPage = 'contrato_cadastro.php';

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
$query_rs_cliente = "SELECT * FROM tbl_admin WHERE id is not null $sql ORDER BY nome ASC";
$rs_cliente = mysql_query($query_rs_cliente, $conexao) or die(mysql_error());
$row_rs_cliente = mysql_fetch_assoc($rs_cliente);
$totalRows_rs_cliente = mysql_num_rows($rs_cliente);

mysql_select_db($database_conexao, $conexao);
$query_rs_contas_pagar = "SELECT * FROM tbl_contas_pagar ORDER BY data_conta ASC";
$rs_contas_pagar = mysql_query($query_rs_contas_pagar, $conexao) or die(mysql_error());
$row_rs_contas_pagar = mysql_fetch_assoc($rs_contas_pagar);
$totalRows_rs_contas_pagar = mysql_num_rows($rs_contas_pagar);
?>
<!DOCTYPE html>
<html>
<head>

<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Cadastro de Contas a Pagar</title>

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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>

<body>
<?php //include_once('head.php');?>

<div class="mainwrapper">
<?php include_once('header.php');?>
<?php include_once('inc_coluna.php');?>
<div class="rightpanel">
  <ul class="breadcrumbs">
    <li><a href="."><i class="iconfa-home"></i></a> <span class="separator"></span></li>
    <li><a href="contas_pagar.php">Contas a Pagar</a></li>
    
  </ul>
  <div class="pageheader">
  
    	<a href="add_contas_pagar.php"class="btn btn-primary btn-mini searchbar"> <i class="icon-plus"></i> &nbsp; Novo</a>
    
    <!--<form action="results.html" method="post" class="searchbar" />
                <input type="text" name="keyword" placeholder="To search type and hit enter..." />
            </form>-->
    <div class="pageicon"><span class="iconfa-edit"></span></div>
    <div class="pagetitle" >
      <h5>Cadastro</h5>
      <h1>Contas a Pagar</h1>
    </div>
    
    
    
  </div>
  <!--pageheader-->
  <div class="maincontent">
    <div class="maincontentinner">
      <div class="widget">
        <h4 class="widgettitle"><span class="iconfa-shopping-cart"></span>Contas a Pagar</h4>
        <div class="widgetcontent">
        
          <div class="divider30"></div>
          <table class="table table-bordered">
           
            <tbody>
            
            <tr>
                <td width="55%"><input type="text" name="buscaCodigo" class="input-small" placeholder="Código" /></td>
                <td width="26%"><input type="text" name="buscaNome" class="input-medium" placeholder="Nome" /></td>
                <td colspan="2">
                </td>
            </tr>
              
              <tr>
                <td><strong>Data Conta</strong></td>
                <td><strong>Valor total</strong></td>
                <td colspan="2">&nbsp;</td>
              </tr>
            
            <?php
			if($totalRows_rs_contas_pagar > 0){
			 do{
				 $valorTotal = $row_rs_contas_pagar['valor_total'];
				 ?>
              <tr>
                <td><?php echo substr($row_rs_contas_pagar['data_conta'],8,2);?> / <?php echo substr($row_rs_contas_pagar['data_conta'],5,2);?> / <?php echo substr($row_rs_contas_pagar['data_conta'],0,4);?></td>
                <td><?php echo number_format($valorTotal,2,',','.');?></td>
                <td width="11%" class="centeralign">
                    <a href="editar_contas_pagar.php?id=<?php echo $row_rs_contas_pagar['id'];?>"class="btn btn-primary btn-mini"> <i class="icon-pencil"></i> &nbsp; Editar
                    
                    </a>
                </td>
                <td width="8%">
                	<a href="sql_excluir.php?id=<?php echo $row_rs_contas_pagar['id']; ?>&acao=excluirContasPagar" class="btn btn-danger btn-mini"> <i class="iconfa-remove"></i> Excluir
                    </a>
				</td>
              </tr>
            <?php
			$total += $valorTotal;
			 }while($row_rs_contas_pagar = mysql_fetch_assoc($rs_contas_pagar));
			
			
			
			?>
			
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              	<td colspan="2"><strong>Total: <?php echo number_format($total,2,',','.'); ?></strong></td>
              </tr>
			
			<?php
			}
			?>
            
              
            </tbody>
          </table>
        </div>
        <!--widgetcontent-<?php
mysql_free_result($rs_contas_pagar);
?>->
            </div><!--widget-->
        <?php include_once('footer.php');?>