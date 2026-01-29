<?php 
include('restrito.php');
include('Connections/conexao.php');
include('funcoes.php');

session_start();



mysql_select_db($database_conexao, $conexao);
$query_rs_cats = "SELECT * FROM tbl_fundo";
$rs_cats = mysql_query($query_rs_cats, $conexao) or die(mysql_error());
$row_rs_cats = mysql_fetch_assoc($rs_cats);
$totalRows_rs_cats = mysql_num_rows($rs_cats);


$editFormAction = $_SERVER['PHP_SELF'];
if(isset($_SERVER['QUERY_STRING'])) {
	$editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formAddCLiente")) {	
	



	$insertSQL = sprintf("INSERT INTO tbl_home (id_cor, fundo, titulo, foto) VALUES (%s, %s, %s, %s)",
               GetSQLValueString($_POST['id_cor'], "text"),
               GetSQLValueString($_POST['fundo'], "text"),
		       GetSQLValueString($_POST['titulo'], "text"),
			   GetSQLValueString(upload('foto', '../img_noticias', 'N'), "text"));
	mysql_select_db($database_conexao, $conexao);
	$Result1 = mysql_query($insertSQL, $conexao) or die(mysql_error());
	$idConteudo = mysql_insert_id();

	fotoHistoricoAlteracao("Incluiu a foto: {$_POST['titulo']}.");
	
    echo "<script>
            window.location='fotos.php';
          </script>";
            exit;       

		
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>

<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Adicionar Fotos Home Page</title>

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
            <li><a href="fotos.php">Fotos</a> <span class="separator"></span></li>
            <li>Adicionar Foto homepage</li>
        </ul>
        <div class="maincontent">
            <div class="maincontentinner">
            
            <div class="widget">
            <h4 class="widgettitle"><span class="iconfa-edit"></span>Nova Foto</h4>
            <div class="widgetcontent">
           
           
               <form class="stdform" action="" method="post" name="formAddCLiente" id="formAddCLiente" enctype="multipart/form-data" />


                  
                        <div class="row">
                            <div class="col-md-12">    

                                    <div class="input-prepend">
                                       <select name="id_cor" id="fundo" class="input-middle">
                                            <option value="">CATEGORIA</option>
                                                <?php
                                                    if($totalRows_rs_cats > 0){
                                                do{?>
                                            <option value="<?php echo $row_rs_cats['id_cor']?>"><?php echo $row_rs_cats['fundo']?></option>
                                                 <?php }while($row_rs_cats = mysql_fetch_assoc($rs_cats)); }?>
                                       </select>
                                       
                                    </div>





                                <!--<div class="col-md-10 container_nome">
                                    Categoria<br>
                                    <div class="input-prepend ">
                                        <input name="subtit" type="text" class="input-xxlarge" placeholder="Bolsas, Macaquinhos, Brincos etc.." />
                                    </div>
                                </div>-->
                            </div>
                        </div>


                  
                        <div class="row">
                            <div class="col-md-12">    

                                <div class="col-md-10 container_nome">
                                    Titulo<br>
                                    <div class="input-prepend ">
                                        <input name="titulo" type="text" class="input-xxlarge" placeholder="Titulo" />
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
                             <a href="fotos.php" class="btn btn-danger btn-mini"> <i class="iconfa-remove"></i>&nbsp; Cancelar</a>
                        </div>
                      </div>
                   <input type="hidden" name="MM_insert" id="MM_insert" value="formAddCLiente">      
                   <input type="hidden" name="acao"   value="<?=$_GET['acao'];?>">
                </form>
           
            </div><!--widgetcontent-->
            </div><!--widget-->
            
       
            <?php include_once('footer.php');?>