<?php 
include('restrito.php');
include('Connections/conexao.php');
include('funcoes.php');

$currentPage = 'add_contrato.php';

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
$query_rs_loja = "SELECT * FROM tbl_loja ORDER BY nome ASC";
$rs_loja = mysql_query($query_rs_loja, $conexao) or die(mysql_error());
$row_rs_loja = mysql_fetch_assoc($rs_loja);
$totalRows_rs_loja = mysql_num_rows($rs_loja);

mysql_select_db($database_conexao, $conexao);
$query_rs_vendedor = "SELECT * FROM tbl_loja ORDER BY nome ASC";
$rs_vendedor = mysql_query($query_rs_vendedor, $conexao) or die(mysql_error());
$row_rs_vendedor = mysql_fetch_assoc($rs_vendedor);
$totalRows_rs_vendedor = mysql_num_rows($rs_vendedor);

$editFormAction = $_SERVER['PHP_SELF'];
if(isset($_SERVER['QUERY_STRING'])) {
	$editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formAddLoja")) {	
	
	$insertSQL = sprintf("INSERT INTO tbl_contrato (data_contrato, loja, vendedor, data_evento, codigo_cliente, nome_cliente, tipo_contrato, comentario) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
					   GetSQLValueString($_POST['data_contrato'], "text"),
                       GetSQLValueString($_POST['loja'], "text"),
                       GetSQLValueString($_POST['vendedor'], "text"),
                       GetSQLValueString($_POST['data_evento'], "text"),
                       GetSQLValueString($_POST['codigo_cliente'], "text"),
                       GetSQLValueString($_POST['nome_cliente'], "text"),
                       GetSQLValueString($_POST['tipo_contrato'], "text"),
                       GetSQLValueString($_POST['comentario'], "text"));
		mysql_select_db($database_conexao, $conexao);
		$Result1 = mysql_query($insertSQL, $conexao) or die(mysql_error());
		$idConteudo = mysql_insert_id();
			
	echo "	<script>
				window.location='contrato_cadastro.php';
			</script>";
			
}
?>
<!DOCTYPE html>
<html>
<head>

<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Adicionar </title>
<link rel="stylesheet" href="css/style.default.css" type="text/css" />
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/jquery-migrate-1.1.1.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.9.2.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.uniform.min.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>
<script type="text/javascript" src="js/modernizr.min.js"></script>
<script type="text/javascript" src="js/jquery.smartWizard.min.js"></script>

<!--<script type="text/javascript" src="load.js"></script>-->

<script type="text/javascript" src="js/custom.js"></script>
<script type="text/javascript">
jQuery(document).ready(function(){
    
    // Smart Wizard 	
    jQuery('#wizard').smartWizard({onFinish: onFinishCallback});
    jQuery('#wizard2').smartWizard({onFinish: onFinishCallback});
    jQuery('#wizard3').smartWizard({onFinish: onFinishCallback});
		
    function onFinishCallback(){
        alert('Finish Clicked');
    } 
			
    jQuery('select, input:checkbox').uniform();
    
});
</script>
<style>
	.row{
		margin-left:0px;		
	}
	.span5{
		width:1000px !important;
	}
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
            <li><a href="contrato_cadastro.php">Contrato</a></li>
           
            
        </ul>
        
        <div class="pageheader">
            <div class="pageicon"><span class="iconfa-edit"></span></div>
            <div class="pagetitle">
                <h5>Cadastro</h5>
                <h1>Contrato</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">
            
                <!-- START OF DEFAULT WIZARD -->
                <h4 class="subtitle2">Cadastro de Contrato</h4>
                    <form class="stdform" method="post" action="" name="formContrato" id="formContrato" />
                    <div id="wizard" class="wizard">
                    	<br />
                        <ul class="hormenu">
                            <li>
                            	<a href="#wiz1step1">
                                	<span class="h2">Passo 1</span>
                                    <span class="label">Dados do Contrato</span>
                                </a>
                            </li>
                            <li>
                            	<a href="#wiz1step2">
                                	<span class="h2">Passo 2</span>
                                    <span class="label">Itens</span>
                                </a>
                            </li>
                            <li>
                            	<a href="#wiz1step3">
                                	<span class="h2">Passo 3</span>
                                    <span class="label">Pagamentos</span>
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
                        	<h4 class="widgettitle"><strong>Passo 1</strong> - Dados do Contrato</h4>
                        	
                                <p>
                                
                                <div class="row">
        <div class="col-md-2">
            Código<br>
            <div class="input-prepend">
                
                <input type="text" name="id" class="input-small" placeholder="Código" disabled />
                <span class="add-on"><i class="iconfa-qrcode"></i></span>
            </div>
        </div>
        <div class="col-md-3">
            Data do Contrato<br>
            <div class="input-prepend">
                
                <input type="text" name="data_contrato" class="input-medium" value="<?php echo date('d/m/Y');?> <?php echo date('H:i:s');?>" readonly/>
                <span class="add-on"><i class="iconfa-calendar"></i></span>
            </div>
        </div>
        
        <div class="col-md-2">
            Loja<br>
            <div class="input-prepend">
                   <select name="loja" class="uniformselect">
                <option />              
                Selecione
                 <?php do{?>                   
                <option value="<?php echo $row_rs_loja['id'];?>" />              
                <?php echo $row_rs_loja['nome'];?>
                 <?php }while($row_rs_loja = mysql_fetch_assoc($rs_loja));?>
                    </select>
            </div>
        </div>
        
        <div class="col-md-2">
            Vendedor<br>
            <div class="input-prepend">
                   <select name="vendedor" class="uniformselect">
                <option />              
                Selecione
                 <?php do{?>                   
                <option value="<?php echo $row_rs_vendedor['id'];?>" />              
                <?php echo $row_rs_vendedor['nome'];?>
                 <?php }while($row_rs_vendedor = mysql_fetch_assoc($rs_vendedor));?>
                    </select>
            </div>
        </div>
        
        <div class="col-md-2">
            Data do Evento<br>
            <div class="input-prepend">
                
                <input type="date" name="data_evento" class="input-medium" />
                <span class="add-on"><i class="iconfa-calendar"></i></span>
            </div>
        </div>
        
        </div>
        
        <div class="row">
        
        <div class="col-md-2">
            Código do Cliente<br>
            <div class="input-prepend">
                
                <input type="text" name="codigo_cliente" class="input-small" />
                <span class="add-on"><i class="iconfa-qrcode"></i></span>
            </div>
        </div>
        <div class="col-md-4">
            Nome do Cliente<br>
            <div class="input-prepend">
                
                <input type="text" name="nome_cliente" class="input-xlarge" />
                <span class="add-on"><i class="iconfa-user"></i></span>
            </div>
        </div>
        
        <div class="col-md-4">
            Tipo de Contrato<br>
            <div class="input-prepend">
                 <select name="tipo_contrato" class="uniformselect">
                <option />              
                Selecione
                <option value="1" />Noiva
                <option value="2" />Noivo
                <option value="3" />Debutante
                <option value="4" />Convidado
                
                    </select>
            </div>
        </div>
        
        </div>
        <div class="row">
        	<div class="col-md-12">
           Comentários<br>
            <div class="input-prepend">
            
                 <textarea name="comentario" rows="5" class="span5" placeholder="Informações importantes sobre o contrato"></textarea>
            </div>
        </div>
        </div>
        
                                </p>
                                
                                
                              
                              
                                
                             
                                
                                
                                                                
                               
                                
                        	
                            
                        </div><!--#wiz1step1-->
                        
                        <div id="wiz1step2" class="formwiz">
                        	<h4 class="widgettitle"><strong>Passo 2</strong> - Itens do Contrato</h4>
                            
                                <p>
                                    <div class="row">
                                    	<div class="col-md-12">
                                        	<input name="qtdItens" type="text" class="txtbox55px" id="qtdItens" style="float:left;" />
            <a href="javascript:;" onClick="AtualizaJanela('itens.php?qtdAdverso=' +  document.getElementById('qtdItens').value, 'Itens');" class="bt114px" style="float:left; margin-left:10px; margin-top:1px;" >Mostrar Op&ccedil;&otilde;es</a>
                                        </div>
                                    </div>
                                    
                                  
<div id="janela_Itens"></div> 
                                </p>
                        
                        </div>
                        
                        <div id="wiz1step3">
                        	<h4 class="widgettitle"><strong>Passo 3</strong> - Endereço</h4>
                            
                                <p>
                                    <label>Estado</label>
                                    <span class="field">
                                    <select name="select" class="uniformselect">
                            	<option value="" />Choose One
                                <option value="" />Selection One
                                <option value="" />Selection Two
                                <option value="" />Selection Three
                                <option value="" />Selection Four
                            </select>
                                    </span>
                                </p>
                                 <p>
                                    <label>CEP</label>
                                    <span class="field">
                                    	<input type="text" name="cep" class="input-xxlarge" placeholder="Informe o CEP"  />
                                    </span>
                                </p>
                                <p>
                                    <label>Endereço</label>
                                    <span class="field">
                                    	<input type="text" name="endereco" class="input-xxlarge" placeholder="Informe o endereço"  />
                                    </span>
                                </p>
                                <p>
                                    <label>Número</label>
                                    <span class="field">
                                    	<input type="text" name="numero" class="input-xxlarge" placeholder="Informe o número"  />
                                    </span>
                                </p>
                                <p>
                                    <label>Complemento</label>
                                    <span class="field">
                                    	<input type="text" name="complemento" class="input-xxlarge" placeholder="Informe o completo"  />
                                    </span>
                                </p>
                                <p>
                                    <label>Bairro</label>
                                    <span class="field">
                                    	<input type="text" name="bairro" class="input-xxlarge" placeholder="Informe o bairro"  />
                                    </span>
                                </p>
                        </div><!--#wiz1step3-->
                        
                        <div id="wiz1step4" class="formwiz">
                        	<h4 class="widgettitle"><strong>Passo 4</strong> - Registrar Alterações</h4>
                            
                                <p style="color:#468847; font-weight:700; font-size:24px;" align="center">
                                	<i class="iconfa-ok" style="color:#468847;"></i> Edição Concluída    
                                </p>
                                <p>
                                	<h3 align="center">Clique no botão Salvar para finalizar o cadastro</h3>
                                </p>
                                
                                                                                               
                        </div><!--#wiz1step2-->
                        
                    </div><!--#wizard-->
                    </form>
                    <!-- END OF DEFAULT WIZARD -->
                    
                    <div class="clearfix"></div><br /><br />
             
<?php include_once('footer.php');?>