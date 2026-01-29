<?php require_once('Connections/conexao.php'); ?>
<?php
include('restrito.php');
include('Connections/conexao.php');
include('funcoes.php');

mysql_select_db($database_conexao, $conexao);
$query_rs_editar_cliente = "SELECT * FROM tbl_plano WHERE id = '".$_GET['id']."'";
$rs_editar_cliente = mysql_query($query_rs_editar_cliente, $conexao) or die(mysql_error());
$row_rs_editar_cliente = mysql_fetch_assoc($rs_editar_cliente);
$totalRows_rs_editar_cliente = mysql_num_rows($rs_editar_cliente);

if((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "formEditCLiente")) {

	$updateSQL = sprintf("UPDATE tbl_plano SET nome=%s, valor=%s, pontuacao_mensal=%s, foto=%s, quantidade=%s, pontuacao_trimestral=%s, pontuacao_semestral=%s, pontuacao_anual=%s, descricao=%s, token_plano_mensal=%s, token_plano_trimestral=%s, token_plano_semestral=%s, token_plano_anual=%s, mostra_site=%s WHERE id=%s",
                       GetSQLValueString($_POST['nome'], "text"),
                       GetSQLValueString(valorCalculavel($_POST['valor']), "text"), 
                       GetSQLValueString($_POST['pontuacao_mensal'], "text"), 
                       GetSQLValueString(upload('foto', '../img_noticias', 'N'), "text"),
                       GetSQLValueString($_POST['quantidade'], "text"), 
                       GetSQLValueString($_POST['pontuacao_trimestral'], "text"), 
                       GetSQLValueString($_POST['pontuacao_semestral'], "text"), 
                       GetSQLValueString($_POST['pontuacao_anual'], "text"), 
                       GetSQLValueString($_POST['descricao'], "text"), 
                       GetSQLValueString($_POST['token_plano_mensal'], "text"), 
                       GetSQLValueString($_POST['token_plano_trimestral'], "text"), 
                       GetSQLValueString($_POST['token_plano_semestral'], "text"), 
                       GetSQLValueString($_POST['token_plano_anual'], "text"), 
                       GetSQLValueString($_POST['mostra_site'], "text"), 
                       GetSQLValueString($_POST['id'], "text")); 
		mysql_select_db($database_conexao, $conexao);
		$Result1 = mysql_query($updateSQL, $conexao) or die(mysql_error());
	
	marcaHistoricoAlteracao("Modificou o plano {$_POST['nome']}.");
	
		$idConteudo = $_POST['id'][$i];

			echo "
				<script>
					window.location='planos.php';
				</script>
			";			
		
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>

<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Editar CLiente</title>

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

<meta charset="UTF-8" /></head>

<body>
<?php //include_once('head.php');?>

<div class="mainwrapper">
    
<?php include_once('header.php');?>
    
<?php include_once('inc_coluna.php');?>
    
    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="."><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li><a href="planos.php">Plano</a> <span class="separator"></span></li>
            <li>Atualizar Plano</li>
        </ul>
        <div class="maincontent">
            <div class="maincontentinner">
            
            <div class="widget">
            <h4 class="widgettitle"><span class="iconfa-edit"></span>Atualiza Plano</h4>
           <div class="widgetcontent">
           
           
               <form class="stdform" action="" method="post" name="formEditCLiente" id="formEditCLiente" enctype="multipart/form-data"/>
                    	
                        <div class="row">
                            <div class="col-md-12">
                            	<div class="col-md-2">
                                    C&oacute;digo<br>
                                    <div class="input-prepend">
                                        <input type="text" name="id" class="input-small" placeholder="Código" disabled value="<?php echo $row_rs_editar_cliente['id'];?>"/>
                                		<span class="add-on"><i class="icon-qrcode"></i></span>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    Mostrar no site<br>
                                    <div class="input-prepend">
                                       <select name="mostra_site" id="mostra_site" class="input-middle">
                                       		<option value="">SELECIONE</option>
                                       		<option value="S" <?php if($row_rs_editar_cliente['mostra_site'] == 'S'): echo "selected"; endif;?>>Sim</option>
                                       		<option value="N" <?php if($row_rs_editar_cliente['mostra_site'] == 'N'): echo "selected"; endif;?>>N&atilde;o</option>
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
                                    Valor<br>
                                    <div class="input-prepend">
                                    	<input name="valor" type="text" required="required" class="input-medium"  value="<?php echo number_format($row_rs_editar_cliente['valor'],2,',','.');?>" />
                                		<span class="add-on"><i class="iconfa-calendar"></i></span>
                                    </div>
                                </div>
                              
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">    

                                
                                <div class="col-md-2 container_nome">
                                    Pontuação Mensal<br>
                                    <div class="input-prepend ">
                                        <input name="pontuacao_mensal" type="text" required="required" class="input-medium" placeholder="Pontuação Mensal" value="<?php echo $row_rs_editar_cliente['pontuacao_mensal'];?>"  />
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    Pontuação Trimestral<br>
                                    <div class="input-prepend">
                                    	<input name="pontuacao_trimestral" placeholder="Pontuação Trimestral" type="text" required="required" class="input-medium" value="<?php echo $row_rs_editar_cliente['pontuacao_trimestral'];?>"   />
                                	</div>
                                </div>
                                
                                <div class="col-md-2">
                                    Pontuação Semestral<br>
                                    <div class="input-prepend">
                                    	<input name="pontuacao_semestral" placeholder="Pontuação Semestral" type="text" required="required" class="input-medium" value="<?php echo $row_rs_editar_cliente['pontuacao_semestral'];?>"   />
                                	</div>
                                </div>
                                 <div class="col-md-2">
                                    Pontuação Anual<br>
                                    <div class="input-prepend">
                                    	<input name="pontuacao_anual" placeholder="Pontuação Anual" type="text" required="required" class="input-medium" value="<?php echo $row_rs_editar_cliente['pontuacao_anual'];?>"   />
                                	</div>
                                </div>
                              
                            </div>
                        </div>
                        
                         <div class="row">
                            <div class="col-md-12">    

                                
                                <div class="col-md-10 container_nome">
                                    Token Plano Mensal<br>
                                    <div class="input-prepend ">
                                        <input name="token_plano_mensal" type="text" required="required" class="input-xxlarge" placeholder="Token Plano Mensal" value="<?php echo $row_rs_editar_cliente['token_plano_mensal'];?>"  />
                                    </div>
                                </div>

                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">    

                                
                                <div class="col-md-10 container_nome">
                                    Token Plano Trimestral<br>
                                    <div class="input-prepend ">
                                        <input name="token_plano_trimestral" type="text" required="required" class="input-xxlarge" placeholder="Token Plano Trimestral" value="<?php echo $row_rs_editar_cliente['token_plano_trimestral'];?>"  />
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">    

                                
                                <div class="col-md-10 container_nome">
                                    Token Plano Semestral<br>
                                    <div class="input-prepend ">
                                        <input name="token_plano_semestral" type="text" required="required" class="input-xxlarge" placeholder="Token Plano Semestral" value="<?php echo $row_rs_editar_cliente['token_plano_semestral'];?>"  />
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">    

                                
                                <div class="col-md-10 container_nome">
                                    Token Plano Anual<br>
                                    <div class="input-prepend ">
                                        <input name="token_plano_anual" type="text" required="required" class="input-xxlarge" placeholder="Token Plano Anual" value="<?php echo $row_rs_editar_cliente['token_plano_anual'];?>"  />
                                    </div>
                                </div>

                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-10 container_nome">
                                    Foto Principal<br>
                                    <div class="input-prepend ">
                                        <input name="foto" type="file" class="input-xxlarge" />
                                    </div>
                                </div>
                            </div>
                        </div>                        

                        
                      
                        <div class="row">
                        	<div class="col-md-12">
                        	Descrição <br>
                        		<textarea name="descricao" id="descricao" class="ckeditor" style="width: 96%;" rows="5"><?php echo $row_rs_editar_cliente['descricao'];?></textarea>
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
            
       
            <?php include_once('footer.php');?>