<?php 
include('restrito.php');
include('Connections/conexao.php');
include('funcoes.php');

$currentPage = 'produto.php';

mysql_select_db($database_conexao, $conexao);
$query_rs_produto = "SELECT tbl_subcategorias.*, tbl_cats.categoria FROM tbl_subcategorias LEFT JOIN tbl_cats ON tbl_cats.id = tbl_subcategorias.id_categoria WHERE id_categoria = {$_GET['id_categoria']} ORDER BY nome ASC";
$rs_produto = mysql_query($query_rs_produto, $conexao) or die(mysql_error());
$row_rs_produto = mysql_fetch_assoc($rs_produto);
$totalRows_rs_produto = mysql_num_rows($rs_produto);
?>
<!DOCTYPE html>
<html>
<head>

<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Categoria de Produtos</title>

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
    <li><a href="cats.php">Categorias</a></li>
    
  </ul>
  <div class="pageheader">
  
    	<a href="add_subcat_produto.php?id_categoria=<?php echo $_GET['id_categoria']?>"class="btn btn-primary btn-mini searchbar"> <i class="icon-plus"></i> &nbsp; Novo</a>
    
    <!--<form action="results.html" method="post" class="searchbar" />
                <input type="text" name="keyword" placeholder="To search type and hit enter..." />
            </form>-->
    <div class="pageicon"><span class="iconfa-edit"></span></div>
    <div class="pagetitle" >
      <h5>Cadastro</h5>
      <h1>Categorias de Produtos</h1>
    </div>
    
    
    
  </div>
  <!--pageheader-->
  <div class="maincontent">
    <div class="maincontentinner">
      <div class="widget">
        <h4 class="widgettitle"><span class="iconfa-edit"></span>Subcategoria de Produtos</h4>
        <div class="widgetcontent">
        
          <table class="table table-bordered">
           
            <tbody>
            
              <tr>
                <td width="11%"><strong>C&oacute;digo</strong></td>
                <td width="33%"><strong>Nome</strong></td>
                <td width="33%"><strong>Categoria</strong></td>
                <td width="23%">&nbsp;</td>
              </tr>
            
            <?php
			if($totalRows_rs_produto > 0){
			 do{?>
              <tr>
                <td><?php echo $row_rs_produto['id'];?></td>
                <td><?php echo utf8_decode($row_rs_produto['nome']);?></td>
                <td><?php echo utf8_decode($row_rs_produto['categoria']);?></td>
                <td class="centeralign">
                  <a href="editar_subcat_produto.php?id_categoria=<?php echo $_GET['id_categoria']; ?>&id=<?php echo $row_rs_produto['id'];?>"class="btn btn-primary btn-mini" > 
                    <i class="icon-pencil"></i> &nbsp; Editar
                  </a>
                  <a href="sql_excluir.php?id_categoria=<?php echo $_GET['id_categoria']?>&id=<?php echo $row_rs_produto['id']; ?>&acao=excluirSubcatProduto" class="btn btn-danger btn-mini" style="margin-left:7px;"> 
                    <i class="iconfa-remove"></i> Excluir
                  </a>
				        </td>
              </tr>
            <?php }while($row_rs_produto = mysql_fetch_assoc($rs_produto));
			}
			?>
              
            </tbody>
          </table>
        </div>
        <!--widgetcontent-<?php
mysql_free_result($rs_produto);
?>->
            </div><!--widget-->
        <?php include_once('footer.php');?>