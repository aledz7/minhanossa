<?php require_once('Connections/conexao.php'); ?>
<?php
session_start();
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

mysql_select_db($database_conexao, $conexao);
$query_rs_estado = "SELECT * FROM dados_estados ORDER BY nome ASC";
$rs_estado = mysql_query($query_rs_estado, $conexao) or die(mysql_error());
$row_rs_estado = mysql_fetch_assoc($rs_estado);
$totalRows_rs_estado = mysql_num_rows($rs_estado);
?>
<?php 
include('restrito.php');
include('Connections/conexao.php');
include('funcoes.php');

$editFormAction = $_SERVER['PHP_SELF'];
if(isset($_SERVER['QUERY_STRING'])) {
	$editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formAddCLiente")) {	
	
	$insertSQL = sprintf("INSERT INTO tbl_cliente (nome, cpf, rg, telefone1, telefone2, email, estado, cidade, cep, endereco, numero, complemento, bairro) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
					   GetSQLValueString($_POST['nome'], "text"),
                       GetSQLValueString($_POST['cpf'], "text"),
                       GetSQLValueString($_POST['rg'], "text"),
                       GetSQLValueString($_POST['telefone1'], "text"),
                       GetSQLValueString($_POST['telefone2'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
					   GetSQLValueString($_POST['estado'], "text"),
					   GetSQLValueString($_POST['cidade'], "text"),
                       GetSQLValueString($_POST['cep'], "text"),
                       GetSQLValueString($_POST['endereco'], "text"),
                       GetSQLValueString($_POST['numero'], "text"),
                       GetSQLValueString($_POST['complemento'], "text"),
					   GetSQLValueString($_POST["bairro"], "text"));
		mysql_select_db($database_conexao, $conexao);
		$Result1 = mysql_query($insertSQL, $conexao) or die(mysql_error());
		$idConteudo = mysql_insert_id();
			
	echo "	<script>
				window.location='cliente.php';
			</script>";
			
}
?>
<!DOCTYPE html>
<html>
<head>

<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Shamcey - Metro Style Admin Template</title>
<link rel="stylesheet" href="css/style.default.css" type="text/css" />
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/jquery-migrate-1.1.1.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.9.2.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.uniform.min.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>
<script type="text/javascript" src="js/modernizr.min.js"></script>
<script type="text/javascript" src="js/jquery.smartWizard.min.js"></script>
<script type="text/javascript" src="js/custom.js"></script>

<script type="text/javascript" src="load.js"></script>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>

<body>
<?php //include_once('head.php');?>

<div class="mainwrapper">
    
<?php include_once('header.php');?>
    
<?php include_once('inc_coluna.php');?>
    
    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="."><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li><a href="cliente.php">Cliente</a></li>
           
            
        </ul>
        
        <div class="pageheader">
            <div class="pageicon"><span class="iconfa-edit"></span></div>
            <div class="pagetitle">
                <h5>Cadastro</h5>
                <h1>Cliente</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">
            
                <!-- START OF DEFAULT WIZARD -->
                <h4 class="subtitle2">Cadastro de Cliente</h4>
                    <form class="stdform" method="post" action="" name="formAddCLiente" id="formAddCLiente" >
                    <div id="wizard" class="wizard">
                    	<br />
                        <ul class="hormenu">
                            <li>
                            	<a href="#wiz1step1">
                                	<span class="h2">Passo 1</span>
                                    <span class="label">Dados Pessoais</span>
                                </a>
                            </li>
                            <li>
                            	<a href="#wiz1step2">
                                	<span class="h2">Passo 2</span>
                                    <span class="label">Contato</span>
                                </a>
                            </li>
                            <li>
                            	<a href="#wiz1step3">
                                	<span class="h2">Passo 3</span>
                                    <span class="label">Endereço</span>
                                </a>
                            </li>
                             <li>
                            	<a href="#wiz1step4">
                                	<span class="h2">Passo 4</span>
                                    <span class="label">Registrar Alterações</span>
                                </a>
                            </li>
                        </ul>
                                                	
                        <div id="wiz1step1" class="formwiz">
                        	<h4 class="widgettitle"><strong>Passo 1</strong> - Dados Pessoais</h4>
                        	
                                <p>
                                <div class="row">
                                <div class="col-md-12">
                                	<div class="col-md-12" style="padding-left:10px;">
                                    Código<br>
                                    <div class="input-prepend">
                                        <span class="add-on"><i class="iconfa-barcode"></i></span>
                                    	<input type="text" name="id" id="firstname" class="input-xxxlarge" disabled/>
                                    </div>
                                </div>
                                
                                <div class="col-md-12" style="padding-left:10px;">
                                    Nome<br>
                                    <div class="input-prepend">
                                        <span class="add-on"><i class="icon-edit"></i></span>
                                    	<input type="text" name="nome" class="input-xxxlarge" placeholder="Informe o nome do cliente"  />
                                    </div>
                                </div>
                                
                                <div class="col-md-12" style="padding-left:10px;">
                                    CPF<br>
                                    <div class="input-prepend">
                                        <span class="add-on"><i class="iconfa-credit-card"></i></span>
                                    	<input type="text" name="cpf" class="input-xxxlarge" placeholder="Informe um CPF válido"  />
                                    </div>
                                </div>
                                
                                <div class="col-md-12" style="padding-left:10px;">
                                    RG<br>
                                    <div class="input-prepend">
                                        <span class="add-on"><i class="iconfa-user"></i></span>
                                    	<input type="text" name="rg" class="input-xxxlarge" placeholder="Informe um RG válido"  />
                                    </div>
                                </div>
                                
                                </div>
                                </div>
                                   
                                </p>
                            
                        </div>
                        
                        <div id="wiz1step2" class="formwiz">
                        	<h4 class="widgettitle"><strong>Passo 2</strong> - Contato</h4>
                            
                                <p>
                                 <div class="row">
                                <div class="col-md-12">
                                	<div class="col-md-12" style="padding-left:10px;">
                                    Telefone 1<br>
                                    <div class="input-prepend">
                                        <span class="add-on"><i class="iconfa-phone"></i></span>
                                    	<input type="text" name="telefone1" class="input-xxxlarge" placeholder="Informe o Telefone 1"  />
                                    </div>
                                </div>
                                
                                <div class="col-md-12" style="padding-left:10px;">
                                    Telefone 2<br>
                                    <div class="input-prepend">
                                        <span class="add-on"><i class="iconfa-phone"></i></span>
                                    	<input type="text" name="telefone2" class="input-xxxlarge" placeholder="Informe o Telefone 1"  />
                                    </div>
                                </div>
                                
                                <div class="col-md-12" style="padding-left:10px;">
                                    Email<br>
                                    <div class="input-prepend">
                                        <span class="add-on"><i class="iconfa-envelope-alt"></i></span>
                                    	<input type="text" name="email" class="input-xxxlarge" placeholder="Informe um email válido"  />
                                    </div>
                                </div>
                                
                                </div>
                                </div>
                                </p>
                                
                        </div>
                        
                        <div id="wiz1step3">
                        	<h4 class="widgettitle"><strong>Passo 3</strong> - Endereço</h4>
                            <p>
                            <div class="row">
                                <div class="col-md-12">
                                <div class="col-md-12" style="padding-left:10px;">
                                    Estado<br>
                                    <div class="input-prepend">
                                    
                                    <span class="add-on"><i class="iconfa-map-marker"></i></span>
                                    	<select name="estado" class="uniformselect" onChange="document.getElementById('janela_cidades').innerHTML='&nbsp;Carregando Cidades!'; AtualizaJanela('cidades.php?id_estado=' + this.value, 'cidades');" style="width:960px !important;">
                       					<?php do{?>
                            				<option value="<?php echo $row_rs_estado['id'];?>" /><?php echo $row_rs_estado['nome'];?>
                       					<?php }while($row_rs_estado = mysql_fetch_assoc($rs_estado));?>         
                       					</select>
                                    </div>
                                </div>
                                	<div class="col-md-12" style="padding-left:10px;">
                                   <span id="janela_cidades"></span>
                                </div>
                                    <div class="col-md-12" style="padding-left:10px;">
                                    CEP<br>
                                    <div class="input-prepend">
                                        <span class="add-on"><i class="icon-list"></i></span>
                                    	<input type="text" name="cep" class="input-xxxlarge" placeholder="Informe o CEP"  />
                                    </div>
                                </div>
                                
                                <div class="col-md-12" style="padding-left:10px;">
                                    Endereço<br>
                                    <div class="input-prepend">
                                        <span class="add-on"><i class="icon-home"></i></span>
                                    	<input type="text" name="endereco" class="input-xxxlarge" placeholder="Informe o endereço"  />
                                    </div>
                                </div>
                                
                                <div class="col-md-12" style="padding-left:10px;">
                                    Endereço<br>
                                    <div class="input-prepend">
                                        <span class="add-on"><i class="icon-home"></i></span>
                                    	<input type="text" name="endereco" class="input-xxxlarge" placeholder="Informe o endereço"  />
                                    </div>
                                </div>
                                
                                <div class="col-md-12" style="padding-left:10px;">
                                    Número<br>
                                    <div class="input-prepend">
                                        <span class="add-on"><i class="icon-resize-vertical"></i></span>
                                    	<input type="text" name="numero" class="input-xxxlarge" placeholder="Informe o número"  />
                                    </div>
                                </div>
                                
                                <div class="col-md-12" style="padding-left:10px;">
                                    Complemento<br>
                                    <div class="input-prepend">
                                        <span class="add-on"><i class="icon-pencil"></i></span>
                                    	<input type="text" name="complemento" class="input-xxxlarge" placeholder="Informe o completo"  />
                                    </div>
                                </div>
                                <div class="col-md-12" style="padding-left:10px;">
                                    Bairro<br>
                                    <div class="input-prepend">
                                        <span class="add-on"><i class="iconfa-asterisk"></i></span>
                                    	<input type="text" name="bairro" class="input-xxxlarge" placeholder="Informe o bairro"  />
                                    </div>
                                </div>
                                
                                </div>
                                </div>
                               
                          
                                    
                                </p>
                         </div>
                                
                                
                        <div id="wiz1step4" class="formwiz">
                        <p>
                        <div class="row">
                                <div class="col-md-12">
                        	<h4 class="widgettitle"><strong>Passo 4</strong> - Registrar Alterações</h4>
                            
                                <p style="color:#468847; font-weight:700; font-size:24px;" align="center">
                                	<i class="iconfa-ok" style="color:#468847;"></i> Edição Concluída    
                                </p>
                                <p>
                                	<h3 align="center">Clique no botão Salvar para finalizar o cadastro</h3>
                                </p>
                                
                            </div>
                            </div>
						</p>
                        </div><!--#wiz1step2-->
                        
                    </div><!--#wizard-->
                    <input type="hidden" name="MM_insert" value="formAddCLiente">
                    </form>
                    <!-- END OF DEFAULT WIZARD -->
                    
                    <div class="clearfix"></div><br /><br />
                    <script type="text/javascript">
jQuery(document).ready(function(){
    
    // Smart Wizard 	
    jQuery('#wizard').smartWizard({onFinish: onFinishCallback});
    jQuery('#wizard2').smartWizard({onFinish: onFinishCallback});
    jQuery('#wizard3').smartWizard({onFinish: onFinishCallback});
		
    function onFinishCallback(){
        document.getElementById('formAddCLiente').submit();
    } 
			
    jQuery('select, input:checkbox').uniform();
    
});
</script>
             
<?php include_once('footer.php');?>