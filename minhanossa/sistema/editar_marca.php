<?php 
include('restrito.php');
include('Connections/conexao.php');
include('funcoes.php');

session_start();

$editFormAction = $_SERVER['PHP_SELF'];
if(isset($_SERVER['QUERY_STRING'])) {
	$editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

mysql_select_db($database_conexao, $conexao);
$query_rs_editar_marca = "SELECT * FROM tbl_marcas WHERE id = '".intval($_GET['id'])."'";
$rs_editar_marca = mysql_query($query_rs_editar_marca, $conexao) or die(mysql_error());
$row_rs_editar_marca = mysql_fetch_assoc($rs_editar_marca);
$totalRows_rs_editar_marca = mysql_num_rows($rs_editar_marca);

if((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formAddCLiente")) {	
	
	$updateSQL = sprintf("UPDATE tbl_marcas SET titulo=%s, instagram=%s, link=%s, foto=%s WHERE id=%s",
                       GetSQLValueString($_POST['titulo'], "text"),
                       GetSQLValueString($_POST['instagram'], "text"),					  
					   GetSQLValueString($_POST['link'], "text"),
                       GetSQLValueString(upload('foto', '../img_noticias', 'N'), "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_conexao, $conexao);
  $Result1 = mysql_query($updateSQL, $conexao) or die(mysql_error());

	marcaHistoricoAlteracao("Editou a marca: {$_POST['titulo']}.");
	
		
	echo "<script>
			window.location='marcas.php';
		  </script>";
			exit;		
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>

<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Editar Marca</title>

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

<meta charset="UTF-8" />
</head>

<body>
<?php //include_once('head.php');?>

<div class="mainwrapper">
    
<?php include_once('header.php');?>
    
<?php include_once('inc_coluna.php');?>
    
    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="."><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li><a href="marcas.php">Marcas</a> <span class="separator"></span></li>
            <li>Editar Marca</li>
        </ul>
        <div class="maincontent">
            <div class="maincontentinner">
            
            <div class="widget">
            <h4 class="widgettitle"><span class="iconfa-edit"></span>Atualizar Marca</h4>
            <div class="widgetcontent">
           
           
               <form class="stdform" action="" method="post" name="formAddCLiente" id="formAddCLiente" enctype="multipart/form-data" />
                  
                        <div class="row">
                            <div class="col-md-12">    

                                <div class="col-md-10 container_nome">
                                    Titulo<br>
                                    <div class="input-prepend ">
                                        <input name="titulo" type="text" class="input-xxlarge" placeholder="Titulo" value="<?php echo $row_rs_editar_marca['titulo'];?>" />
                                    </div>
                                </div>
							</div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">    

                                <div class="col-md-10 container_nome">
                                    Instagram<br>
                                    <div class="input-prepend ">
                                        <input name="instagram" type="text" class="input-xxlarge" placeholder="Instagram" value="<?php echo $row_rs_editar_marca['instagram'];?>" />
                                    </div>
                                </div>
							</div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">    

                                <div class="col-md-10 container_nome">
                                    Link<br>
                                    <div class="input-prepend ">
                                        <input name="link" type="text" class="input-xxlarge" placeholder="Link" value="<?php echo $row_rs_editar_marca['link'];?>" />
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
                      	<div class="col-md-12" align="right">
                        	 <a href="javascript:;" onClick="document.getElementById('formAddCLiente').submit();" class="btn btn-mini btn-success"> <i class="iconfa-ok"></i>&nbsp; Salvar</a>
                             <a href="controle-de-fotos.php?id=<?php echo $row_rs_editar_marca['id'];?>&tipo=Marcas" class="btn btn-mini btn-success"> <i class="iconfa-ok"></i>&nbsp; Mais Fotos</a>
                             <a href="cliente.php" class="btn btn-danger btn-mini"> <i class="iconfa-remove"></i>&nbsp; Cancelar</a>
                        </div>
                      </div>
                   <input type="hidden" name="MM_insert" id="MM_insert" value="formAddCLiente">
                   <input type="hidden" name="id" value="<?php echo $row_rs_editar_marca['id'];?>">
                   <input type="hidden" name="foto_Atual" value="<?php echo $row_rs_editar_marca['foto'];?>">
                </form>
           
            </div><!--widgetcontent-->
            </div><!--widget-->
            
       
            <?php include_once('footer.php');?>