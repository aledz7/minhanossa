<?php require_once('Connections/conexao.php'); ?>
<?php
if (!isset($_SESSION)) { session_start(); }

include('restrito.php');
include('funcoes.php');

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


$editFormAction = $_SERVER['PHP_SELF'];
if(isset($_SERVER['QUERY_STRING'])) {
	$editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formAddContrato")) {	
	
	$insertSQL = sprintf("INSERT INTO tbl_contas_pagar (data_conta, valor_total, valor_pago, observacoes) VALUES (%s, %s, %s, %s)",
					   GetSQLValueString($_POST['data_conta'], "text"),
                       GetSQLValueString($_POST['valor_total'], "text"),
                       GetSQLValueString($_POST['valor_pago'], "text"),
					   GetSQLValueString($_POST['observacoes'], "text"));
		mysql_select_db($database_conexao, $conexao);
		$Result1 = mysql_query($insertSQL, $conexao) or die(mysql_error());
		$idConteudo = mysql_insert_id();
		
			
	echo "	<script>
				window.location='contas_pagar.php';
			</script>";
			
}
?>
<!DOCTYPE html>
<html>
<head>

<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Adicionar Conta a Pagar</title>

<link rel="stylesheet" href="css/style.default.css" type="text/css" />
<link rel="stylesheet" href="css/bootstrap-fileupload.min.css" type="text/css" />
<link rel="stylesheet" href="css/bootstrap-timepicker.min.css" type="text/css" />
<link rel="stylesheet" href="prettify/prettify.css" type="text/css" />

<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/jquery-migrate-1.1.1.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.9.2.min.js"></script>
<script type="text/javascript" src="prettify/prettify.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.jgrowl.js"></script>
<script type="text/javascript" src="js/jquery.alerts.js"></script>
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
<script type="text/javascript" src="js/custom.js"></script>
<script type="text/javascript" src="js/forms.js"></script>
<script type="text/javascript" src="js/elements.js"></script>
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript" src="load.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">


<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>

<body>
<?php //include_once('head.php');?>

<div class="mainwrapper">
    
<?php include_once('header.php');?>
    
<?php include_once('inc_coluna.php');?>
    
    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="."><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li><a href="contas_pagar.php">Conta a Pagar</a> <span class="separator"></span></li>
            <li>Adicionar Contas a Pagar</li>
        </ul>
        <div class="maincontent">
            <div class="maincontentinner">
            
            <div class="widget">
            <h4 class="widgettitle"><span class="iconfa-edit"></span>Nova Conta</h4>
            <div class="widgetcontent">
           
           
               <form class="stdform" action="" method="post" name="formAddContrato" id="formAddContrato" />
                    	
                        <div class="row">
                            <div class="col-md-12">
                            	
                                <div class="col-md-3">
                                    Data Conta<br>
                                    <div class="input-prepend">
                                    	<input type="date" name="data_conta" class="input-medium"/>
                                		<span class="add-on"><i class="icon-calendar"></i></span>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    Valor Total<br>
                                    <div class="input-prepend">
                                        <input type="text" name="valor_total" class="input-medium" placeholder="Valor Total" />
                                		<span class="add-on"><i class="icon-qrcode"></i></span>
                                    </div>
                                </div>
                                
                                 <div class="col-md-3">
                                    Valor Pago<br>
                                    <div class="input-prepend">
                                        <input type="text" name="valor_pago" class="input-medium" placeholder="Valor Total" />
                                		<span class="add-on"><i class="icon-qrcode"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                       <div class="row">
                            <div class="col-md-12">
                            	
                               
                                    Observações<br>
                                    <div class="input-prepend">
                                    	<textarea name="observacoes" rows="5" class="span5" style="width:1018px;"></textarea>
                                    </div>
                                
                                
                            
                            </div>
                        </div>
                        
                    <div class="row">
                      	<div class="col-md-12" align="right">
                        	 <a href="javascript:;" onClick="document.getElementById('formAddContrato').submit();" class="btn btn-mini btn-success"> <i class="iconfa-ok"></i>&nbsp; Salvar</a> 
                             <a href="contas_pagar.php" class="btn btn-danger btn-mini"> <i class="iconfa-remove"></i>&nbsp; Cancelar</a>
                        </div>
                      </div>
                   <input type="hidden" name="MM_insert" id="MM_insert" value="formAddContrato">
                </form>
           
            </div><!--widgetcontent-->
            </div><!--widget-->
            
       
            <?php include_once('footer.php');?>