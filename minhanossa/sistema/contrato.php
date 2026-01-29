<?php 
include('restrito.php');
include('Connections/conexao.php');
include('funcoes.php');

mysql_select_db($database_conexao, $conexao);
$query_rs_clausula_contrato = "SELECT * FROM clausula_contrato";
$rs_clausula_contrato = mysql_query($query_rs_clausula_contrato, $conexao) or die(mysql_error());
$row_rs_clausula_contrato = mysql_fetch_assoc($rs_clausula_contrato);
$totalRows_rs_clausula_contrato = mysql_num_rows($rs_clausula_contrato);

if((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "formEditContrato")) {

	$updateSQL = sprintf("UPDATE clausula_contrato SET clausula=%s",
				   GetSQLValueString($_POST['clausula'], "text")); 
	mysql_select_db($database_conexao, $conexao);
	$Result1 = mysql_query($updateSQL, $conexao) or die(mysql_error());
	
	echo "	<script>
			alert('Modificação realizada com sucesso.');
			window.location='.';
			</script>";			
			exit;
}
?>

<!DOCTYPE html>
<html>
<head>

<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Contrato</title>

<link rel="stylesheet" href="css/style.default.css" type="text/css" />
<link rel="stylesheet" href="css/bootstrap-fileupload.min.css" type="text/css" />
<link rel="stylesheet" href="css/bootstrap-timepicker.min.css" type="text/css" />
<style type="text/css">
body,td,th {
	font-family: RobotoRegular, "Helvetica Neue", Helvetica, sans-serif;
}
</style>
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

<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="ckeditor/ckfinder/ckfinder.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9" /></head>

<body>
<?php //include_once('head.php');?>

<div class="mainwrapper">
    
<?php include_once('header.php');?>
    
<?php include_once('inc_coluna.php');?>
    
    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="."><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li><a href="contrato.php">Contrato</a> </li>
           
            
            
        </ul>
        
        <div class="pageheader">
           
            
           
                <div class="alert alert-info">
                              <button data-dismiss="alert" class="close" type="button">&times;</button>
                              <strong>Edi&ccedil;&atilde;o de contrato</strong> <br>
                              Edite as condi&ccedil;&otilde;es abaixo de acordo com sua necessidade. As informa&ccedil;&otilde;es editadas ser&atilde;o substitu&iacute;das no contrato padr&atilde;o do sistema.
                            </div>
           
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">
            
            <div class="widget">
            <h4 class="widgettitle"><span class="iconfa-pencil"></span>Edi&ccedil;&atilde;o de cl&aacute;usulas do contrato</h4>
            <div class="widgetcontent">
                <form class="stdform" action="" method="post" name="formEditContrato" id="formEditContrato"  />
                
               
                	<textarea name="clausula" id="autoResizeTA" cols="80" rows="5" class="ckeditor" style="resize: vertical"><?php echo $row_rs_clausula_contrato['clausula'];?></textarea>
                
                 <p align="right">
                            
                                <a href="javascript:;" onClick="document.getElementById('formEditContrato').submit();" class="btn btn-mini btn-success"> <i class="iconfa-ok"></i> &nbsp; Salvar</a> 
                        </p>  
                    	<input type="hidden" name="MM_update" id="MM_update" value="formEditContrato">
                </form>
            </div><!--widgetcontent-->
            </div><!--widget-->
            
<?php include_once('footer.php');?>