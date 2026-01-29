<?php 
include('restrito.php');
include('Connections/conexao.php');
include('funcoes.php');

if($_GET[acao] == 'excluir') {
	mysql_select_db($database_conexao, $conexao);
	$deleteSQL = sprintf("DELETE FROM tbl_termo_de_uso WHERE id=%s",
                       GetSQLValueString($_GET['id'], "int"));
	$Result1 = mysql_query($deleteSQL, $conexao) or die(mysql_error());	
	
	echo "	<script>
			window.location='termo-de-uso.php';
			</script>";
			exit;
}

include('class/html.php');
$HTML = new HTML;

$currentPage = 'termo-de-uso.php';

mysql_select_db($database_conexao, $conexao);
$query_rs_ordens_de_servico = "SELECT * FROM tbl_termo_de_uso ORDER BY id DESC";
$rs_ordens_de_servico = mysql_query($query_rs_ordens_de_servico, $conexao) or die(mysql_error());
$row_rs_ordens_de_servico = mysql_fetch_assoc($rs_ordens_de_servico);
$totalRows_rs_ordens_de_servico = mysql_num_rows($rs_ordens_de_servico);
?>
<!DOCTYPE html>
<html>
<head>

<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Termo de Uso</title>

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
    <li><a href="termo-de-uso.php">Termo de Uso</a></li>
    
  </ul>
  <div class="pageheader">
  
    	<a href="add-termo-uso.php"class="btn btn-primary btn-mini searchbar"> <i class="icon-plus"></i> &nbsp; Novo</a>
    
    <div class="pageicon"><span class="iconfa-edit"></span></div>
    <div class="pagetitle" >
      <h5></h5>
      <h1>Termo de Uso</h1>
    </div>
    
    
    
  </div>
  <!--pageheader-->
  <div class="maincontent">
    <div class="maincontentinner">
      <div class="widget">
        <h4 class="widgettitle"><span class="icon-calendar"></span>Termo de Uso</h4>
        <div class="widgetcontent">
        
         <?php if($totalRows_rs_ordens_de_servico > 0) { ?>
          <table width="99%" class="table table-bordered">
           
            <tbody>
              
              <tr>
                <td width="7%" style="text-align:center"><strong>C&oacute;digo</strong></td>
                <td width="61%" ><strong>Titulo</strong></td>
                <td width="9%" ><strong>Ordem</strong></td>
                <td style="text-align:center"><strong>Op&ccedil;&otilde;es</strong></td>
               
              </tr>
            
            <?php
			if($totalRows_rs_ordens_de_servico > 0){
			 do{
		     ?>
              <tr>
                <td style="text-align:center"><?php echo $row_rs_ordens_de_servico['id'];?></td>
                <td ><?php echo utf8_decode($row_rs_ordens_de_servico['titulo']);?></td>
                <td ><?php echo $row_rs_ordens_de_servico['ordem'];?></td>
                <td width="23%" style="text-align:center">
                	<a href="editar-termo-uso.php?id=<?php echo $row_rs_ordens_de_servico['id'];?>"class="btn btn-primary btn-mini"> <i class="icon-pencil"></i> &nbsp; Visualizar  </a>
                    
                    <a href="?id=<?php echo $row_rs_ordens_de_servico['id']; ?>&acao=excluir" class="btn btn-danger btn-mini" style="margin-left:7px;"> <i class="iconfa-remove"></i> Excluir
                    </a>
                    
               </td>
                
                
              </tr>
             
            <?php }while($row_rs_ordens_de_servico = mysql_fetch_assoc($rs_ordens_de_servico)); ?>
             
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
mysql_free_result($rs_produtos);
?>->
            </div><!--widget-->
        <?php include_once('footer.php');?>