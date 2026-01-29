<?php 
include('restrito.php');
include('Connections/conexao.php');
include('funcoes.php');

$currentPage = 'visualizar_locacao.php';

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
$query_rs_produto = "SELECT * FROM tbl_produto WHERE id is not null $sql ORDER BY nome ASC";
$rs_produto = mysql_query($query_rs_produto, $conexao) or die(mysql_error());
$row_rs_produto = mysql_fetch_assoc($rs_produto);
$totalRows_rs_produto = mysql_num_rows($rs_produto);
?>
<?php include_once('head.php');?>

<div class="mainwrapper">
<?php include_once('header.php');?>
<?php include_once('inc_coluna.php');?>
<div class="rightpanel">
  <ul class="breadcrumbs">
    <li><a href="."><i class="iconfa-home"></i></a> <span class="separator"></span></li>
    <li><a href="produto.php">Produto</a></li>
    
  </ul>
  <div class="pageheader">
  
    	
    
    <!--<form action="results.html" method="post" class="searchbar" />
                <input type="text" name="keyword" placeholder="To search type and hit enter..." />
            </form>-->
    <div class="pageicon"><span class="iconfa-edit"></span></div>
    <div class="pagetitle" >
      <h5>Produto</h5>
      <h1>Locações</h1>
    </div>
    
    
    
  </div>
  <!--pageheader-->
  <div class="maincontent">
    <div class="maincontentinner">
      <div class="widget">
        <h4 class="widgettitle"><span class="iconfa-edit"></span>Locações</h4>
        <div class="widgetcontent">
        
          <div class="divider30"></div>
          <div class="alert alert-info">
                              <button data-dismiss="alert" class="close" type="button">&times;</button>
                              <h3><strong>Produto disponível para locação</strong></h3>
                            </div>
          <h3>
          	Locações para o produto: 40151 - VESTIDO DE FESTA
          </h3>
          <table class="table table-bordered">
            
            <thead>
                        <tr>
                            <th>Reserva</th>
                            <th>Cliente</th>
                            <th>Quantidade</th>
                            <th>Retirada</th>
                            <th>Devolução</th>
                        </tr>
            </thead>
            <tbody>
            
           <?php
			if($totalRows_rs_produto > 0){
			 do{?>
              <tr>
                <td><?php echo $row_rs_produto['id'];?></td>
                <td><?php echo $row_rs_produto['nome'];?></td>
                <td><?php echo $row_rs_produto['categoria'];?></td>
                <td><?php echo number_format($row_rs_produto['preco_custo'],2,',','.');?></td>
                <td><?php echo $row_rs_produto['qnt_estoque'];?></td>
              </tr>
            <?php }while($row_rs_produto = mysql_fetch_assoc($rs_produto));
			}
			?>
              
            </tbody>
          </table>
        </div>
        <!--widgetcontent-<?php
mysql_free_result($rs_produto);
?>->
            </div><!--widget-->
        <?php include_once('footer.php');?>