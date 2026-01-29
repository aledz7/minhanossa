<?php require_once('Connections/conexao.php'); ?>
<?php
include('funcoes.php');

mysql_select_db($database_conexao, $conexao);
$query_rs_estado = "SELECT * FROM dados_estados ORDER BY nome ASC";
$rs_estado = mysql_query($query_rs_estado, $conexao) or die(mysql_error());
$row_rs_estado = mysql_fetch_assoc($rs_estado);
$totalRows_rs_estado = mysql_num_rows($rs_estado);

mysql_select_db($database_conexao, $conexao);
$query_rs_fornecedor = "SELECT * FROM tbl_fornecedores WHERE id = '".$_GET['id']."'";
$rs_fornecedor = mysql_query($query_rs_fornecedor, $conexao) or die(mysql_error());
$row_rs_fornecedor = mysql_fetch_assoc($rs_fornecedor);
$totalRows_rs_fornecedor = mysql_num_rows($rs_fornecedor);

if((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "formEditCLiente")) {

	$updateSQL = sprintf("UPDATE tbl_fornecedores SET nome=%s, cpf=%s, rg=%s, telefone1=%s, telefone2=%s, email=%s, estado=%s, cidade=%s, cep=%s, endereco=%s, numero=%s,   complemento=%s, bairro=%s WHERE id=%s",
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
                       GetSQLValueString($_POST['bairro'], "text"),
                       GetSQLValueString($_POST['id'], "int")); 
		mysql_select_db($database_conexao, $conexao);
		$Result1 = mysql_query($updateSQL, $conexao) or die(mysql_error());
	
		$idConteudo = $_POST['id'][$i];
	
	marcaHistoricoAlteracao("Modificou o fornecedor {$_POST['nome']}.");
			echo "
				<script>
					window.location='fornecedores.php';
				</script>
			";			
		
}
?>
<?php 
include('restrito.php');
include('Connections/conexao.php');
include('funcoes.php');
?>
<!DOCTYPE html>
<html>
<head>

<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Cadastro > Fornecedores > Editar</title>

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
<script type="text/javascript" src="js/custom.js"></script>
<script type="text/javascript" src="js/forms.js"></script>
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript" src="load.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9" /></head>

<body>
<?php //include_once('head.php');?>

<div class="mainwrapper">
    
<?php include_once('header.php');?>
    
<?php include_once('inc_coluna.php');?>
    
    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="."><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li><a href="fornecedores.php">Fornecedores</a> <span class="separator"></span></li>
            <li>Editar</li>
        </ul>
        <div class="maincontent">
            <div class="maincontentinner">
            
            <div class="widget">
            <h4 class="widgettitle"><span class="iconfa-edit"></span>Editar Fornecedores</h4>
            <div class="widgetcontent">
           
           
               <form class="stdform" action="" method="post" name="formEditCLiente" id="formEditCLiente" />
                    	
                        <div class="row">
                            <div class="col-md-12">
                            	<div class="col-md-2">
                                    C&oacute;digo<br>
                                    <div class="input-prepend">
                                        <input type="text" name="id" class="input-small" placeholder="Código" disabled value="<?php echo $row_rs_fornecedor['id']?>" />
                                		<span class="add-on"><i class="icon-qrcode"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    Nome<br>
                                    <div class="input-prepend">
                                    	<input type="text" name="nome" class="input-xlarge" placeholder="Nome" value="<?php echo $row_rs_fornecedor['nome']?>" />
                                		<span class="add-on"><i class="icon-edit"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    CNPJ<br>
                                    <div class="input-prepend">
                                    	<input type="text" name="cpf" class="input-medium" placeholder="Informe um CNPJ válido" value="<?php echo $row_rs_fornecedor['cpf']?>" />
                                		<span class="add-on"><i class="iconfa-credit-card"></i></span>
                                    </div>
                                </div>
                                
                               <?php /*?> <div class="col-md-2">
                                    RG<br>
                                    <div class="input-prepend">
                                    	<input type="text" name="rg" class="input-small" placeholder="Informe um RG válido" value="<?php echo $row_rs_fornecedor['rg']?>" />
                                		<span class="add-on"><i class="iconfa-credit-card"></i></span>
                                    </div>
                                </div><?php */?>
                            
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                            	<div class="col-md-3">
                                    Telefone 1<br>
                                    <div class="input-prepend">
                                    	<input type="text" name="telefone1" class="input-medium" placeholder="Telefone 1" value="<?php echo $row_rs_fornecedor['telefone1']?>" />
                                		<span class="add-on"><i class="iconfa-phone"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    Telefone 2<br>
                                    <div class="input-prepend">
                                    	<input type="text" name="telefone2" class="input-medium" placeholder="Telefone 2" value="<?php echo $row_rs_fornecedor['telefone2']?>" />
                                		<span class="add-on"><i class="iconfa-phone"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    E-mail<br>
                                    <div class="input-prepend">
                                    	<input type="email" name="email" class="input-large" placeholder="Informe um email válido" value="<?php echo $row_rs_fornecedor['email']?>" />
                                		<span class="add-on"><i class="iconfa-envelope-alt"></i></span>
                                    </div>
                                </div>
                            
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                            	<div class="col-md-3">
                                    Estado<br>
                                    <div class="input-prepend">
                                         
                                    	<select name="estado" class="uniformselect" onChange="document.getElementById('janela_cidades').innerHTML='&nbsp;Carregando Cidades!'; AtualizaJanela('cidades.php?id_estado=' + this.value, 'cidades');">
                       					<?php do{?>
                            				<option value="<?php echo $row_rs_estado['id'];?>" <?php if($row_rs_fornecedor['estado'] == $row_rs_estado['id']){ echo "selected";}?> /><?php echo $row_rs_estado['nome'];?>
                       					<?php }while($row_rs_estado = mysql_fetch_assoc($rs_estado));?>         
                       					</select>
                                        
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <span id="janela_cidades">
                                    <?php 
									$_GET['id_estado'] = $row_rs_fornecedor['estado'];
									$_GET['id_cidade'] = $row_rs_fornecedor['cidade'];
									include_once('cidades.php');
									?>
                                    </span>
                                </div>
                               
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                            	
                                <div class="col-md-2">
                                    CEP<br>
                                    <div class="input-prepend">
                                        <input type="text" name="cep" class="input-small" placeholder="CEP" value="<?php echo $row_rs_fornecedor['cep']?>"/>
                                		<span class="add-on"><i class="icon-edit"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    Endere&ccedil;o<br>
                                    <div class="input-prepend">
                                    	<input type="text" name="endereco" class="input-xxlarge" placeholder="Informe o endereço" value="<?php echo $row_rs_fornecedor['endereco']?>" />
                                		<span class="add-on"><i class="icon-home"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    N&uacute;mero<br>
                                    <div class="input-prepend">
                                    	<input type="text" name="numero" class="input-small" placeholder="Informe o número" value="<?php echo $row_rs_fornecedor['numero']?>"/>
                                		<span class="add-on"><i class="icon-resize-vertical"></i></span>
                                    </div>
                                </div>
                            
                            </div>
                        </div>
                       
                        <div class="row">
                            <div class="col-md-12">
                            	<div class="col-md-4">
                                    Complemento<br>
                                    <div class="input-prepend">
                                        <input type="text" name="complemento" class="input-xlarge" placeholder="Informe o complemento" value="<?php echo $row_rs_fornecedor['complemento']?>"/>
                                		<span class="add-on"><i class="icon-pencil"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    Bairro<br>
                                    <div class="input-prepend">
                                    	<input name="bairro" type="text" class="input-xlarge" id="bairro" placeholder=" Informe o bairro" value="<?php echo $row_rs_fornecedor['bairro']?>" />
                                		<span class="add-on"><i class="icon-asterisk"></i></span>
                                    </div>
                                </div>
                               
                            
                            </div>
                        </div>
                        
                 
                        
                        
                      <div class="row">
                      	<div class="col-md-12" align="right">
                        	 <a href="javascript:;" onClick="document.getElementById('formEditCLiente').submit();" class="btn btn-mini btn-success"> <i class="iconfa-ok"></i>&nbsp; Salvar</a> 
                             <a href="cliente.php" class="btn btn-danger btn-mini"> <i class="iconfa-remove"></i>&nbsp; Cancelar</a>
                        </div>
                      </div>
                   <input type="hidden" name="id" id="id" value="<?php echo $row_rs_fornecedor['id']?>">
                   <input type="hidden" name="MM_update" id="MM_update" value="formEditCLiente">
                </form>
           
            </div><!--widgetcontent-->
            </div><!--widget-->
            
       
            <?php include_once('footer.php');?>