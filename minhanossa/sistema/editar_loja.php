<?php require_once('Connections/conexao.php'); ?>
<?php
include('funcoes.php');

mysql_select_db($database_conexao, $conexao);
$query_rs_estado = "SELECT * FROM dados_estados ORDER BY nome ASC";
$rs_estado = mysql_query($query_rs_estado, $conexao) or die(mysql_error());
$row_rs_estado = mysql_fetch_assoc($rs_estado);
$totalRows_rs_estado = mysql_num_rows($rs_estado);

mysql_select_db($database_conexao, $conexao);
$query_rs_editar_loja = "SELECT * FROM tbl_loja WHERE id = '".$_GET['id']."'";
$rs_editar_loja = mysql_query($query_rs_editar_loja, $conexao) or die(mysql_error());
$row_rs_editar_loja = mysql_fetch_assoc($rs_editar_loja);
$totalRows_rs_editar_loja = mysql_num_rows($rs_editar_loja);

/*mysql_select_db($database_conexao, $conexao);
$query_rs_clausula_contrato = "SELECT * FROM clausula_contrato";
$rs_clausula_contrato = mysql_query($query_rs_clausula_contrato, $conexao) or die(mysql_error());
$row_rs_clausula_contrato = mysql_fetch_assoc($rs_clausula_contrato);
$totalRows_rs_clausula_contrato = mysql_num_rows($rs_clausula_contrato);*/

if((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "formEditLoja")) {

	$updateSQL = sprintf("UPDATE tbl_loja SET meta=%s, nome=%s, cnpj=%s, razao_social=%s, telefone1=%s, telefone2=%s, email=%s, cep=%s, logradouro=%s, numero=%s, cidade=%s, estado=%s, valor_diaria_atraso=%s, valor_multa_cancelamento=%s, valor_multa_cancelamento2=%s, horario_funcionamento_semana=%s, horario_funcionamento_final_semana=%s, horario_funcionamento_troca=%s, linkFacebook=%s, linkTwitter=%s, linkInstagram=%s WHERE id=%s",
                       GetSQLValueString(valorCalculavel($_POST['meta']), "text"),
                       GetSQLValueString($_POST['nome'], "text"),
                       GetSQLValueString($_POST['cnpj'], "text"),
                       GetSQLValueString($_POST['razao_social'], "text"),
                       GetSQLValueString($_POST['telefone1'], "text"),
                       GetSQLValueString($_POST['telefone2'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['cep'], "text"),
                       GetSQLValueString($_POST['logradouro'], "text"),
                       GetSQLValueString($_POST['numero'], "text"),
                       GetSQLValueString($_POST['cidade'], "text"),
                       GetSQLValueString($_POST['estado'], "text"),
                       GetSQLValueString($_POST['valor_diaria_atraso'], "text"),
					   GetSQLValueString($_POST["valor_multa_cancelamento"], "text"),
					   GetSQLValueString($_POST['valor_multa_cancelamento2'], "text"),
					   GetSQLValueString($_POST['horario_funcionamento_semana'], "text"),
                       GetSQLValueString($_POST['horario_funcionamento_final_semana'], "text"),
					   GetSQLValueString($_POST['horario_funcionamento_troca'], "text"),
					   GetSQLValueString($_POST['linkFacebook'], "text"),
					   GetSQLValueString($_POST['linkTwitter'], "text"),
					   GetSQLValueString($_POST['linkInstagram'], "text"),
                       GetSQLValueString($_POST['id'], "int")); 

   /* echo "<script>alert('".$_POST['estado']."');</script>";*/
	mysql_select_db($database_conexao, $conexao);
	$Result1 = mysql_query($updateSQL, $conexao) or die(mysql_error());
	
	/// contrato
	/*$updateSQL = sprintf("UPDATE clausula_contrato SET clausula=%s",
				   GetSQLValueString($_POST['clausula'], "text")); 
	mysql_select_db($database_conexao, $conexao);
	$Result1 = mysql_query($updateSQL, $conexao) or die(mysql_error());*/
	
	marcaHistoricoAlteracao("Modificou as configurações da loja {$_POST['nome']}.");
	
	$idConteudo = $_POST['id'][$i];

	echo "	<script>
			alert('Modificação realizada com sucesso.');
			window.location='.';
			</script>";			
			exit;		
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
<title>Editar Loja</title>

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
            <li><a href="loja.php">Loja</a> <span class="separator"></span></li>
            <li>Editar Loja</li>
        </ul>
        <div class="maincontent">
            <div class="maincontentinner">
            
            <div class="widget">
            <h4 class="widgettitle"><span class="iconfa-th"></span>Editar Loja</h4>
            <div class="widgetcontent" style="min-height:700px" >
           
           
               <form class="stdform" action="" method="post" name="formEditLoja" id="formEditLoja" />
                    	
                        <div class="row">
                            <div class="col-md-12">
                            	<div class="col-md-2">
                                    C&oacute;digo<br>
                                    <div class="input-prepend">
                                        <input type="text" name="id" class="input-small" placeholder="Código" value="<?php echo $row_rs_editar_loja['id']?>" id="kjkk" />
                                		<span class="add-on"><i class="icon-qrcode"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    Nome<br>
                                    <div class="input-prepend">
                                    	<input type="text" name="nome" class="input-xlarge" placeholder="Nome" value="<?php echo $row_rs_editar_loja['nome']?>" />
                                		<span class="add-on"><i class="icon-edit"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    CNPJ<br>
                                    <div class="input-prepend">
                                    	<input type="text" name="cnpj" class="input-medium" placeholder="CNPJ" value="<?php echo $row_rs_editar_loja['cnpj']?>" />
                                		<span class="add-on"><i class="icon-qrcode"></i></span>
                                    </div>
                                </div>
                                
                                
                                
                                <div class="col-md-2">
                                    Meta<br>
                                    <div class="input-prepend">
                                    	<input type="text" name="meta" class="input-medium" placeholder="Meta" value="<?php echo number_format($row_rs_editar_loja['meta'],2,',','.')?>" />
                                		<span class="add-on"><i class="icon-qrcode"></i></span>
                                    </div>
                                </div>
                            
                            </div>
                        </div>
              <div class="row">
                <div class="col-md-12">
                            	<div class="col-md-4">
                                    Raz&atilde;o social<br>
                                    <div class="input-prepend">
                                        <input type="text" name="razao_social" class="input-xlarge" placeholder="Razão Social" value="<?php echo $row_rs_editar_loja['razao_social']?>"/>
                                		<span class="add-on"><i class="icon-edit"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    Telefone 1<br>
                                    <div class="input-prepend">
                                    	<input type="text" name="telefone1" class="input-medium" placeholder="Telefone 1" value="<?php echo $row_rs_editar_loja['telefone1']?>">
                                    </div>
                                </div>
                </div>
                      <div class="col-md-3">
                          E-mail<br>
                          <div class="input-prepend">
                           	  <input type="email" name="email" class="input-medium" placeholder="E-mail" value="<?php echo $row_rs_editar_loja['email']?>" />
                       		  <span class="add-on"><i class="icon-edit"></i></span>
                          </div>
                      </div>
                      
                           <div class="col-md-3">
                          Telefone 2<br>
                          <div class="input-prepend">
                           	  <input type="text" name="telefone2" class="input-medium" placeholder="Telefone 2" value="<?php echo $row_rs_editar_loja['telefone2']?>" />
                       		  <span class="add-on"><i class="icon-edit"></i></span>
                          </div>
                      </div>          
                            
              </div>
             
                        
                        <div class="row">
                            <div class="col-md-12"> 
                            	
                                <div class="col-md-4">
                                    CEP<br>
                                    <div class="input-prepend">
                                    	<input type="text" name="cep" class="input-large" placeholder="CEP" value="<?php echo $row_rs_editar_loja['cep']?>" />
                                		<span class="add-on"><i class="icon-edit"></i></span>
                                    </div>
                                </div>
                             
                            
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12"> 
                            	
                              
                                    Logradouro<br>
                                   
                                    <textarea name="logradouro" id="logradouro" rows="5" style="width: 96%;"><?php echo $row_rs_editar_loja['logradouro']?></textarea>
                                    	<?php /*?><input type="text" name="logradouro" class="input-xxlarge" placeholder="Logradouro" value="<?php echo $row_rs_editar_loja['logradouro']?>" />
                                		<span class="add-on"><i class="icon-edit"></i></span><?php */?>
                                 
                               
                              
                            
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                            	<div class="col-md-3">
                                    Estado<br>
                                    <div class="input-prepend">
                                   
                                    	<select name="estado" class="uniformselect" onChange="document.getElementById('janela_cidades').innerHTML='&nbsp;Carregando Cidades!'; AtualizaJanela('cidades.php?id_estado=' + this.value, 'cidades');">
                       					<?php do{?>
                            				<option value="<?php echo $row_rs_estado['id'];?>" <?php if($row_rs_estado['id'] == $row_rs_editar_loja['estado']) { echo 'selected'; } ?> /><?php echo $row_rs_estado['nome'];?>
                       					<?php }while($row_rs_estado = mysql_fetch_assoc($rs_estado));?>         
                       					</select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <span id="janela_cidades">
                                    <?php 
					  	$_GET['id_estado'] = $row_rs_editar_loja['estado'];
						$_GET['id_cidade'] = $row_rs_editar_loja['cidade'];
						include('cidades.php');?>
                                    </span>
                                </div>
                               
                            </div>
                        </div>
                          <div class="row">
                            <div class="col-md-12">
                            	<div class="col-md-8">
                                    Link Facebook<br>
                                    <div class="input-prepend">
                                        <input type="text" name="linkFacebook" class="input-xxlarge" placeholder="Link Facebook" value="<?php echo $row_rs_editar_loja['linkFacebook']?>"/>
                                		<span class="add-on"><i class="icon-edit"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                            	<div class="col-md-8">
                                    Link Instagram<br>
                                    <div class="input-prepend">
                                        <input type="text" name="linkInstagram" class="input-xxlarge" placeholder="Link Instagram" value="<?php echo $row_rs_editar_loja['linkInstagram']?>"/>
                                		<span class="add-on"><i class="icon-edit"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                            	<div class="col-md-8">
                                    Link Twitter<br>
                                    <div class="input-prepend">
                                        <input type="text" name="linkTwitter" class="input-xxlarge" placeholder="Link Twitter" value="<?php echo $row_rs_editar_loja['linkTwitter']?>"/>
                                		<span class="add-on"><i class="icon-edit"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                            	<div class="col-md-3">
                                    Valor di&aacute;rio em atraso (R$)<br>
                                    <div class="input-prepend">
                                        <input type="text" name="valor_diaria_atraso" class="input-large" placeholder="Valor diário em atraso (R$)" value="<?php echo $row_rs_editar_loja['valor_diaria_atraso']?>"/>
                                		<span class="add-on"><i class="icon-edit"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    Valor de multa para cancelamento (%)<br>
                                    <div class="input-prepend">
                                    	<input type="text" name="valor_multa_cancelamento" class="input-large" placeholder=" Valor de multa para cancelamento (%)" value="<?php echo $row_rs_editar_loja['valor_multa_cancelamento']?>" />
                                		<span class="add-on"><i class="icon-edit"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    Valor de multa para cancelamento (1&ordm; aluguel %)<br>
                                    <div class="input-prepend">
                                    	<input type="text" name="valor_multa_cancelamento2" class="input-large" placeholder="Valor de multa para cancelamento (1º aluguel %)" value="<?php echo $row_rs_editar_loja['valor_multa_cancelamento2']?>" />
                                		<span class="add-on"><i class="icon-edit"></i></span>
                                    </div>
                                </div>
                            
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                            	<div class="col-md-3">
                                    Hor&aacute;rio de funcionamento (semana)<br>
                                    <div class="input-prepend">
                                        <input type="text" name="horario_funcionamento_semana" class="input-large" placeholder="Horário de funcionamento (semana)" value="<?php echo $row_rs_editar_loja['horario_funcionamento_semana']?>"/>
                                		<span class="add-on"><i class="icon-edit"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    Hor&aacute;rio de funcionamento (final de semana)<br>
                                    <div class="input-prepend">
                                    	<input type="text" name="horario_funcionamento_final_semana" class="input-large" placeholder="Horário de funcionamento (final de semana)" value="<?php echo $row_rs_editar_loja['horario_funcionamento_final_semana']?>" />
                                		<span class="add-on"><i class="icon-edit"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    Hor&aacute;rio de funcionamento (prova)<br>
                                    <div class="input-prepend">
                                    	<input type="text" name="horario_funcionamento_troca" class="input-large" placeholder="Horário de funcionamento (prova)" value="<?php echo $row_rs_editar_loja['horario_funcionamento_troca']?>" />
                                		<span class="add-on"><i class="icon-edit"></i></span>
                                    </div>
                                </div>
                            
                            </div>
                            
                            
                            
                            
                        </div>
                      <?php /*?>  <textarea name="clausula" id="autoResizeTA" cols="80" rows="5" class="ckeditor" style="resize: vertical"><?php echo $row_rs_clausula_contrato['clausula'];?></textarea><?php */?>
                        
                      <div class="row" style="margin-right:8px; margin-top:8px;">
                      	<div class="col-md-12" align="right">
                        	 <a href="javascript:;" onClick="document.getElementById('formEditLoja').submit();" class="btn btn-mini btn-success"> <i class="iconfa-ok"></i>&nbsp; Salvar</a> 
                             <a href="loja.php" class="btn btn-danger btn-mini"> <i class="iconfa-remove"></i>&nbsp; Cancelar</a>
                        </div>
                      </div>
                      <input type="hidden" name="id" id="id" value="<?php echo $row_rs_editar_loja['id']?>">
                      <input type="hidden" name="MM_update" id="MM_update" value="formEditLoja">
                   
                </form>
           
            </div>
            
            </div><!--widgetcontent-->
            </div><!--widget-->
            
       
            <?php include_once('footer.php');?>