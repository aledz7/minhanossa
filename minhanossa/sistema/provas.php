<?php 
include('restrito.php');
include('Connections/conexao.php');
include('funcoes.php');

include('class/html.php');
$HTML = new HTML;

$currentPage = 'provas.php';

mysql_select_db($database_conexao, $conexao);
$query_rs_cliente = "SELECT * FROM tbl_cliente where id = '{$_GET['codigo_cliente']}'";
$rs_cliente = mysql_query($query_rs_cliente, $conexao) or die(mysql_error());
$row_rs_cliente = mysql_fetch_assoc($rs_cliente);
$totalRows_rs_cliente = mysql_num_rows($rs_cliente);

if($_GET['tipo'] == 'Provas') {
	$campoBusca = "data_prova";
}

if($_GET['dataInicio'] <> ''){
	$sql .= "and {$campoBusca} >= '".formataDataSQL($_GET['dataInicio'])."'";
}

if($_GET['dataFim'] <> ''){
	$sql .= "and {$campoBusca} <= '".formataDataSQL($_GET['dataFim'])."'";
}

if($_GET['id_cliente'] <> ''){
	$sql .= "and tbl_contrato.codigo_cliente = '".$_GET['id_cliente']."'";
}

mysql_select_db($database_conexao, $conexao);
$query_rs_provas = "
SELECT
	tbl_item.*,
	tbl_produto.nome as nomeProduto
FROM
	tbl_item
	inner join tbl_contrato on tbl_item.id_contrato = tbl_contrato.id
	left join tbl_produto on tbl_item.nome_produto = tbl_produto.id
where 
	1=1 $sql
ORDER BY 
	data_prova ASC";
$rs_provas = mysql_query($query_rs_provas, $conexao) or die(mysql_error());
$row_rs_provas = mysql_fetch_assoc($rs_provas);
$totalRows_rs_provas = mysql_num_rows($rs_provas);
?>
<!DOCTYPE html>
<html>
<head>

<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Agenda > <?=$_GET['tipo'];?></title>

<link rel="stylesheet" href="css/style.default.css" type="text/css" />
<link rel="stylesheet" href="css/bootstrap-fileupload.min.css" type="text/css" />
<link rel="stylesheet" href="css/bootstrap-timepicker.min.css" type="text/css" />

<script type="text/javascript" src="jquery.js"></script>

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

<script type="text/javascript" src="load.js"></script>
<? include('dialog-jquery/inc-abre-janela.php');?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9" /></head>

<body>
<?php //include_once('head.php');?>

<div class="mainwrapper">
<?php include_once('header.php');?>
<?php include_once('inc_coluna.php');?>
<div class="rightpanel">
  <ul class="breadcrumbs">
    <li><a href="."><i class="iconfa-home"></i></a> <span class="separator"></span></li>
    <li><a href="provas.php"><?=$_GET['tipo'];?></a></li>
    
  </ul>
  <div class="pageheader">
  
    	<a href="add_contrato.php"class="btn btn-primary btn-mini searchbar"> <i class="icon-plus"></i> &nbsp; Novo</a>
    
    <div class="pageicon"><span class="iconfa-edit"></span></div>
    <div class="pagetitle" >
      <h5>Agenda</h5>
      <h1><?=$_GET['tipo'];?></h1>
    </div>
    
    
    
  </div>
  <!--pageheader-->
  <div class="maincontent">
    <div class="maincontentinner">
      <div class="widget">
        <h4 class="widgettitle"><span class="icon-calendar"></span>Agenda de <?=$_GET['tipo'];?></h4>
        <div class="widgetcontent">
        
         
         <div class="mediamgr_head">
					<form method="get" enctype="application/x-www-form-urlencoded" id="formProvas">
                    	<ul class="mediamgr_menu">
                            <li class="filesearch">
                            		<div class="input-prepend">
                                      <span class="add-on">Data de In&iacute;cio</span>
                                      <input id="dataInicio" type="text" name="dataInicio" class="input-small datepicker" style="padding:5px;" value="<?=$_GET['dataInicio'];?>" />                                    </div>
                                   
                                   
                                   <div class="input-prepend">
                                      <span class="add-on">Data Final</span>
                                      <input id="dataFim" value="<?=$_GET['dataFim'];?>" style="padding:5px;" type="text" name="dataFim" class="input-small datepicker" />                                    </div>
                                   
                                   
                                   <div class="input-prepend">
                                      <span class="add-on">Cliente</span>
                                       </div>
                                       <style>
									   #id_cliente {
										   height:22px;
										   margin-top:2px;
										   margin-left:-2px;
										   border-left:none;
									   }
									   </style>
                                   <?php 
$_GET['label'] = $row_rs_cliente['nome'];
$_GET['idAtual'] = $_GET['id_cliente'];
buscaGenericad('id_cliente', 'id', '', 'Clientes', 'nome', $javascript, 'tbl_cliente', $concatCampos, $where);?>
                                  
                                      
                                      
                                
                            </li>
                            <li class="left newfilebtn"><a href="javascript:;" onClick="document.getElementById('formProvas').submit()" class="btn btn-primary"  style="padding:4px; margin-left:10px;">Pesquisar</a></li>
                            <li class="left newfilebtn"><a href="javascript:;" onClick="window.location='imprimir-provas.php?tipo=<?php echo $_GET['tipo'];?>&dataInicio=<?php echo $_GET['dataInicio'];?>&dataFim=<?php echo $_GET['dataFim'];?>&id_cliente=<?php echo $_GET['id_cliente'];?>'" class="btn btn-primary"  style="padding:4px; margin-left:10px;">Imprimir</a></li>
                        </ul>
                        <input type="hidden" name="tipo" value="<?=$_GET['tipo'];?>">
            </form>
                        <span class="clearall"></span>
                    </div>
         <?php if($totalRows_rs_provas > 0) { ?>
          <table class="table table-bordered">
           
            <tbody>
              
              <tr>
                <td width="31%"><strong>Cliente</strong></td>
                <td width="27%"><strong>Nome do Produto</strong></td>
                <td width="5%" style="text-align:center"><strong>QTD</strong></td>
                <td width="13%"><strong>Data Prova</strong></td>
                <td width="12%"><strong>Retirada</strong></td>
                <td style="text-align:center"><strong>Op&ccedil;&otilde;es</strong></td>
               
              </tr>
            
            <?php
			if($totalRows_rs_provas > 0){
			 do{
				mysql_select_db($database_conexao, $conexao);
$query_rs_nome_cliente = "SELECT * FROM tbl_cliente WHERE id = '".$row_rs_provas['id_cliente']."'";
$rs_nome_cliente = mysql_query($query_rs_nome_cliente, $conexao) or die(mysql_error());
$row_rs_nome_cliente = mysql_fetch_assoc($rs_nome_cliente);
$totalRows_rs_nome_cliente = mysql_num_rows($rs_nome_cliente); 
		     ?>
              <tr>
                <td><?php echo $row_rs_nome_cliente['nome'];?></td>
                <td><?php echo $row_rs_provas['nomeProduto'];?></td>
                <td style="text-align:center"><?php echo $row_rs_provas['quantidade_produto'];?></td>
                <td><?php echo substr($row_rs_provas['data_prova'],8,2);?> / <?php echo substr($row_rs_provas['data_prova'],5,2);?> / <?php echo substr($row_rs_provas['data_prova'],0,4);?></td>
                <td><?php echo substr($row_rs_provas['data_retirada'],8,2);?> / <?php echo substr($row_rs_provas['data_retirada'],5,2);?> / <?php echo substr($row_rs_provas['data_retirada'],0,4);?></td>
                <td width="12%" style="text-align:center"><a href="editar_contrato.php?id=<?php echo $row_rs_provas['id_contrato'];?>"class="btn btn-primary btn-mini"> <i class="icon-pencil"></i> &nbsp; Visualizar
                    
                    </a></td>
                
                
              </tr>
            <?php }while($row_rs_provas = mysql_fetch_assoc($rs_provas));
			}
			?>
              
            </tbody>
          </table>
          <? 
		  } else { 
		  	$HTML->nenhumRegistro();
		  }
		  ?>
          
        </div>
      
            </div><!--widget-->
<?php include_once('footer.php');?>