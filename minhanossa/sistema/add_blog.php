<?php 
include('restrito.php');
include('Connections/conexao.php');
include('funcoes.php');

session_start();

$editFormAction = $_SERVER['PHP_SELF'];
if(isset($_SERVER['QUERY_STRING'])) {
	$editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formAddCLiente")) {	
	
	$insertSQL = sprintf("INSERT INTO tbl_blog (titulo, breve, descricao, foto, resumo) VALUES (%s, %s, %s, %s, %s)",
		       GetSQLValueString($_POST['titulo'], "text"),
			   GetSQLValueString($_POST['breve'], "text"),
			   GetSQLValueString($_POST['descricao'], "text"),
			   GetSQLValueString(upload('foto', '../../img_noticias', 'N'), "text"),
			   GetSQLValueString($_POST['resumo'], "text"));
	mysql_select_db($database_conexao, $conexao);
	$Result1 = mysql_query($insertSQL, $conexao) or die(mysql_error());
	$idConteudo = mysql_insert_id();

	//blogHistoricoAlteracao("Incluiu o post: {$_POST['titulo']}.");
	
		
	echo "	<script>
			window.location='blog.php';
			</script>";
			exit;		
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>

<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Adicionar Blog</title>

<link rel="stylesheet" href="css/style.default.css" type="text/css" />
<link rel="stylesheet" href="css/bootstrap-fileupload.min.css" type="text/css" />
<link rel="stylesheet" href="css/bootstrap-timepicker.min.css" type="text/css" />
<link rel="stylesheet" href="summernote/dist/summernote.css">
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
            <li><a href="marcas.php">Blogs</a> <span class="separator"></span></li>
            <li>Adicionar Blog</li>
        </ul>
        <div class="maincontent">
            <div class="maincontentinner">
            
            <div class="widget">
            <h4 class="widgettitle"><span class="iconfa-edit"></span>Nova Blog</h4>
            <div class="widgetcontent">
           
           
               <form class="stdform" action="" method="post" name="formAddCLiente" id="formAddCLiente" enctype="multipart/form-data" />
                  
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
                                    Titulo com cor<br>
                                    <div class="input-prepend ">
                                        <input name="breve" type="text" class="input-xxlarge" placeholder="Segunda parte..." />
                                    </div>
                                </div>
							</div>
                        </div>
				
						<div class="row">
                            <div class="col-md-12">    

                                <div class="col-md-10 container_nome">
                                    Resumo<br>
                                    <div class="input-prepend ">
                                        <input name="resumo" type="text" class="input-xxlarge" placeholder="Resumo" />
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
						<div class="col-lg-12">
					  		<div class="col-md-10 container_nome">
                                   Descrição<br>
						  		<textarea class="ckeditor" id="ckeditor" name="descricao" rows="1"></textarea>
							</div>
						</div>
                     </div>
                      <div class="row">
                      	<div class="col-md-12" align="right">
                        	 <a href="javascript:;" onClick="document.getElementById('formAddCLiente').submit();" class="btn btn-mini btn-success"> <i class="iconfa-ok"></i>&nbsp; Salvar</a>
                             <a href="blog.php" class="btn btn-danger btn-mini"> <i class="iconfa-remove"></i>&nbsp; Cancelar</a>
                        </div>
                      </div>
                   <input type="hidden" name="MM_insert" id="MM_insert" value="formAddCLiente">
                   <input type="hidden" name="acao" value="<?=$_GET['acao'];?>">
                </form>
           
            </div><!--widgetcontent-->
            </div><!--widget-->
            
       
            <?php include_once('footer.php');?>
            
 