<?php require_once('Connections/conexao.php'); ?>
<?php
include('restrito.php');
include('Connections/conexao.php');
include('funcoes.php');

mysql_select_db($database_conexao, $conexao);
$query_rs_editar_cliente = "SELECT * FROM tbl_termo_de_uso WHERE id = '".$_GET['id']."'";
$rs_editar_cliente = mysql_query($query_rs_editar_cliente, $conexao) or die(mysql_error());
$row_rs_editar_cliente = mysql_fetch_assoc($rs_editar_cliente);
$totalRows_rs_editar_cliente = mysql_num_rows($rs_editar_cliente);

if((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "formEditCLiente")) {

	$updateSQL = sprintf("UPDATE tbl_termo_de_uso SET titulo=%s, descricao=%s, ordem=%s WHERE id=%s",
                       GetSQLValueString($_POST['titulo'], "text"),
                       GetSQLValueString($_POST['descricao'], "text"), 
                       GetSQLValueString($_POST['ordem'], "text"), 
                       GetSQLValueString($_POST['id'], "text")); 
		mysql_select_db($database_conexao, $conexao);
		$Result1 = mysql_query($updateSQL, $conexao) or die(mysql_error());
	
	

			echo "
				<script>
					window.location='termo-de-uso.php';
				</script>
			";			
		
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>

<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Editar Termo de Uso</title>

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
            <li><a href="termo-de-uso.php">Editar Termo de Uso</a> <span class="separator"></span></li>
            <li>Atualizar Termo de Uso</li>
        </ul>
        <div class="maincontent">
            <div class="maincontentinner">
            
            <div class="widget">
            <h4 class="widgettitle"><span class="iconfa-edit"></span>Atualizar Termo de Uso</h4>
           <div class="widgetcontent">
           
           
               <form class="stdform" action="" method="post" name="formEditCLiente" id="formEditCLiente" />
                     <div class="row">
                            <div class="col-md-12">    

                                
                                <div class="col-md-12 container_nome">
                                    Ordem<br>
                                    <div class="input-prepend ">
                                        <input name="ordem" type="number" class="input-small" placeholder="Ordem" value="<?php echo $row_rs_editar_cliente['ordem'];?>" />
                                    </div>
                                </div>
      
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">    

                                
                                <div class="col-md-12 container_nome">
                                    Titulo<br>
                                    <div class="input-prepend ">
                                        <input name="titulo" type="text" class="input-xxlarge" placeholder="Titulo" value="<?php echo $row_rs_editar_cliente['titulo'];?>" />
                                    </div>
                                </div>
      
                            </div>
                        </div>
                    
                        <div class="row">
                        	<div class="col-md-12">
                        	Descrição <br>
                        		<textarea name="descricao" id="descricao" class="ckeditor" style="width: 96%;" rows="5"><?php echo utf8_encode($row_rs_editar_cliente['descricao']);?></textarea>
                        	</div>
                        </div>
                        
                      <div class="row">
                      	<div class="col-md-12" align="right">
                        	 <a href="javascript:;" onClick="document.getElementById('formEditCLiente').submit();" class="btn btn-mini btn-success"> <i class="iconfa-ok"></i>&nbsp; Salvar</a>
                             <a href="termo-de-uso.php" class="btn btn-danger btn-mini"> <i class="iconfa-remove"></i>&nbsp; Cancelar</a>
                        </div>
                      </div>
                   <input type="hidden" name="id" id="id" value="<?php echo $row_rs_editar_cliente['id']?>">
                   <input type="hidden" name="MM_update" id="MM_update" value="formEditCLiente">
                </form>
           
            </div><!--widgetcontent-->
            </div><!--widget-->
            
       
            <?php include_once('footer.php');?>