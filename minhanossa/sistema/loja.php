<?php 
include('restrito.php');
include('Connections/conexao.php');
include('funcoes.php');

$currentPage = 'usuario.php';

if($_GET['buscaLogin'] <> ''){
	$sql = "and id LIKE '%".$_GET['buscaCodigo']."%'";
}

if($_GET['buscaNome'] <> ''){
	$sql .= "and nome LIKE '%".$_GET['buscaNome']."%'";
}

if($_GET['buscaRazao'] <> ''){
	$sql .= "and email LIKE '%".$_GET['buscaRazao']."%'";
}

if($_GET['buscaCNPJ'] <> ''){
	$sql .= "and cnpj = '%".$_GET['buscaCNPJ']."%'";
}

if($_GET['buscaTelefone'] <> ''){
	$sql .= "and telefone1 = '%".$_GET['buscaTelefone']."%'";
}

mysql_select_db($database_conexao, $conexao);
$query_rs_loja = "SELECT * FROM tbl_loja WHERE id is not null $sql ORDER BY nome ASC";
$rs_loja = mysql_query($query_rs_loja, $conexao) or die(mysql_error());
$row_rs_loja = mysql_fetch_assoc($rs_loja);
$totalRows_rs_loja = mysql_num_rows($rs_loja);
?>
<!DOCTYPE html>
<html>
<head>

<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Loja</title>

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
<script type="text/javascript" src="js/responsive-tables.js"></script>
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
    <li><a href="loja.php">Cadastro</a></li>
    
  </ul>
  <div class="pageheader">
    <a href="add_loja.php"class="btn btn-primary btn-mini searchbar" style="float:right"> <i class="icon-plus"></i> &nbsp; Novo</a>
    <div class="pageicon"><span class="iconfa-edit"></span></div>
    <div class="pagetitle" >
      <h5>Cadastro</h5>
      <h1>Lojas</h1>
    </div>
   
    	
   
    
    
  </div>
  <!--pageheader-->
  <div class="maincontent">
    <div class="maincontentinner">
      <div class="widget">
        <h4 class="widgettitle"><span class=" iconfa-credit-card"></span>Loja</h4>
        <div class="widgetcontent">
        
          <div class="divider30"></div>
          <table class="table table-bordered">
           
            <tbody>
            
              <tr>
                <td width="13%"><strong>C&oacute;digo</strong></td>
                <td width="12%"><i class="iconsweets-user2"></i> <strong>Nome</strong></td>
                <td width="20%"><i class="iconsweets-user2"></i> <strong>Raz&atilde;o Social</strong></td>
                <td width="15%"><strong>CNPJ</strong></td>
                <td width="20%" style="text-align:center"><strong>Telefone</strong></td>
                <td width="20%" style="text-align:center;"><strong>Op&ccedil;&otilde;es</strong></td>
              </tr>
            
            <?php
			if($totalRows_rs_loja > 0){
			 do{?>
              <tr>
                <td><?php echo $row_rs_loja['id'];?></td>
                <td><?php echo $row_rs_loja['nome'];?></td>
                <td><?php echo $row_rs_loja['razao_social'];?></td>
                <td><?php echo $row_rs_loja['cnpj'];?></td>
                <td style="text-align:center"><?php echo $row_rs_loja['telefone1'];?></td>
                <td class="centeralign">
                    <a href="editar_loja.php?id=<?php echo $row_rs_loja['id'];?>"class="btn btn-primary btn-mini"> <i class="icon-pencil"></i> &nbsp; Editar
                    
                    </a>
                	<a href="sql_excluir.php?id=<?php echo $row_rs_loja['id']; ?>&acao=excluirLoja" class="btn btn-danger btn-mini" style="margin-left:7px;"> <i class="iconfa-remove"></i> Excluir
                    </a>
				</td>
              </tr>
            <?php }while($row_rs_loja = mysql_fetch_assoc($rs_loja));
			}
			?>
              
            </tbody>
          </table>
        </div>
        <!--widgetcontent-<?php
mysql_free_result($rs_loja);
?>->
            </div><!--widget-->
        <?php include_once('footer.php');?>