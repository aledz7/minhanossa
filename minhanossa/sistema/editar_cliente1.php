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

$colname_rs_editar_cliente = "-1";
if (isset($_GET['id'])) {
  $colname_rs_editar_cliente = $_GET['id'];
}
mysql_select_db($database_conexao, $conexao);
$query_rs_editar_cliente = sprintf("SELECT * FROM tbl_cliente WHERE id = %s", GetSQLValueString($colname_rs_editar_cliente, "int"));
$rs_editar_cliente = mysql_query($query_rs_editar_cliente, $conexao) or die(mysql_error());
$row_rs_editar_cliente = mysql_fetch_assoc($rs_editar_cliente);
$totalRows_rs_editar_cliente = mysql_num_rows($rs_editar_cliente);
?>
<?php include_once('head.php');?>

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
                    <form class="stdform" method="post" action="" />
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
                                    <label>Código</label>
                                    <span class="field">
                                    	<input type="text" name="id" id="firstname" class="input-xxlarge" disabled value="<?php echo $row_rs_editar_cliente['id']?>"/>
                                    </span>
                                </p>
                                
                                <p>
                                    <label>Nome</label>
                                    <span class="field">
                                    	<input type="text" name="nome" class="input-xxlarge" placeholder="Informe o nome do cliente" value="<?php echo $row_rs_editar_cliente['nome']?>"  />
                                    </span>
                                </p>
                                
                                 <p>
                                    <label>CPF</label>
                                    <span class="field">
                                    	<input type="text" name="cpf" class="input-xxlarge" placeholder="Informe um CPF válido" value="<?php echo $row_rs_editar_cliente['cpf']?>"  />
                                    </span>
                                </p>
                                 <p>
                                    <label>RG</label>
                                    <span class="field">
                                    	<input type="text" name="rg" class="input-xxlarge" placeholder="Informe um RG válido" value="<?php echo $row_rs_editar_cliente['rg']?>" />
                                    </span>
                                </p>
                                                                
                               
                                
                        	
                            
                        </div><!--#wiz1step1-->
                        
                        <div id="wiz1step2" class="formwiz">
                        	<h4 class="widgettitle"><strong>Passo 2</strong> - Contato</h4>
                            
                                <p>
                                    <label>Telefone 1</label>
                                    <span class="field">
                                    	<input type="text" name="telefone1" class="input-xxlarge" placeholder="Informe o Telefone 1" value="<?php echo $row_rs_editar_cliente['telefone1']?>"  />
                                    </span>
                                </p>
                                 <p>
                                    <label>Telefone 2</label>
                                    <span class="field">
                                    	<input type="text" name="telefone2" class="input-xxlarge" placeholder="Informe o Telefone 2" value="<?php echo $row_rs_editar_cliente['telefone2']?>" />
                                    </span>
                                </p>
                                <p>
                                    <label>Email</label>
                                    <span class="field">
                                    	<input type="text" name="email" class="input-xxlarge" placeholder="Informe um email válido" value="<?php echo $row_rs_editar_cliente['email']?>" />
                                    </span>
                                </p>
                                                                                               
                        </div><!--#wiz1step2-->
                        
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
                                    	<input type="text" name="cep" class="input-xxlarge" placeholder="Informe o CEP" value="<?php echo $row_rs_editar_cliente['cep']?>" />
                                    </span>
                                </p>
                                <p>
                                    <label>Endereço</label>
                                    <span class="field">
                                    	<input type="text" name="endereco" class="input-xxlarge" placeholder="Informe o endereço" value="<?php echo $row_rs_editar_cliente['endereco']?>" />
                                    </span>
                                </p>
                                <p>
                                    <label>Número</label>
                                    <span class="field">
                                    	<input type="text" name="numero" class="input-xxlarge" placeholder="Informe o número" value="<?php echo $row_rs_editar_cliente['numero']?>" />
                                    </span>
                                </p>
                                <p>
                                    <label>Complemento</label>
                                    <span class="field">
                                    	<input type="text" name="complemento" class="input-xxlarge" placeholder="Informe o completo" value="<?php echo $row_rs_editar_cliente['complemento']?>" />
                                    </span>
                                </p>
                                <p>
                                    <label>Bairro</label>
                                    <span class="field">
                                    	<input type="text" name="bairro" class="input-xxlarge" placeholder="Informe o bairro" value="<?php echo $row_rs_editar_cliente['bairro']?>" />
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
                    <input type="hidden" name="id" value="<?php echo $row_rs_editar_cliente['id']?>">
                    </form>
                    <!-- <?php
mysql_free_result($rs_editar_cliente);
?>END OF DEFAULT WIZARD -->
                    
                    <div class="clearfix"></div><br /><br />
             
<?php include_once('footer.php');?>