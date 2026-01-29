<?php 
if (!isset($_SESSION)) { session_start(); }
//print_r($_SESSION);
include('restrito.php');
include('Connections/conexao.php');
include('funcoes.php');

include('class/html.php');
$HTML = new HTML;

$currentPage = 'provas.php';

mysql_select_db($database_conexao, $conexao);
$query_rs_usuarios = "SELECT * FROM tbl_admin ORDER BY nome ASC";
$rs_usuarios = mysql_query($query_rs_usuarios, $conexao) or die(mysql_error());
$row_rs_usuarios = mysql_fetch_assoc($rs_usuarios);
$totalRows_rs_usuarios = mysql_num_rows($rs_usuarios);

if($_GET['dataInicio'] <> ''){
	$sql .= "and date(tbl_logs.datahora) >= '".formataDataSQL($_GET['dataInicio'])."'";
}

if($_GET['dataFim'] <> ''){
	$sql .= "and date(tbl_logs.datahora) <= '".formataDataSQL($_GET['dataFim'])."'";
}

if($_GET['id_usuario'] <> ''){
	$sql .= "and tbl_logs.id_usuario = '".$_GET['id_usuario']."'";
}

mysql_select_db($database_conexao, $conexao);
$query_rs_comissoes = "
SELECT
	tbl_logs.*,
	tbl_admin.nome as nomeUsuario
FROM
	tbl_logs
	left join tbl_admin on tbl_logs.id_usuario = tbl_admin.id
where 
	1=1 $sql
ORDER BY 
	tbl_logs.id DESC";
$rs_comissoes = mysql_query($query_rs_comissoes, $conexao) or die(mysql_error());
$row_rs_comissoes = mysql_fetch_assoc($rs_comissoes);
$totalRows_rs_comissoes = mysql_num_rows($rs_comissoes);
?>
<!DOCTYPE html>
<html>
<head>

<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Relat&oacute;rios > Hist&oacute;rico de Altera&ccedil;&otilde;es</title>

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
    <li><a href="provas.php">Hist&oacute;rico de Altera&ccedil;&otilde;es</a></li>
    
  </ul>
  <div class="pageheader">
  
    	<a href="add_contrato.php"class="btn btn-primary btn-mini searchbar"> <i class="icon-plus"></i> &nbsp; Novo</a>
    
    <div class="pageicon"><span class="iconfa-edit"></span></div>
    <div class="pagetitle" >
      <h5>Relat&oacute;rios</h5>
      <h1>Hist&oacute;rico de Altera&ccedil;&otilde;es</h1>
    </div>
    
    
    
  </div>
  <!--pageheader-->
  <div class="maincontent">
    <div class="maincontentinner">
      <div class="widget">
        <h4 class="widgettitle"><span class="icon-calendar"></span>Hist&oacute;rico de Altera&ccedil;&otilde;es</h4>
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
                                      <span class="add-on">Usuários</span>
                                   
                            
                                      <select name="id_usuario" id="id_usuario" style="height:32px;" >
                                      	<option value=""></option>
										<?php do { ?>
                                        <option value="<?php echo $row_rs_usuarios['id'];?>" <?php if($row_rs_usuarios['id'] == $_GET['id_usuario']) { echo 'selected'; } ?>><?php echo utf8_decode($row_rs_usuarios['nome']);?></option>
                                        <?php } while($row_rs_usuarios = mysql_fetch_assoc($rs_usuarios)); ?>
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
                <td width="17%" style="text-align:center"><strong>Data</strong></td>
                <td width="18%" style="text-align:center"><strong>Usu&aacute;rio</strong></td>
                <td width="65%" ><strong>Log</strong></td>
              </tr>
            
            <?php
			if($totalRows_rs_comissoes > 0){
			 do{
		     ?>
              <tr>
                <td style="text-align:center"><?php echo formataData($row_rs_comissoes['datahora']).' às '.substr($row_rs_comissoes['datahora'],11,5);?></td>
                <td style="text-align:center"><?php echo utf8_decode($row_rs_comissoes['nomeUsuario']);?></td>
                <td ><?php echo utf8_decode($row_rs_comissoes['texto']);?></td>
              </tr>
             
            <?php }while($row_rs_comissoes = mysql_fetch_assoc($rs_comissoes)); 
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
mysql_free_result($rs_usuarios);
?>->
            </div><!--widget-->
        <?php include_once('footer.php');?>