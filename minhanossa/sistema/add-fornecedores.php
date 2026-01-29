<?php 
include('restrito.php');
include('Connections/conexao.php');
include('funcoes.php');

if (!isset($_SESSION)) { session_start(); }


mysql_select_db($database_conexao, $conexao);
$query_rs_estado = "SELECT * FROM dados_estados ORDER BY nome ASC";
$rs_estado = mysql_query($query_rs_estado, $conexao) or die(mysql_error());
$row_rs_estado = mysql_fetch_assoc($rs_estado);
$totalRows_rs_estado = mysql_num_rows($rs_estado);


$editFormAction = $_SERVER['PHP_SELF'];
if(isset($_SERVER['QUERY_STRING'])) {
	$editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formAddCLiente")) {	
	
	$insertSQL = sprintf("INSERT INTO tbl_fornecedores (nome, cpf, rg, telefone1, telefone2, email, estado, cidade, cep, endereco, numero, complemento, bairro) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
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

	marcaHistoricoAlteracao("Incluiu o fornecedor {$_POST['nome']}.");
	
		echo "	<script>
				window.location='fornecedores.php';
				</script>";
				exit;		
}
?>
<!DOCTYPE html>
<html>
<head>

<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Adicionar Fornecedor</title>

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
            <li><a href="cliente.php">Fornecedores</a> <span class="separator"></span></li>
            <li>Novo</li>
        </ul>
        <div class="maincontent">
            <div class="maincontentinner">
            
            <div class="widget">
            <h4 class="widgettitle"><span class="iconfa-edit"></span>Novo Fornecedor</h4>
            <div class="widgetcontent">
           
           
               <form class="stdform" action="" method="post" name="formAddCLiente" id="formAddCLiente" />
                    	
                        <div class="row">
                            <div class="col-md-12">
                            	<div class="col-md-2">
                                    C&oacute;digo<br>
                                    <div class="input-prepend">
                                        <input type="text" name="id" class="input-small" placeholder="Código" disabled />
                                		<span class="add-on"><i class="icon-qrcode"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    Nome<br>
                                    <div class="input-prepend">
                                    	<input type="text" name="nome" class="input-xlarge" placeholder="Nome" />
                                		<span class="add-on"><i class="icon-edit"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    CNPJ<br>
                                    <div class="input-prepend">
                                    	<input type="text" name="cpf" class="input-medium" placeholder="Informe um CNPJ válido" />
                                		<span class="add-on"><i class="iconfa-credit-card"></i></span>
                                    </div>
                                </div>
                                
                                <!--<div class="col-md-2">
                                    RG<br>
                                    <div class="input-prepend">
                                    	<input type="text" name="rg" class="input-small" placeholder="Informe um RG válido" />
                                		<span class="add-on"><i class="iconfa-credit-card"></i></span>
                                    </div>
                                </div>-->
                            
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                            	<div class="col-md-3">
                                    Telefone 1<br>
                                    <div class="input-prepend">
                                    	<input type="text" name="telefone1" class="input-medium" placeholder="Telefone 1" />
                                		<span class="add-on"><i class="iconfa-phone"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    Telefone 2<br>
                                    <div class="input-prepend">
                                    	<input type="text" name="telefone2" class="input-medium" placeholder="Telefone 2" />
                                		<span class="add-on"><i class="iconfa-phone"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    E-mail<br>
                                    <div class="input-prepend">
                                    	<input type="email" name="email" class="input-large" placeholder="Informe um email válido" />
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
                            				<option value="<?php echo $row_rs_estado['id'];?>" /><?php echo $row_rs_estado['nome'];?>
                       					<?php }while($row_rs_estado = mysql_fetch_assoc($rs_estado));?>         
                       					</select>
                                        
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <span id="janela_cidades"></span>
                                </div>
                               
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                            	
                                <div class="col-md-2">
                                    CEP<br>
                                    <div class="input-prepend">
                                        <input type="text" name="cep" class="input-small" placeholder="CEP"/>
                                		<span class="add-on"><i class="icon-edit"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    Endere&ccedil;o<br>
                                    <div class="input-prepend">
                                    	<input type="text" name="endereco" class="input-xxlarge" placeholder="Informe o endereço" />
                                		<span class="add-on"><i class="icon-home"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    N&uacute;mero<br>
                                    <div class="input-prepend">
                                    	<input type="text" name="numero" class="input-small" placeholder="Informe o número"/>
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
                                        <input type="text" name="complemento" class="input-xlarge" placeholder="Informe o complemento"/>
                                		<span class="add-on"><i class="icon-pencil"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    Bairro<br>
                                    <div class="input-prepend">
                                    	<input name="bairro" type="text" class="input-xlarge" id="bairro" placeholder=" Informe o bairro" />
                                		<span class="add-on"><i class="icon-asterisk"></i></span>
                                    </div>
                                </div>
                               
                            
                            </div>
                        </div>
                        
                 
                        
                        
                      <div class="row">
                      	<div class="col-md-12" align="right">
                        	 <a href="javascript:;" onClick="document.getElementById('formAddCLiente').submit();" class="btn btn-mini btn-success"> <i class="iconfa-ok"></i>&nbsp; Salvar</a>
                             <a href="cliente.php" class="btn btn-danger btn-mini"> <i class="iconfa-remove"></i>&nbsp; Cancelar</a>
                        </div>
                      </div>
                   <input type="hidden" name="MM_insert" id="MM_insert" value="formAddCLiente">
                </form>
           
            </div><!--widgetcontent-->
            </div><!--widget-->
            
       
            <?php include_once('footer.php');?>