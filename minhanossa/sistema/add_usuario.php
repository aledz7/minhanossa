<?php 
include('restrito.php');
include('Connections/conexao.php');
include('funcoes.php');

if($_POST[tipo] == 'AddUsuario') {
	$insertSQL = sprintf("INSERT INTO tbl_admin (login, senha, nome, email, status) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['login'], "text"),
                       GetSQLValueString($_POST['senha'], "text"),
                       GetSQLValueString($_POST['nome'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['status'], "text"));
	mysql_select_db($database_conexao, $conexao);
	$Result1 = mysql_query($insertSQL, $conexao) or die(mysql_error());
 	$idUser = mysql_insert_id();
	
	for($i=0; $i<count($_POST['id_acesso']); $i++) {
		$insertSQL = sprintf("INSERT INTO tbl_admin_acessos (id_usuario, id_acesso) VALUES (%s, %s)",
		   GetSQLValueString($idUser, "text"),
		   GetSQLValueString($_POST['id_acesso'][$i], "text"));
		mysql_select_db($database_conexao, $conexao);
		$Result1 = mysql_query($insertSQL, $conexao) or die(mysql_error());
	}
	
	marcaHistoricoAlteracao("Incluiu o usuário {$_POST['nome']}.");
	
	echo "	<script>
			window.location='usuario.php';
			</script>";
}


mysql_select_db($database_conexao, $conexao);
$query_rs_acessos = "SELECT tbl_acessos.*, (select count(1) from tbl_admin_acessos where tbl_admin_acessos.id_usuario = '{$_GET['id']}' and tbl_admin_acessos.id_acesso = tbl_acessos.id) as temAcesso FROM tbl_acessos";
$rs_acessos = mysql_query($query_rs_acessos, $conexao) or die(mysql_error());
$row_rs_acessos = mysql_fetch_assoc($rs_acessos);
$totalRows_rs_acessos = mysql_num_rows($rs_acessos);
?>
<!DOCTYPE html>
<html>
<head>

<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Adicionar Usu&aacute;rios</title>

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
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9" /></head>

<body>
<?php //include_once('head.php');?>

<div class="mainwrapper">
    
<?php include_once('header.php');?>
    
<?php include_once('inc_coluna.php');?>
    
    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="."><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li><a href="usuario.php">Usu&aacute;rios</a> <span class="separator"></span></li>
            <li>Adicionar Usu&aacute;rio</li>
        </ul>
        <div class="maincontent">
            <div class="maincontentinner">
            
            <div class="widget">
            <h4 class="widgettitle"><span class="iconfa-th"></span>Novo Usu&aacute;rio</h4>
            <div class="widgetcontent" style="min-height:520px;">
                                
               
                <form  method="post" name="formEditUsuario" id="formEditUsuario" action="" />
                    	
                        <p>
                           
                                
                                <div class="col-md-3">
                                    Login<br>
                                    <div class="input-prepend">
                                         <input type="text" name="login" class="input-large" placeholder="Login" value="<?php echo $row_rs_editar_usuario['login']?>" />
                                		<span class="add-on"><i class="icon-edit"></i></span>
                                    </div>
                                </div>
                                
                                 <div class="col-md-3">
                                    Senha<br>
                                    <div class="input-prepend">
                                        <input type="password" name="senha" class="input-large" placeholder="Senha" value="<?php echo $row_rs_editar_usuario['senha']?>" style="height:22px;" />
                                		<span class="add-on"><i class="icon-edit"></i></span>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    Nome<br>
                                    <div class="input-prepend">
                                         <input type="text" name="nome" class="input-large" placeholder="Nome" value="<?php echo $row_rs_editar_usuario['nome']?>" style="height:22px;"/>
                                		<span class="add-on"><i class="icon-edit"></i></span>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    E-mail<br>
                                    <div class="input-prepend">
                                         <input type="text" name="email" class="input-large" placeholder="Email" value="<?php echo $row_rs_editar_usuario['email']?>" style="height:22px;" />
                                		<span class="add-on"><i class="icon-edit"></i></span>
                                    </div>
                                </div>
                                
                               
                                
                               <div class="col-md-3">
                                    Status<br>
                                    <div class="input-prepend">
                                        <select name="status" class="input-large" style="width:192px; height:32px;">
                                    <option >Status</option>
                                    <option value="A" <?php if($row_rs_editar_usuario['status'] == 'A'){ echo "selected"; }?>>Ativo</option>
                                    <option value="I" <?php if($row_rs_editar_usuario['status'] == 'I'){ echo "selected"; }?>>Inativo</option>
                                </select>
                                		<span class="add-on"><i class="icon-edit"></i></span>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    Comissão<br>
                                    <div class="input-prepend">
                                         <input type="text" name="comissao" class="input-large" placeholder="Comissão" value="<?php echo $row_rs_editar_usuario['comissao']?>" style="height:22px;" />
                                		<span class="add-on"><i class="icon-edit"></i></span>
                                    </div>
                                </div>
                                
                                
                                <div class="col-md-3">
                                    Meta<br>
                                    <div class="input-prepend">
                                         <input type="text" name="meta" class="input-large" placeholder="Meta" style="height:22px;" />
                                		<span class="add-on"><i class="icon-edit"></i></span>
                                    </div>
                                </div>
                                
                                <div class="col-md-12" style="margin-top:40px;">
                                <fieldset><legend>Níveis de Acesso</legend>
                                	<hr>
                                 
                                 <?php do { ?>
                                 <div class="col-md-4">
                                   <input type="checkbox" name="id_acesso[]" value="<?=$row_rs_acessos['id'];?>" <?php if($row_rs_acessos['temAcesso'] > 0) { echo 'checked'; } ?> /> <?=$row_rs_acessos['nome'];?>
                                </div>
                                <? } while($row_rs_acessos = mysql_fetch_assoc($rs_acessos)); ?>
                               
                                </fieldset>
                                </div>
                                
                                 <div class="col-md-12" style="margin-top:10px;">
                                 <hr>
                                     <a href="javascript:;" onClick="document.getElementById('formEditUsuario').submit();" class="btn btn-mini btn-success"> <i class="iconfa-ok"></i> &nbsp; Salvar</a> 
                                <a href="usuario.php" class="btn btn-primary btn-mini"> <i class="iconfa-remove"></i>  &nbsp; Voltar</a>
                                </div>
                                
                       
                           
                        </p>
                     
                        
                 <input type="hidden" name="tipo" value="AddUsuario">
                        
                </form>
            </div><!--widgetcontent-->
            </div><!--widget-->
            
       
            <?php include_once('footer.php');?>