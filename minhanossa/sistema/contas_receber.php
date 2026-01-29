<?php 
include('restrito.php');
include('Connections/conexao.php');
include('funcoes.php');

$currentPage = 'contrato_cadastro.php';


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
$query_rs_contas = "SELECT * FROM tbl_contas ORDER BY data_vencimento ASC";
$rs_contas = mysql_query($query_rs_contas, $conexao) or die(mysql_error());
$row_rs_contas = mysql_fetch_assoc($rs_contas);
$totalRows_rs_contas = mysql_num_rows($rs_contas);
?>
<!DOCTYPE html>
<html>
<head>

<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Financeiro > Contas</title>

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
    <li><a href="contas_receber.php">Contas a Receber</a></li>
    
  </ul>
  <div class="pageheader">
  
    	<a href="add_contas_receber.php"class="btn btn-primary btn-mini searchbar"> <i class="icon-plus"></i> &nbsp; Novo</a>
    
    <!--<form action="results.html" method="post" class="searchbar" />
                <input type="text" name="keyword" placeholder="To search type and hit enter..." />
            </form>-->
    <div class="pageicon"><span class="iconfa-edit"></span></div>
    <div class="pagetitle" >
      <h5>Cadastro</h5>
      <h1>Contas a Receber</h1>
    </div>
    
    
    
  </div>
  <!--pageheader-->
  <div class="maincontent">
    <div class="maincontentinner">
      <div class="widget">
        <h4 class="widgettitle"><span class="iconfa-shopping-cart"></span>Contas a Receber</h4>
        <div class="widgetcontent">
        
          <div class="divider30"></div>
          <table class="table table-bordered">
           
            <tbody>
            
            
              
              <tr>
                <td><strong>Data Emissão</strong></td>
                <td><strong>Data Vencimento</strong></td>
                <td width="25%"><strong>Valor total</strong></td>
                <td colspan="2">&nbsp;</td>
              </tr>
            
            <?php
			if($totalRows_rs_contas > 0){
			 do{?>
              <tr>
                <td><?php echo substr($row_rs_contas['data_emissao'],8,2);?> / <?php echo substr($row_rs_contas['data_emissao'],5,2);?> / <?php echo substr($row_rs_contas['data_emissao'],0,4);?></td>
                <td><?php echo substr($row_rs_contas['data_vencimento'],8,2);?> / <?php echo substr($row_rs_contas['data_vencimento'],5,2);?> / <?php echo substr($row_rs_contas['data_vencimento'],0,4);?></td>
                <td><?php echo number_format($row_rs_contas['valor_total'],2,',','.');?></td>
                <td width="10%" class="centeralign">
                    <a href="editar_contas_receber.php?id=<?php echo $row_rs_contas['id'];?>"class="btn btn-primary btn-mini"> <i class="icon-pencil"></i> &nbsp; Editar
                    
                    </a>
                </td>
                <td width="8%">
                	<a href="sql_excluir.php?id=<?php echo $row_rs_contas['id']; ?>&acao=excluirContasReceber" class="btn btn-danger btn-mini"> <i class="iconfa-remove"></i> Excluir
                    </a>
				</td>
              </tr>
            <?php 
			$total += $row_rs_contas['valor_total'];
			}while($row_rs_contas = mysql_fetch_assoc($rs_contas));
			
			
			
			?>
			
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              	<td colspan="3"><strong>Total: <?php echo number_format($total,2,',','.'); ?></strong></td>
              </tr>
			
			<?php
			}
			?>
            
              
            </tbody>
          </table>
        </div>
        <!--widgetcontent-<?php
mysql_free_result($rs_contas);
?>->
            </div><!--widget-->
        <?php include_once('footer.php');?>