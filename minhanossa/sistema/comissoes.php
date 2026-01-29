<?php 
include('restrito.php');
include('Connections/conexao.php');
include('funcoes.php');

include('class/html.php');
$HTML = new HTML;

$currentPage = 'provas.php';

mysql_select_db($database_conexao, $conexao);
$query_rs_vendedores = "SELECT * FROM tbl_admin ORDER BY nome ASC";
$rs_vendedores = mysql_query($query_rs_vendedores, $conexao) or die(mysql_error());
$row_rs_vendedores = mysql_fetch_assoc($rs_vendedores);
$totalRows_rs_vendedores = mysql_num_rows($rs_vendedores);

if($_GET['dataInicio'] <> ''){
	$sql .= "and date(tbl_contrato.data_contrato) >= '".formataDataSQL($_GET['dataInicio'])."'";
}

if($_GET['dataFim'] <> ''){
	$sql .= "and date(tbl_contrato.data_contrato) <= '".formataDataSQL($_GET['dataFim'])."'";
}

if($_GET['id_vendedor'] <> ''){
	$sql .= "and tbl_comissoes.id_user_vendedor = '".$_GET['id_vendedor']."'";
}

mysql_select_db($database_conexao, $conexao);
$query_rs_comissoes = "
SELECT
	tbl_comissoes.*,
	tbl_cliente.nome as nomeCliente,
	tbl_contrato.data_contrato,
	(SELECT sum(valor_pagamento) FROM `tbl_pagamento` where tbl_pagamento.id_contrato = tbl_comissoes.id_contrato) as totalContrato
FROM
	tbl_comissoes
	inner join tbl_contrato on tbl_comissoes.id_contrato = tbl_contrato.id
	left join tbl_cliente on tbl_contrato.codigo_cliente = tbl_cliente.id
where 
	1=1 $sql
ORDER BY 
	tbl_comissoes.id DESC";
$rs_comissoes = mysql_query($query_rs_comissoes, $conexao) or die(mysql_error());
$row_rs_comissoes = mysql_fetch_assoc($rs_comissoes);
$totalRows_rs_comissoes = mysql_num_rows($rs_comissoes);
?>
<!DOCTYPE html>
<html>
<head>

<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Relat&oacute;rios > Comiss&otilde;es</title>

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
<style type="text/css">
body,td,th {
	font-family: RobotoRegular, "Helvetica Neue", Helvetica, sans-serif;
}
</style>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9" /></head>

<body>
<?php //include_once('head.php');?>

<div class="mainwrapper">
<?php include_once('header.php');?>
<?php include_once('inc_coluna.php');?>
<div class="rightpanel">
  <ul class="breadcrumbs">
    <li><a href="."><i class="iconfa-home"></i></a> <span class="separator"></span></li>
    <li><a href="provas.php">Comiss&otilde;es</a></li>
    
  </ul>
  <div class="pageheader">
  
    	<a href="add_contrato.php"class="btn btn-primary btn-mini searchbar"> <i class="icon-plus"></i> &nbsp; Novo</a>
    
    <div class="pageicon"><span class="iconfa-edit"></span></div>
    <div class="pagetitle" >
      <h5>Agenda</h5>
      <h1>Comiss&otilde;es</h1>
    </div>
    
    
    
  </div>
  <!--pageheader-->
  <div class="maincontent">
    <div class="maincontentinner">
      <div class="widget">
        <h4 class="widgettitle"><span class="icon-calendar"></span>Comiss&otilde;es</h4>
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
                                      <span class="add-on">Vendedor</span>
                                   
                            
                                      <select name="id_vendedor" id="id_vendedor" style="height:32px;" >
                                      	<option value=""></option>
										<?php do { ?>
                                        <option value="<?=$row_rs_vendedores['id'];?>" <?php if($row_rs_vendedores['id'] == $_GET['id_vendedor']) { echo 'selected'; } ?>><?=$row_rs_vendedores['nome'];?></option>
                                        <? } while($row_rs_vendedores = mysql_fetch_assoc($rs_vendedores)); ?>
                                      </select>
                                   </div>
                                      
                                      
                                
                            </li>
                            <li class="left newfilebtn"><a href="javascript:;" onClick="document.getElementById('formProvas').submit()" class="btn btn-primary"  style="padding:4px; margin-left:10px;">Pesquisar</a></li>
                        </ul>
            </form>
                        <span class="clearall"></span>
                    </div>
         <?php if($totalRows_rs_comissoes > 0) { ?>
          <table class="table table-bordered">
           
            <tbody>
              
              <tr>
                <td width="9%" style="text-align:center"><strong>Contrato</strong></td>
                <td width="14%" style="text-align:center"><strong>Data</strong></td>
                <td width="40%" ><strong>Cliente</strong></td>
                <td width="12%" style="text-align:center"><strong>Comiss&atilde;o</strong></td>
                <td width="12%" style="text-align:center"><strong>Valor Venda</strong></td>
                <td style="text-align:center"><strong>Op&ccedil;&otilde;es</strong></td>
               
              </tr>
            
            <?php
			if($totalRows_rs_comissoes > 0){
			 do{
		     ?>
              <tr>
                <td style="text-align:center"><?php echo $row_rs_comissoes['id_contrato'];?></td>
                <td style="text-align:center"><?php echo formataData($row_rs_comissoes['data_contrato']).' às '.substr($row_rs_comissoes['data_contrato'],11,5);?></td>
                <td ><?php echo $row_rs_comissoes['nomeCliente'];?></td>
                <td style="text-align:center"><?php 
					$totaComissao += $row_rs_comissoes['valor_comissao'];
					echo number_format($row_rs_comissoes['valor_comissao'],2,',','.');?></td>
                <td style="text-align:center"><?php 
					$totalVenda =+ $row_rs_comissoes['totalContrato'];
					echo number_format($row_rs_comissoes['totalContrato'],2,',','.');?></td>
                <td width="13%" style="text-align:center"><a href="editar_contrato.php?id=<?php echo $row_rs_comissoes['id_contrato'];?>"class="btn btn-primary btn-mini"> <i class="icon-pencil"></i> &nbsp; Visualizar
                    
                    </a></td>
                
                
              </tr>
             
            <?php }while($row_rs_comissoes = mysql_fetch_assoc($rs_comissoes)); ?>
             <tr>
                <td colspan="3" style="text-align:right"><strong>Total:</strong>&nbsp;</td>
                <td style="text-align:center"><?=number_format($totaComissao,2,',','.');?></td>
                <td style="text-align:center"><?=number_format($totalVenda,2,',','.');?></td>
                <td style="text-align:center">&nbsp;</td>
              </tr>
              <?
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
        <!--widgetcontent-<?php
mysql_free_result($rs_vendedores);
?>->
            </div><!--widget-->
        <?php include_once('footer.php');?>