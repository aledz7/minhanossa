<?php require_once('Connections/conexao.php'); ?>
<?php
include('restrito.php');
include('funcoes.php');


mysql_select_db($database_conexao, $conexao);
$query_rs_categoria = "SELECT * FROM tbl_subcategorias ORDER BY nome ASC";
$rs_categoria = mysql_query($query_rs_categoria, $conexao) or die(mysql_error());
$row_rs_categoria = mysql_fetch_assoc($rs_categoria);
$totalRows_rs_categoria = mysql_num_rows($rs_categoria);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formSubcatProduto")) {
  $insertSQL = sprintf("INSERT INTO tbl_subcategorias (id_categoria, nome) VALUES (%s, %s)", GetSQLValueString($_POST['id_categoria'], "text"), GetSQLValueString($_POST['nome'], "text"));

  mysql_select_db($database_conexao, $conexao);
  $Result1 = mysql_query($insertSQL, $conexao) or die(mysql_error());
  
  echo "
  	<script>
		window.location='sub_cat_produto.php?id_categoria={$_POST['id_categoria']}';
	</script>
  ";
}
?>
<!DOCTYPE html>
<html>
<head>

<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Cadastro de Subcategorias</title>

<link rel="stylesheet" href="css/style.default.css" type="text/css" />
<link rel="stylesheet" href="css/bootstrap-fileupload.min.css" type="text/css" />
<link rel="stylesheet" href="css/bootstrap-timepicker.min.css" type="text/css" />

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
<script type="text/javascript" src="js/responsive-tables.js"></script>
<script type="text/javascript" src="js/custom.js"></script>
<script type="text/javascript" src="js/forms.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<style type="text/css">
body,td,th {
	font-family: RobotoRegular, "Helvetica Neue", Helvetica, sans-serif;
}
</style>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9" /></head>

<body>
<?php //include_once('head.php');?>

<div class="mainwrapper">
    
<?php include_once('header.php');?>
    
<?php include_once('inc_coluna.php');?>
    
    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="."><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li><a href="sub_cat_produto.php?id_categoria=<?php echo $_GET['id_categoria']?>">Subcategoria</a> <span class="separator"></span></li>
            <li>Adicionar Subcategoria</li>
        </ul>
        <div class="maincontent">
            <div class="maincontentinner">
            
            <div class="widget">
            <h4 class="widgettitle"><span class="iconfa-th"></span>Nova Subcategoria</h4>
            <div class="widgetcontent">
                <form class="stdform" action="<?php echo $editFormAction; ?>" method="POST" name="formSubcatProduto" id="formSubcatProduto">
                    <p>
                        <div class="row">
                            <div class="col-md-2">
                                C&oacute;digo<br>
                                <div class="input-prepend">
                                    <input type="text" name="id" class="input-small" placeholder="Código" disabled />
                                    <span class="add-on"><i class="iconfa-qrcode"></i></span>
                                </div>
                            </div>
                            <div class="col-md-5">
                                Nome<br>
                                <div class="input-prepend">
                                    <input type="text" name="nome" class="input-xxlarge" placeholder="Escreva o nome da subcategoria"/>
                                    <span class="add-on"><i class="iconfa-edit"></i></span>
                                </div>    
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-11" align="right">
                                <a href="sub_cat_produto.php?id_categoria=<?php echo $_GET['id_categoria']?>" class="btn btn-danger btn-mini"> 
                                    <i class="iconfa-remove"></i> &nbsp; Cancelar
                                </a>
                                <a href="javascript:;" onClick="document.getElementById('formSubcatProduto').submit();" class="btn btn-mini btn-success">
                                    <i class="iconfa-ok"></i> &nbsp; Salvar
                                </a> 
                            </div>                                          
                        </div>
                        <input type="hidden" name="id_categoria" value="<?php echo $_GET['id_categoria']?>"/>
                        <input type="hidden" name="MM_insert" value="formSubcatProduto">
                    </p>
                </form>
           
            </div><!--widgetcontent-->
            </div><!--widget-->
            
       
            <?php include_once('footer.php');?>
<?php
mysql_free_result($rs_categoria);
?>
