<?php 
include('restrito.php');
include('Connections/conexao.php');
include('funcoes.php');

if (!isset($_SESSION)) { session_start(); }

$editFormAction = $_SERVER['PHP_SELF'];
if(isset($_SERVER['QUERY_STRING'])) {
	$editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formAddCLiente")) {	
	
	$insertSQL = sprintf("INSERT INTO tbl_cartao_presente (nome, ativo) VALUES (%s, %s)",
		       GetSQLValueString($_POST['nome'], "text"),
		       GetSQLValueString($_POST['ativo'], "text"));
	mysql_select_db($database_conexao, $conexao);
	$Result1 = mysql_query($insertSQL, $conexao) or die(mysql_error());
	$idConteudo = mysql_insert_id();

	marcaHistoricoAlteracao("Incluiu o Cartão Presente: {$_POST['nome']}.");
	
		
	echo "	<script>
			window.location='cartao_presente.php';
			</script>";
			exit;		
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>

<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Adicionar Cartão Presentre</title>

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
            <li><a href="cartao_presente.php">Cartão Presente</a> <span class="separator"></span></li>
            <li>Adicionar Cartão Presente</li>
        </ul>
        <div class="maincontent">
            <div class="maincontentinner">
            
            <div class="widget">
            <h4 class="widgettitle"><span class="iconfa-edit"></span>Nova Cartão Presente</h4>
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
                                
                                 <div class="col-md-3 container_nome">
                                    Ativo<br>
                                    <div class="input-prepend ">
                                        <input name="ativo" type="checkbox" class="input-xlarge" value="S" />
                                    </div>
                                </div>
                            
                            </div>
                        </div>
                  
                        <div class="row">
                            <div class="col-md-12">    

                                
                                <div class="col-md-4 container_nome">
                                    Nome<br>
                                    <div class="input-prepend ">
                                        <input name="nome" type="text" required="required" class="input-xlarge" placeholder="Nome" />
                                    </div>
                                </div>
                                
                               

                            </div>
                        </div>
                        
                      
                        
                      <div class="row">
                      	<div class="col-md-12" align="right">
                        	 <a href="javascript:;" onClick="document.getElementById('formAddCLiente').submit();" class="btn btn-mini btn-success"> <i class="iconfa-ok"></i>&nbsp; Salvar</a>
                             <a href="cartao_presente.php" class="btn btn-danger btn-mini"> <i class="iconfa-remove"></i>&nbsp; Cancelar</a>
                        </div>
                      </div>
                   <input type="hidden" name="MM_insert" id="MM_insert" value="formAddCLiente">
                   <input type="hidden" name="acao" value="<?php echo $_GET['acao'];?>">
                </form>
           
            </div><!--widgetcontent-->
            </div><!--widget-->
            
       
            <?php include_once('footer.php');?>