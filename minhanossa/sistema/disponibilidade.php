<?php 
include('restrito.php');
include('Connections/conexao.php');
include('funcoes.php');

include('class/html.php');
$HTML = new HTML;

$currentPage = 'provas.php';

mysql_select_db($database_conexao, $conexao);
$query_rs_produtos = "SELECT * FROM tbl_produto ORDER BY nome ASC";
$rs_produtos = mysql_query($query_rs_produtos, $conexao) or die(mysql_error());
$row_rs_produtos = mysql_fetch_assoc($rs_produtos);
$totalRows_rs_produtos = mysql_num_rows($rs_produtos);

if($_GET['dataEvento'] <> ''){
	$sql .= "and tbl_item.data_devolucao >= '".formataDataSQL($_GET['dataEvento'])."'";
}

if($_GET['id_produto'] <> ''){
	$sql .= " and tbl_item.nome_produto = '".$_GET['id_produto']."'";
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
	tbl_item.data_prova ASC";
$rs_provas = mysql_query($query_rs_provas, $conexao) or die(mysql_error());
$row_rs_provas = mysql_fetch_assoc($rs_provas);
$totalRows_rs_provas = mysql_num_rows($rs_provas);

?>
<!DOCTYPE html>
<html>
<head>

<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Agenda > Provas</title>

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
    <li><a href="provas.php">Disponibilidade</a></li>
    
  </ul>
  <div class="pageheader">
  
    	<a href="add_contrato.php"class="btn btn-primary btn-mini searchbar"> <i class="icon-plus"></i> &nbsp; Novo</a>
    
    <div class="pageicon"><span class="iconfa-edit"></span></div>
    <div class="pagetitle" >
      <h5>PRODUTOS</h5>
      <h1>Disponibilidade</h1>
    </div>
    
    
    
  </div>
  <!--pageheader-->
  <div class="maincontent">
    <div class="maincontentinner">
      <div class="widget">
        <h4 class="widgettitle"><span class="icon-calendar"></span>Agenda de Provas</h4>
        <div class="widgetcontent">
        
         
         <div class="mediamgr_head">
					<form method="get" enctype="application/x-www-form-urlencoded" id="formProvas">
                    	<ul class="mediamgr_menu">
                            <li class="filesearch">
                            		<div class="input-prepend">
                                      <span class="add-on">Data de Utiliza&ccedil;&atilde;o</span>
                                      <input id="dataEvento" type="text" name="dataEvento" class="input-small datepicker" style="padding:5px;" value="<?=$_GET['dataEvento'];?>" />                                    </div>
                                   
                                   
                                   
                              <div class="input-prepend">
                                      <span class="add-on">Produto / Traje</span>
                                   
                            
                                      <select name="id_produto" id="id_produto" style="height:32px;" >
                                      	<option value=""></option>
										<?php do { ?>
                                        <option value="<?=$row_rs_produtos['id'];?>" <?php if($row_rs_produtos['id'] == $_GET['id_produto']) { echo 'selected'; } ?>><?=$row_rs_produtos['nome'];?></option>
                                        <? } while($row_rs_produtos = mysql_fetch_assoc($rs_produtos)); ?>
                                      </select>
                                   </div>
                                      
                                      
                                
                            </li>
                            <li class="left newfilebtn"><a href="javascript:;" onClick="document.getElementById('formProvas').submit()" class="btn btn-primary"  style="padding:4px; margin-left:10px;">Pesquisar</a></li>
                        </ul>
            </form>
                        <span class="clearall"></span>
                    </div>
         <?php if(count($row_rs_provas) > 0) { ?>
          <table class="table table-bordered">
           
            <tbody>
              
              <tr>
                <td width="31%"><strong>Cliente</strong></td>
                <td width="5%" style="text-align:center"><strong>QTD</strong></td>
                <td width="13%"><strong>Retirada</strong></td>
                <td width="12%"><strong>Devolu&ccedil;&atilde;o</strong></td>
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
                <td><? if($row_rs_provas['id_cliente'] <> ''){ echo $row_rs_nome_cliente['nome'];} else echo 'Lavanderia'?></td>
                <td style="text-align:center"><?php echo $row_rs_provas['quantidade_produto'];?></td>
                <td><?php echo formataData($row_rs_provas['data_retirada']);?></td>
                <td><?php echo formataData($row_rs_provas['data_devolucao']);?></td>
                <td width="12%" style="text-align:center">
					<a href="editar_contrato.php?id=<?php echo $row_rs_provas['id_contrato'];?>"class="btn btn-primary btn-mini">
						<i class="icon-pencil"></i> &nbsp; Visualizar</a>
				</td>
              </tr>
            <?php }while($row_rs_provas = mysql_fetch_assoc($rs_provas));
			}
			?>
              
            </tbody>
          </table>
          <? 
		  } else { 
		  	?>
            <div align="center" style="margin-bottom:27px; font-size:15px; color:#00724C">Produto / Traje dispon&iacute;vel.</div>
            <?
		  }
		  ?>
          
        </div>
        <!--widgetcontent-<?php
mysql_free_result($rs_produtos);
?>->
            </div><!--widget-->
        <?php include_once('footer.php');?>