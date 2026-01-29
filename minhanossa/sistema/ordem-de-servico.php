<?php 
include('restrito.php');
include('Connections/conexao.php');
include('funcoes.php');

if($_GET['acao'] == 'excluir') {
	mysql_select_db($database_conexao, $conexao);
	$deleteSQL = sprintf("DELETE FROM tbl_ordem_servico WHERE id=%s",
                       GetSQLValueString($_GET['id'], "int"));
	$Result1 = mysql_query($deleteSQL, $conexao) or die(mysql_error());	
	
	echo "	<script>
			window.location='ordem-de-servico.php';
			</script>";
			exit;
}

include('class/html.php');
$HTML = new HTML;

$currentPage = 'provas.php';

mysql_select_db($database_conexao, $conexao);
$query_rs_produtos = "SELECT * FROM tbl_produto ORDER BY nome ASC";
$rs_produtos = mysql_query($query_rs_produtos, $conexao) or die(mysql_error());
$row_rs_produtos = mysql_fetch_assoc($rs_produtos);
$totalRows_rs_produtos = mysql_num_rows($rs_produtos);

if($_GET['dataInicio'] <> ''){
	$sql .= "and date(tbl_ordem_servico.data_entrada) >= '".formataDataSQL($_GET['dataInicio'])."'";
}

if($_GET['dataFim'] <> ''){
	$sql .= " and date(tbl_ordem_servico.data_entrada) <= '".formataDataSQL($_GET['dataFim'])."'";
}

if($_GET['id_produto'] <> ''){
	$sql .= " and tbl_ordem_servico.id_produto = '".$_GET['id_produto']."'";
}

mysql_select_db($database_conexao, $conexao);
$query_rs_ordens_de_servico = "
SELECT
	tbl_ordem_servico.*,
	tbl_produto.nome as nomeProduto
FROM
	tbl_ordem_servico
	left join tbl_produto on tbl_ordem_servico.id_produto = tbl_produto.id
where 
	1=1 $sql
ORDER BY 
	tbl_ordem_servico.id DESC";
$rs_ordens_de_servico = mysql_query($query_rs_ordens_de_servico, $conexao) or die(mysql_error());
$row_rs_ordens_de_servico = mysql_fetch_assoc($rs_ordens_de_servico);
$totalRows_rs_ordens_de_servico = mysql_num_rows($rs_ordens_de_servico);
?>
<!DOCTYPE html>
<html>
<head>

<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Ordem de Serviço</title>

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
    <li><a href="provas.php">Ordem de Serviço</a></li>
    
  </ul>
  <div class="pageheader">
  
    	<a href="add-ordem-de-servico.php"class="btn btn-primary btn-mini searchbar"> <i class="icon-plus"></i> &nbsp; Novo</a>
    
    <div class="pageicon"><span class="iconfa-edit"></span></div>
    <div class="pagetitle" >
      <h5></h5>
      <h1>Ordem de Serviço</h1>
    </div>
    
    
    
  </div>
  <!--pageheader-->
  <div class="maincontent">
    <div class="maincontentinner">
      <div class="widget">
        <h4 class="widgettitle"><span class="icon-calendar"></span>Ordem de Serviço</h4>
        <div class="widgetcontent">
        
         
         <div class="mediamgr_head">
					<form method="get" enctype="application/x-www-form-urlencoded" id="formProvas">
                    	<ul class="mediamgr_menu">
                            <li class="filesearch">
                            		<div class="input-prepend">
                                      <span class="add-on">Data de In&iacute;cio</span>
                                      <input id="dataInicio" type="text" name="dataInicio" class="input-small datepicker" style="padding:5px;" value="<?php echo $_GET['dataInicio'];?>" />                                    </div>
                                   
                                   
                                   <div class="input-prepend">
                                      <span class="add-on">Data Final</span>
                                      <input id="dataFim" value="<?php echo $_GET['dataFim'];?>" style="padding:5px;" type="text" name="dataFim" class="input-small datepicker" />                                    </div>
                                   
                                   
                                   <div class="input-prepend">
                                      <span class="add-on">Produto</span>
                                   
                            
                                      <select name="id_produto" id="id_produto" style="height:32px;" >
                                      	<option value=""></option>
										<?php do { ?>
                                        <option value="<?php echo $row_rs_produtos['id'];?>" <?php if($row_rs_produtos['id'] == $_GET['id_produto']) { echo 'selected'; } ?>><?php echo utf8_decode($row_rs_produtos['nome']);?></option>
                                        <?php } while($row_rs_produtos = mysql_fetch_assoc($rs_produtos)); ?>
                                      </select>
                                   </div>
                                      
                                      
                                
                            </li>
                            <li class="left newfilebtn"><a href="javascript:;" onClick="document.getElementById('formProvas').submit()" class="btn btn-primary"  style="padding:4px; margin-left:10px;">Pesquisar</a></li>
                        </ul>
            </form>
                        <span class="clearall"></span>
                    </div>
         <?php if($totalRows_rs_ordens_de_servico > 0) { ?>
          <table class="table table-bordered">
           
            <tbody>
              
              <tr>
                <td width="8%" style="text-align:center"><strong>C&oacute;digo</strong></td>
                <td width="38%" ><strong>Produto</strong></td>
                <td width="17%" style="text-align:center" ><strong>Data de Entrada</strong></td>
                <td width="15%" style="text-align:center"><strong>Data de Sa&iacute;da</strong></td>
                <td style="text-align:center"><strong>Op&ccedil;&otilde;es</strong></td>
               
              </tr>
            
            <?php
			if($totalRows_rs_ordens_de_servico > 0){
			 do{
		     ?>
              <tr>
                <td style="text-align:center"><?php echo $row_rs_ordens_de_servico['id'];?></td>
                <td ><?php echo utf8_decode($row_rs_ordens_de_servico['nomeProduto']);?></td>
                <td style="text-align:center"><?php echo formataData($row_rs_ordens_de_servico['data_entrada']);?></td>
                <td style="text-align:center"><?php echo formataData($row_rs_ordens_de_servico['data_saida']);?></td>
                <td width="22%" style="text-align:center">
                	<a href="editar-ordem-de-servico.php?id=<?php echo $row_rs_ordens_de_servico['id'];?>"class="btn btn-primary btn-mini"> <i class="icon-pencil"></i> &nbsp; Visualizar  </a>
                    
                    <a href="?id=<?php echo $row_rs_ordens_de_servico['id']; ?>&acao=excluir" class="btn btn-danger btn-mini" style="margin-left:7px;"> <i class="iconfa-remove"></i> Excluir
                    </a>
                    
               </td>
                
                
              </tr>
             
            <?php }while($row_rs_ordens_de_servico = mysql_fetch_assoc($rs_ordens_de_servico)); ?>
             
              <?php
			}
			?>
              
            </tbody>
          </table>
          <?php 
		  } else { 
		  	$HTML->nenhumRegistro();
		  }
		  ?>
          
        </div>
        <!--widgetcontent-<?php
mysql_free_result($rs_produtos);
?>->
            </div><!--widget-->
        <?php include_once('footer.php');?>