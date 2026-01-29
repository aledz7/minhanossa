<?php 
include('restrito.php');
include('Connections/conexao.php');
include('funcoes.php');

mysql_select_db($database_conexao, $conexao);
$query_rs_planos = "SELECT * FROM tbl_plano ORDER BY nome ASC";
$rs_planos = mysql_query($query_rs_planos, $conexao) or die(mysql_error());
$row_rs_planos = mysql_fetch_assoc($rs_planos);
$totalRows_rs_planos = mysql_num_rows($rs_planos);

mysql_select_db($database_conexao, $conexao);
$query_rs_prazos = "SELECT * FROM tbl_emprestimos ORDER BY nome ASC";
$rs_prazos = mysql_query($query_rs_prazos, $conexao) or die(mysql_error());
$row_rs_prazos = mysql_fetch_assoc($rs_prazos);
$totalRows_rs_prazos = mysql_num_rows($rs_prazos);

mysql_select_db($database_conexao, $conexao);
$query_rs_estado = "SELECT * FROM dados_estados ORDER BY nome ASC";
$rs_estado = mysql_query($query_rs_estado, $conexao) or die(mysql_error());
$row_rs_estado = mysql_fetch_assoc($rs_estado);
$totalRows_rs_estado = mysql_num_rows($rs_estado);

mysql_select_db($database_conexao, $conexao);
$query_rs_editar_cliente = "SELECT * FROM tbl_cliente WHERE id = '".$_GET['id']."'";
$rs_editar_cliente = mysql_query($query_rs_editar_cliente, $conexao) or die(mysql_error());
$row_rs_editar_cliente = mysql_fetch_assoc($rs_editar_cliente);
$totalRows_rs_editar_cliente = mysql_num_rows($rs_editar_cliente);

if((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "formEditCLiente")) {

	$updateSQL = sprintf("UPDATE tbl_cliente SET nome=%s, cpf=%s, rg=%s, telefone1=%s, telefone2=%s, email=%s, estado=%s, cidade=%s, cep=%s, endereco=%s, numero=%s, complemento=%s, bairro=%s, aniversario=%s, tamanho_uso=%s, termo_de_uso=%s, id_plano=%s, data_contratacao=%s, data_vencimento=%s, pontuacao=%s, atendente=%s, nome_cartao=%s, numero_cartao=%s, mes_cartao=%s, ano_cartao=%s, cod_cartao=%s, tipo_cliente=%s, ativo=%s, senha=%s, plano_tipo=%s, pontos=%s, nome_2=%s, cpf_2=%s, telefone1_2=%s, telefone2_2=%s, nome_3=%s, cpf_3=%s, telefone1_3=%s, telefone2_3=%s, nome_4=%s, cpf_4=%s, telefone1_4=%s, telefone2_4=%s, renovacoes=%s, id_prazo=%s, quantidade_pecas=%s WHERE id=%s",
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
                       GetSQLValueString($_POST['aniversario'], "text"),
                       GetSQLValueString($_POST['tamanho_uso'], "text"),
                       GetSQLValueString($_POST['termo_de_uso'], "text"),
                       GetSQLValueString($_POST['id_plano'], "text"),
                       GetSQLValueString($_POST['data_contratacao'], "text"),
                       GetSQLValueString($_POST['data_vencimento'], "text"),
                       GetSQLValueString($_POST['pontuacao'], "text"),
                       GetSQLValueString($_POST['atendente'], "text"),
                       GetSQLValueString($_POST['nome_cartao'], "text"),
                       GetSQLValueString($_POST['numero_cartao'], "text"),
                       GetSQLValueString($_POST['mes_cartao'], "text"),
                       GetSQLValueString($_POST['ano_cartao'], "text"),
                       GetSQLValueString($_POST['cod_cartao'], "text"),
                       GetSQLValueString($_POST['tipo_cliente'], "text"),
                       GetSQLValueString($_POST['ativo'], "text"),
                       GetSQLValueString($_POST['senha'], "text"),
                       GetSQLValueString($_POST['plano_tipo'], "text"),
                       GetSQLValueString($_POST['pontos'], "text"),
					   GetSQLValueString($_POST["nome_2"], "text"),
					   GetSQLValueString($_POST["cpf_2"], "text"),
					   GetSQLValueString($_POST["telefone1_2"], "text"),
					   GetSQLValueString($_POST["telefone2_2"], "text"),
					   GetSQLValueString($_POST["nome_3"], "text"),
					   GetSQLValueString($_POST["cpf_3"], "text"),
					   GetSQLValueString($_POST["telefone1_3"], "text"),
					   GetSQLValueString($_POST["telefone2_3"], "text"),
					   GetSQLValueString($_POST["nome_4"], "text"),
					   GetSQLValueString($_POST["cpf_4"], "text"),
					   GetSQLValueString($_POST["telefone1_4"], "text"),
					   GetSQLValueString($_POST["telefone2_4"], "text"),
					   GetSQLValueString($_POST["renovacoes"], "text"),
					   GetSQLValueString($_POST["id_prazo"], "text"),
					   GetSQLValueString($_POST["quantidade_pecas"], "text"),
                       GetSQLValueString($_POST['id'], "int")); 
		mysql_select_db($database_conexao, $conexao);
		$Result1 = mysql_query($updateSQL, $conexao) or die(mysql_error());
	
	marcaHistoricoAlteracao("Modificou o cliente {$_POST['nome']}.");
	
		$idConteudo = $_POST['id'][$i];

			echo "
				<script>
					window.location='cliente.php';
				</script>
			";			
		
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>

<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Editar Cliente</title>

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

<meta charset=utf-8 />
</head>

<body>
<?php //include_once('head.php');?>

<div class="mainwrapper">
    
<?php include_once('header.php');?>
    
<?php include_once('inc_coluna.php');?>
    
    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="."><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li><a href="cliente.php">Cliente</a> <span class="separator"></span></li>
            <li>Atualizar Cliente</li>
        </ul>
        <div class="maincontent">
            <div class="maincontentinner">
            
            <div class="widget">
            <h4 class="widgettitle"><span class="iconfa-edit"></span>Atualiza Cliente</h4>
           <div class="widgetcontent">
           
           
               <form class="stdform" action="" method="post" name="formEditCLiente" id="formEditCLiente" />
                    	
                        <div class="row">
                            <div class="col-md-12">
                            	<div class="col-md-2">
                                    C&oacute;digo<br>
                                    <div class="input-prepend">
                                        <input type="text" name="id" class="input-small" placeholder="Código" disabled value="<?php echo $row_rs_editar_cliente['id'];?>"/>
                                		<span class="add-on"><i class="icon-qrcode"></i></span>
                                    </div>
                                </div>
                            	<div class="col-md-2">
                                    Termo de Uso<br>
                                    <div class="input-prepend">
                                        
                                        <input type="checkbox" name="termo_uso" id="termo_uso" class="input-small" value="S" <?php  if($row_rs_editar_cliente['termo_uso'] == 'S'){ echo "checked";};?>/>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    Ativo<br>
                                    <div class="input-prepend">
                                        
                                        <input type="checkbox" name="ativo" id="ativo" class="input-small" value="S" <?php  if($row_rs_editar_cliente['ativo'] == 'S'){ echo "checked";};?>/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                            	<div class="col-md-4">
                                    Tipo Cliente<br>
                                    <div class="input-prepend">
                                        <select name="tipo_cliente" class="input-middle">
                                            <option value="L" <?php  if($row_rs_editar_cliente['tipo_cliente'] == 'L'){ echo "selected";};?>>Loja F&iacute;sica</option>
                                            <option value="S" <?php  if($row_rs_editar_cliente['tipo_cliente'] == 'S'){ echo "selected";};?>> E-commerce</option>
                                        </select>
                                      
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">    

                                
                                <div class="col-md-4 container_nome">
                                    Nome<br>
                                    <div class="input-prepend ">
                                        <input name="nome" type="text" required="required" class="input-xlarge" placeholder="Nome" value="<?php echo $row_rs_editar_cliente['nome'];?>" />
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    Anivers&aacute;rio<br>
                                    <div class="input-prepend">
                                    	<input name="aniversario" type="date" required="required" class="input-medium"  value="<?php echo $row_rs_editar_cliente['aniversario'];?>" />
                                		<span class="add-on"><i class="iconfa-calendar"></i></span>
                                    </div>
                                </div>
                                <?php /*?><div class="col-md-3">
                                    Pontua&ccedil;&atilde;o<br>
                                    <div class="input-prepend">
                                    	<input name="pontuacao" type="text" class="input-medium" value="<?php echo $row_rs_editar_cliente['pontuacao'];?>" />
                                		<span class="add-on"><i class="iconfa-date"></i></span>
                                    </div>
                                </div><?php */?>
                                
                              
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">    

                               
                                <div class="col-md-3">
                                    CPF<br>
                                    <div class="input-prepend">
                                        <input name="cpf" type="text" required="required" class="input-medium" placeholder="Informe um CPF v&aacute;lido" value="<?php echo $row_rs_editar_cliente['cpf'];?>" />
                                		<span class="add-on"><i class="iconfa-credit-card"></i></span>
                                    </div>
                                </div>
                                
                                <div class="col-md-2">
                                    RG<br>
                                    <div class="input-prepend">
                                        <input type="text" name="rg" class="input-small" placeholder="Informe um RG v&aacute;lido" value="<?php echo $row_rs_editar_cliente['rg'];?>" />
                                		<span class="add-on"><i class="iconfa-credit-card"></i></span>
                                    </div>
                                </div>
                            
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                            	<div class="col-md-3">
                                    Telefone 1<br>
                                    <div class="input-prepend">
                                    	<input type="text" name="telefone1" class="input-medium" placeholder="Telefone 1" value="<?php echo $row_rs_editar_cliente['telefone1'];?>" />
                                		<span class="add-on"><i class="iconfa-phone"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    Telefone 2<br>
                                    <div class="input-prepend">
                                    	<input type="text" name="telefone2" class="input-medium" placeholder="Telefone 2" value="<?php echo $row_rs_editar_cliente['telefone2'];?>" />
                                		<span class="add-on"><i class="iconfa-phone"></i></span>
                                    </div>
                                </div>
                               
                            
                            </div>
                        </div>
                        
			   <br>
                        <div class="row">
                            <div class="col-md-12">
								<div class="col-md-4 container_nome">
                                    Nome 2<br>
                                    <div class="input-prepend ">
                                        <input name="nome_2" type="text" class="input-xlarge" placeholder="Nome" value="<?php echo $row_rs_editar_cliente['nome_2'];?>" />
                                    </div>
                                </div>
								<div class="col-md-3">
                                    CPF<br>
                                    <div class="input-prepend">
                                    	<input name="cpf_2" type="text" class="input-medium" placeholder="Informe um CPF válido" value="<?php echo $row_rs_editar_cliente['cpf_2'];?>"/>
                                		<span class="add-on"><i class="iconfa-credit-card"></i></span>
                                    </div>
                                </div>
                            	<div class="col-md-2">
                                    Telefone 1<br>
                                    <div class="input-prepend">
                                    	<input type="text" name="telefone1_2" class="input-medium" placeholder="Telefone 1" value="<?php echo $row_rs_editar_cliente['telefone1_2'];?>" />
                                		<!--<span class="add-on"><i class="iconfa-phone"></i></span>-->
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    Telefone 2<br>
                                    <div class="input-prepend">
                                    	<input type="text" name="telefone2_2" class="input-medium" placeholder="Telefone 2" value="<?php echo $row_rs_editar_cliente['telefone2_2'];?>" />
                                		<!--<span class="add-on"><i class="iconfa-phone"></i></span>-->
                                    </div>
                                </div>
                             
                            
                            </div>
                        </div>
						<br>
                        <div class="row">
                            <div class="col-md-12">
								<div class="col-md-4 container_nome">
                                    Nome 3<br>
                                    <div class="input-prepend ">
                                        <input name="nome_3" type="text" class="input-xlarge" placeholder="Nome" value="<?php echo $row_rs_editar_cliente['nome_3'];?>" />
                                    </div>
                                </div>
								<div class="col-md-3">
                                    CPF<br>
                                    <div class="input-prepend">
                                    	<input name="cpf_3" type="text" class="input-medium" placeholder="Informe um CPF válido" value="<?php echo $row_rs_editar_cliente['cpf_3'];?>"/>
                                		<span class="add-on"><i class="iconfa-credit-card"></i></span>
                                    </div>
                                </div>
                            	<div class="col-md-2">
                                    Telefone 1<br>
                                    <div class="input-prepend">
                                    	<input type="text" name="telefone1_3" class="input-medium" placeholder="Telefone 1" value="<?php echo $row_rs_editar_cliente['telefone1_3'];?>" />
                                		<!--<span class="add-on"><i class="iconfa-phone"></i></span>-->
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    Telefone 2<br>
                                    <div class="input-prepend">
                                    	<input type="text" name="telefone2_3" class="input-medium" placeholder="Telefone 2" value="<?php echo $row_rs_editar_cliente['telefone2_3'];?>" />
                                		<!--<span class="add-on"><i class="iconfa-phone"></i></span>-->
                                    </div>
                                </div>
                             
                            
                            </div>
                        </div>
						<br>
                        <div class="row">
                            <div class="col-md-12">
								<div class="col-md-4 container_nome">
                                    Nome 4<br>
                                    <div class="input-prepend ">
                                        <input name="nome_4" type="text" class="input-xlarge" placeholder="Nome" value="<?php echo $row_rs_editar_cliente['nome_4'];?>" />
                                    </div>
                                </div>
								<div class="col-md-3">
                                    CPF<br>
                                    <div class="input-prepend">
                                    	<input name="cpf_4" type="text" class="input-medium" placeholder="Informe um CPF válido" value="<?php echo $row_rs_editar_cliente['cpf_4'];?>"/>
                                		<span class="add-on"><i class="iconfa-credit-card"></i></span>
                                    </div>
                                </div>
                            	<div class="col-md-2">
                                    Telefone 1<br>
                                    <div class="input-prepend">
                                    	<input type="text" name="telefone1_4" class="input-medium" placeholder="Telefone 1" value="<?php echo $row_rs_editar_cliente['telefone1_4'];?>" />
                                		<!--<span class="add-on"><i class="iconfa-phone"></i></span>-->
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    Telefone 2<br>
                                    <div class="input-prepend">
                                    	<input type="text" name="telefone2_4" class="input-medium" placeholder="Telefone 2" value="<?php echo $row_rs_editar_cliente['telefone2_4'];?>" />
                                		<!--<span class="add-on"><i class="iconfa-phone"></i></span>-->
                                    </div>
                                </div>
                             
                            
                            </div>
                        </div>
						<br>
			   
                         <div class="row">
                            <div class="col-md-12">
                            	
                             
                                <div class="col-md-5">
                                    E-mail<br>
                                    <div class="input-prepend">
                                    	  <input type="email" name="email" class="input-large" placeholder="Informe um email v&aacute;lido" value="<?php echo $row_rs_editar_cliente['email'];?>" />
                                		<span class="add-on"><i class="iconfa-envelope-alt"></i></span>
                                    </div>
                                </div>
                                
                                <div class="col-md-5">
                                    Senha<br>
                                    <div class="input-prepend">
                                    	<input type="password" name="senha" class="input-xlarge" placeholder="Senha" value="<?php echo $row_rs_editar_cliente['senha'];?>" />
                                		
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
                                                        <option value="<?php echo $row_rs_estado['id'];?>" <?php if($row_rs_editar_cliente['estado'] == $row_rs_estado['id']){ echo "selected";}?> /><?php echo utf8_encode($row_rs_estado['nome']);?>
                       					<?php }while($row_rs_estado = mysql_fetch_assoc($rs_estado));?>         
                       					</select>
                                        
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <span id="janela_cidades">
                                        
                                        <?php 
									$_GET['id_estado'] = $row_rs_editar_cliente['estado'];
									$_GET['id_cidade'] = $row_rs_editar_cliente['cidade'];
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
                                        <input type="text" name="cep" class="input-small" id="cep" placeholder="CEP" value="<?php echo $row_rs_editar_cliente['cep'];?>" size="10" maxlength="9" onblur="pesquisacep(this.value);"/>
                                		<span class="add-on"><i class="icon-edit"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    Endere&ccedil;o<br>
                                    <div class="input-prepend">
                                        <input type="text" name="endereco" class="input-xxlarge" placeholder="Informe o endere&ccedil;o" value="<?php echo $row_rs_editar_cliente['endereco'];?>" id="endereco" />
                                		<span class="add-on"><i class="icon-home"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    N&uacute;mero<br>
                                    <div class="input-prepend">
                                        <input type="text" name="numero" class="input-small" placeholder="Informe o n&uacute;mero" value="<?php echo $row_rs_editar_cliente['numero'];?>"/>
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
                                        <input type="text" name="complemento" class="input-xlarge" placeholder="Informe o complemento" value="<?php echo $row_rs_editar_cliente['complemento'];?>"/>
                                		<span class="add-on"><i class="icon-pencil"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    Bairro<br>
                                    <div class="input-prepend">
                                    	<input name="bairro" type="text" class="input-xlarge" id="bairro" placeholder=" Informe o bairro" value="<?php echo $row_rs_editar_cliente['bairro'];?>" />
                                		<span class="add-on"><i class="icon-asterisk"></i></span>
                                    </div>
                                </div>
                               
                            
                            </div>
                        </div>
                
               
               <div class="row">
                            <div class="col-md-12">
                            	<div class="col-md-12">
                                    Tamanho que usa em cada Marca<br>
                                    <div class="input-prepend">
                                        <textarea name="tamanho_uso" id="tamanho_uso" rows="2" class="span5" style="width:1000px;"><?php echo $row_rs_editar_cliente['tamanho_uso'];?></textarea>
                                		
                                    </div>
                                </div>
                            </div>
                        </div>
               <div class="row">
                            <div class="col-md-12">
                            	<div class="col-md-12">
                                    Observações<br>
                                    <div class="input-prepend">
                                        <textarea name="atendente" id="atendente" rows="2" class="span5" style="width:1000px;"><?php echo $row_rs_editar_cliente['atendente'];?></textarea>
                                		
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                            	<div class="col-md-12">
                                    Renovações<br>
                                    <div class="input-prepend">
                                        <textarea name="renovacoes" id="renovacoes" rows="2" class="span5" style="width:1000px;"><?php echo $row_rs_editar_cliente['renovacoes'];?></textarea>
                                		
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                 <div class="row">
                            <div class="col-md-12">
                            	<div class="col-md-4">
                                    Nome Cart&atilde;o<br>
                                    <div class="input-prepend">
                                        <input type="text" name="nome_cartao" class="input-medium" placeholder="Nome Cart&atilde;o" value="<?php echo $row_rs_editar_cliente['nome_cartao'];?>" />
                                		<span class="add-on"><i class="iconfa-pencil"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    N&uacute;mero Cart&aacute;o<br>
                                    <div class="input-prepend">
                                        <input type="text" name="numero_cartao" class="input-medium" placeholder="Número Cart&atilde;o" maxlength="16" value="<?php echo $row_rs_editar_cliente['numero_cartao'];?>" />
                                		<span class="add-on"><i class="iconfa-pencil"></i></span>
                                    </div>
                                </div>
                                                           
                            </div>
                        </div>
                 <div class="row">
                            <div class="col-md-12">
                            	<div class="col-md-2">
                                    M&ecirc;s Cart&atilde;o<br>
                                    <div class="input-prepend">
                                    	<input type="text" name="mes_cartao" class="input-small" maxlength="2" value="<?php echo $row_rs_editar_cliente['mes_cartao'];?>" />
                                		<span class="add-on"><i class="iconfa-pencil"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    Ano Cart&atilde;o<br>
                                    <div class="input-prepend">
                                    	<input type="text" name="ano_cartao" class="input-small" maxlength="4" value="<?php echo $row_rs_editar_cliente['ano_cartao'];?>"/>
                                		<span class="add-on"><i class="iconfa-pencil"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    C&oacute;d. Cart&atilde;o<br>
                                    <div class="input-prepend">
                                    	<input type="text" name="cod_cartao" class="input-small" maxlength="4" value="<?php echo $row_rs_editar_cliente['cod_cartao'];?>"/>
                                		<span class="add-on"><i class="iconfa-pencil"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    Prazo do Empréstimo<br>
                                    <div class="input-prepend">
                                         
                                    	<select name="id_prazo" id="id_prazo" class="uniformselect">
                       					<?php do{?>
											<option value="<?php echo $row_rs_prazos['id'];?>" <?php if($row_rs_editar_cliente['id_prazo'] == $row_rs_prazos['id']){ echo "selected";}?> /><?php echo $row_rs_prazos['nome'];?>
                       					<?php }while($row_rs_prazos = mysql_fetch_assoc($rs_prazos));?>         
                       					</select>
                                        
                                    </div>
                                </div>                           
                            </div>
                        </div>
                 <div class="row">
                            <div class="col-md-12">
                            	<div class="col-md-4">
                                    Plano Contrato<br>
                                    <div class="input-prepend">
                                        <select name="id_plano" class="input-xlarge">
                                            <option value="">-SELECIONE-</option>
                                            <?php do{?>
                                            <option value="<?php echo $row_rs_planos['id'];?>" <?php if($row_rs_editar_cliente['id_plano'] == $row_rs_planos['id']){ echo "selected";}?>><?php echo $row_rs_planos['nome'];?></option>
                                            <?php }while($row_rs_planos = mysql_fetch_assoc($rs_planos));?>
                                        </select>
                                        	<span class="add-on"><i class="iconfa-pencil"></i></span>
                                    </div>
                                </div>
                              <div class="col-md-4">
                                   Tipo Plano<br>
                                    <div class="input-prepend">
                                        <select name="plano_tipo" class="input-xlarge">
                                            <option value="">-SELECIONE-</option>
                                            <option value="M" <?php if($row_rs_editar_cliente['plano_tipo'] == 'M'){ echo "selected";}?>>MENSAL</option>
                                            <option value="T" <?php if($row_rs_editar_cliente['plano_tipo'] == 'T'){ echo "selected";}?>>TRIMESTRAL</option>
                                            <option value="S" <?php if($row_rs_editar_cliente['plano_tipo'] == 'S'){ echo "selected";}?>>SEMESTRAL</option>
                                        </select>
                                    	
                                		<span class="add-on"><i class="iconfa-pencil"></i></span>
                                    </div>
                                </div>
                               
                                 <div class="col-md-3">
                                    Pontos<br>
                                    <div class="input-prepend">
                                    	<input type="text" name="pontos" class="input-small" value="<?php echo $row_rs_editar_cliente['pontos'];?>"/>
                                		
                                    </div>
                                </div>                              
                            </div>
                        </div>
                        
                         <div class="row">
                            <div class="col-md-12">
                            	
                                <div class="col-md-4">
                                    Data Contrata&ccedil;&atilde;o<br>
                                    <div class="input-prepend">
                                    	<input type="date" name="data_contratacao" class="input-xlarge" value="<?php echo $row_rs_editar_cliente['data_contratacao'];?>"/>
                                		<span class="add-on"><i class="iconfa-calendar"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    Vencimento Plano<br>
                                    <div class="input-prepend">
                                    	<input type="date" name="data_vencimento" class="input-xlarge" value="<?php echo $row_rs_editar_cliente['data_vencimento'];?>"/>
                                		<span class="add-on"><i class="iconfa-pencil"></i></span>
                                    </div>
                                </div>
                                   <div class="col-md-3">
                                    Quantidade de Peças<br>
                                    <div class="input-prepend">
                                    	<input type="text" name="quantidade_pecas" class="input-small" value="<?php echo $row_rs_editar_cliente['quantidade_pecas'];?>"/>
                                		
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
                   <input type="hidden" name="id" id="id" value="<?php echo $row_rs_editar_cliente['id']?>">
                   <input type="hidden" name="MM_update" id="MM_update" value="formEditCLiente">
                </form>
           
            </div><!--widgetcontent-->
            </div><!--widget-->
            
       <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
 <script>
 // Registra o evento blur do campo "cep", ou seja, quando o usuário sair do campo "cep" faremos a consulta dos dados
 $("#cep").blur(function(){
 // Para fazer a consulta, removemos tudo o que não é número do valor informado pelo usuário
 var cep = this.value.replace(/[^0-9]/, "");
 
 // Validação do CEP; caso o CEP não possua 8 números, então cancela a consulta
 if(cep.length!=8){
 return false;
 }
 
 // Utilizamos o webservice "viacep.com.br" para buscar as informações do CEP fornecido pelo usuário.
 // A url consiste no endereço do webservice ("http://viacep.com.br/ws/"), mais o cep que o usuário
 // informou e também o tipo de retorno que desejamos, podendo ser "xml", "piped", "querty" ou o que
 // iremos utilizar, que é "json"
 var url = "http://viacep.com.br/ws/"+cep+"/json/";
 
 // Aqui fazemos uma requisição ajax ao webservice, tratando o retorno com try/catch para que caso ocorra algum
 // erro (o cep pode não existir, por exemplo) o usuário não seja afetado, assim ele pode continuar preenchendo os campos
 $.getJSON(url, function(dadosRetorno){
 try{
 // Insere os dados em cada campo
 $("#endereco").val(dadosRetorno.logradouro);
 $("#bairro").val(dadosRetorno.bairro);
 $("#cidade").val(dadosRetorno.localidade);
 $("#uf").val(dadosRetorno.uf);
 }catch(ex){}
 });
 });
 </script>
<?php include_once('footer.php');?>