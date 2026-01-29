<?php 
include('restrito.php');
include('Connections/conexao.php');
include('funcoes.php');

if (!isset($_SESSION)) { session_start(); }

mysql_select_db($database_conexao, $conexao);
$query_rs_cat_produto = "SELECT * FROM tbl_categoria ORDER BY categoria ASC";
$rs_cat_produto = mysql_query($query_rs_cat_produto, $conexao) or die(mysql_error());
$row_rs_cat_produto = mysql_fetch_assoc($rs_cat_produto);
$totalRows_rs_cat_produto = mysql_num_rows($rs_cat_produto);


if((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formAddCLiente")) {	
	
	$updateSQL = sprintf("UPDATE tbl_ordem_servico SET id_cat_produto=%s, id_vendedor=%s, id_loja=%s, id_produto=%s, servico=%s, valor=%s, data_entrada=%s, data_saida=%s WHERE id=%s",
                       GetSQLValueString($_POST['id_cat_produto'], "text"),
                       GetSQLValueString($_POST['id_vendedor'], "text"),
                       GetSQLValueString($_POST['id_loja'], "text"),
                       GetSQLValueString($_POST['id_produto'], "text"),
                       GetSQLValueString($_POST['servico'], "text"),
                       GetSQLValueString(valorCalculavel($_POST['valor']), "text"),
                       GetSQLValueString($_POST['data_entrada'], "text"),
                       GetSQLValueString($_POST['data_saida'], "text"),
                       GetSQLValueString($_POST['id'], "int")); 
	mysql_select_db($database_conexao, $conexao);
	$Result1 = mysql_query($updateSQL, $conexao) or die(mysql_error());
	
	marcaHistoricoAlteracao("Modificou a ordem de serviço código: {$_POST['id']}.");
	
	echo "	<script>
			window.location='ordem-de-servico.php';
			</script>";
			exit;
}


mysql_select_db($database_conexao, $conexao);
$query_rs_ordem_servico = "SELECT tbl_ordem_servico.*,  tbl_produto.nome as nomeProduto FROM tbl_ordem_servico left join tbl_produto on tbl_ordem_servico.id_produto = tbl_produto.id where tbl_ordem_servico.id = '{$_GET['id']}'";
$rs_ordem_servico = mysql_query($query_rs_ordem_servico, $conexao) or die(mysql_error());
$row_rs_ordem_servico = mysql_fetch_assoc($rs_ordem_servico);
$totalRows_rs_ordem_servico = mysql_num_rows($rs_ordem_servico);


mysql_select_db($database_conexao, $conexao);
$query_rs_vendedores = "SELECT * FROM tbl_admin ORDER BY nome ASC";
$rs_vendedores = mysql_query($query_rs_vendedores, $conexao) or die(mysql_error());
$row_rs_vendedores = mysql_fetch_assoc($rs_vendedores);
$totalRows_rs_vendedores = mysql_num_rows($rs_vendedores);
?>
<!DOCTYPE html>
<html>
<head>

<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Ordem de Serviço > Visualizar</title>

<link rel="stylesheet" href="css/style.default.css" type="text/css" />
<link rel="stylesheet" href="css/bootstrap-fileupload.min.css" type="text/css" />
<link rel="stylesheet" href="css/bootstrap-timepicker.min.css" type="text/css" />
<style type="text/css">
body,td,th {
	font-family: RobotoRegular, "Helvetica Neue", Helvetica, sans-serif;
}
</style>

<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript" src="load.js"></script>
<?php include('dialog-jquery/inc-abre-janela.php');?>

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

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9" />
<script type="text/javascript">
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
</script>
</head>

<body>
<?php //include_once('head.php');?>

<div class="mainwrapper">
    
<?php include_once('header.php');?>
    
<?php include_once('inc_coluna.php');?>
    
    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="."><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li><a href="">Ordem de Serviço</a> <span class="separator"></span></li>
            <li>Visualizar</li>
        </ul>
        <div class="maincontent">
            <div class="maincontentinner">
            
            <div class="widget">
            <h4 class="widgettitle"><span class="iconfa-edit"></span>Visualizar Ordem de Serviço</h4>
            <div class="widgetcontent">
           
           
               <form class="stdform" action="" method="post" name="formAddCLiente" id="formAddCLiente" />
                    	
                        <div class="row">
                            <div class="col-md-12">
                            
                            	<div class="col-md-3">
                                    Categoria<br>
                                    <div class="input-prepend">
                                        <select name="id_produto" style="height:32px;" >
                       					<?php do{?>
                            				<option value="<?php echo $row_rs_cat_produto['id'];?>" <?php if($row_rs_cat_produto['id'] == $row_rs_ordem_servico['id_cat_produto']) { echo 'selected'; } ?> /><?php echo $row_rs_cat_produto['categoria'];?>
                       					<?php }while($row_rs_cat_produto = mysql_fetch_assoc($rs_cat_produto));?>         
                       					</select>
                                		<span class="add-on"><i class="icon-edit"></i></span>
                                    </div>
                                </div>
                                
                                
                                <div class="col-md-3">
                                    Produto / Traje<br>
                                   
                                    	<?php 
										$_GET['label'] = $row_rs_ordem_servico['nomeProduto'];
										$_GET['idAtual'] = $row_rs_ordem_servico['id_produto'];
										buscaGenericad('id_produto', 'id', '', 'Disponibilidade', 'nome', $javascript, 'tbl_produto', $concatCampos, $where);?>
                                        
                                </div>
                                
                                
                                <div class="col-md-2">
                                    Data de Entrada<br>
                                    <div class="input-prepend">
                                    	<input type="date" name="data_entrada" value="<?php echo $row_rs_ordem_servico['data_entrada'];?>" style="width:130px;" class="input-xlarge" />
                                		<span class="add-on"><i class="icon-edit"></i></span>
                                    </div>
                                </div>
                                
                                <div class="col-md-2">
                                    Data de Saída<br>
                                    <div class="input-prepend">
                                    	<input type="date" name="data_saida" value="<?php echo $row_rs_ordem_servico['data_saida'];?>" style="width:130px;" class="input-xlarge" />
                                		<span class="add-on"><i class="icon-edit"></i></span>
                                    </div>
                                </div>
                                
                                <div class="col-md-12">
                                <div class="col-md-2">
                                    Valor<br>
                                    <div class="input-prepend">
                                    	<input type="text" name="valor" value="<?php echo $row_rs_ordem_servico['valor'];?>"  style="width:100px;" class="input-xlarge" />
                                		<span class="add-on"><i class="icon-edit"></i></span>
                                    </div>
                                </div>
                                
                                <div class="col-md-2">
                                    Vendedor<br>
                                    <div class="input-prepend">
                                        <select name="id_vendedor" style="height:32px; width:184px;" >
                       					<?php do{?>
                            				<option value="<?php echo $row_rs_vendedores['id'];?>" <?php if($row_rs_vendedores['id'] == $row_rs_ordem_servico['id_vendedor']) { echo 'selected'; } ?> /><?php echo $row_rs_vendedores['nome'];?>
                       					<?php }while($row_rs_vendedores = mysql_fetch_assoc($rs_vendedores));?>         
                       					</select>
                                		<span class="add-on"><i class="icon-edit"></i></span>
                                    </div>
                                </div>
                                </div>
                                
                              <div class="col-md-12">
                                    Serviço<br>
                                    <div>
                                    	<textarea name="servico" id="servico" cols="30" rows="5" style="width:97%"><?php echo $row_rs_ordem_servico['servico'];?></textarea>
                                    </div>
                                </div>
                            
                            </div>
                        </div>
                        
                        
                       
                        
                      <div class="row" style="margin-right:12px;">
                      	<div class="col-md-12" align="right">
                        	 <a href="javascript:;" onClick="document.getElementById('formAddCLiente').submit();" class="btn btn-mini btn-success"> <i class="iconfa-ok"></i>&nbsp; Salvar</a>
                             
                             <a href="javascript:;" class="btn btn-primary btn-mini" onClick="MM_openBrWindow('imprimir-ordem-servico.php?id=<?php echo $row_rs_ordem_servico['id'];?>','imprimirOS','status=yes,width=850,height=450')"> <i class="icon-ok"></i> &nbsp; Imprimir  </a>
                             
                             <a href="javascript:;" onClick="history.back();" class="btn btn-danger btn-mini"> <i class="iconfa-remove"></i>&nbsp; Cancelar</a>
                        </div>
                      </div>
                   <input type="hidden" name="MM_insert" id="MM_insert" value="formAddCLiente">
                   <input type="hidden" name="id" value="<?php echo $row_rs_ordem_servico['id'];?>">
                </form>
           
            </div><!--widgetcontent-->
            </div><!--widget-->
            
       
            <?php include_once('footer.php');?>