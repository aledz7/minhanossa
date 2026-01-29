<?php 
include('restrito.php');
include('Connections/conexao.php');
include('funcoes.php');

$currentPage = 'cores.php';


if($_GET['buscaCodigo'] <> ''){
	$sql = "and id LIKE '%".$_GET['buscaCodigo']."%'";
}
if($_GET['nome'] <> ''){
	$sql .= "and categoria LIKE '%".$_GET['nome']."%'";
}

mysql_select_db($database_conexao, $conexao);
$query_rs_produto = "SELECT * FROM tbl_emprestimos WHERE id is not null $sql ORDER BY id ASC";
$rs_produto = mysql_query($query_rs_produto, $conexao) or die(mysql_error());
$row_rs_produto = mysql_fetch_assoc($rs_produto);
$totalRows_rs_produto = mysql_num_rows($rs_produto);
?>
<!DOCTYPE html>
<html lang="pt-BR">
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
    <li><a href="produtos.php">Produto</a></li>
    
  </ul>
  <div class="pageheader">
  
    	<a href="add_prazos.php"class="btn btn-primary btn-mini searchbar"> <i class="icon-plus"></i> &nbsp; Novo</a>
    
    <!--<form action="results.html" method="post" class="searchbar" />
                <input type="text" name="keyword" placeholder="To search type and hit enter..." />
            </form>-->
    <div class="pageicon"><span class="iconfa-edit"></span></div>
    <div class="pagetitle" >
      <h5>Cadastro</h5>
      <h1>Prazos</h1>
    </div>
    
    
    
  </div>
  <!--pageheader-->
  <div class="maincontent">
    <div class="maincontentinner">
      <div class="widget">
        <h4 class="widgettitle"><span class="iconfa-edit"></span>Prazos de Entrega</h4>
        <div class="widgetcontent">
        
          <table class="table table-bordered">
           
            <tbody>
            
              <tr>
                <td width="11%"><strong>C&oacute;digo</strong></td>
                <td width="66%"><strong>Nome</strong></td>
                <td width="23%">&nbsp;</td>
              </tr>
            
            <?php
			if($totalRows_rs_produto > 0){

			 do{?>
              <tr>
                <td><?php echo $row_rs_produto['id'];?></td>
                <td><?php echo $row_rs_produto['nome'];?></td>
                <td class="centeralign">
                    <a href="editar_prazos.php?id=<?php echo $row_rs_produto['id'];?>"class="btn btn-primary btn-mini" style="font-size:9px;"> <i class="icon-pencil"></i> &nbsp; Editar
                    
                    </a>
                	<a href="sql_excluir.php?id=<?php echo $row_rs_produto['id']; ?>&acao=excluirPrazos" class="btn btn-danger btn-mini" style="font-size:10px; margin-left:7px;"> <i class="iconfa-remove"></i> Excluir
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