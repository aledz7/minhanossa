<?php 
include('restrito.php');
include('Connections/conexao.php');
include('funcoes.php');

$currentPage = 'usuario.php';


if($_GET['buscaLogin'] <> ''){
	$sql = "and login LIKE '%".$_GET['buscaLogin']."%'";
}
if($_GET['buscaNome'] <> ''){
	$sql .= "and nome LIKE '%".$_GET['buscaNome']."%'";
}
if($_GET['buscaEmail'] <> ''){
	$sql .= "and email LIKE '%".$_GET['buscaEmail']."%'";
}
if($_GET['buscaStatus'] <> ''){
	$sql .= "and status = '%".$_GET['buscaStatus']."%'";
}

mysql_select_db($database_conexao, $conexao);
$query_rs_usuario = "SELECT * FROM tbl_admin WHERE id is not null $sql ORDER BY nome ASC";
$rs_usuario = mysql_query($query_rs_usuario, $conexao) or die(mysql_error());
$row_rs_usuario = mysql_fetch_assoc($rs_usuario);
$totalRows_rs_usuario = mysql_num_rows($rs_usuario);
?>
<!DOCTYPE html>
<html>
<head>

<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Administração > Usu&aacute;rios</title>

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
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9" /></head>

<body>
<?php //include_once('head.php');?>

<div class="mainwrapper">
<?php include_once('header.php');?>
<?php include_once('inc_coluna.php');?>
<div class="rightpanel">
  <ul class="breadcrumbs">
    <li><a href="."><i class="iconfa-home"></i></a> <span class="separator"></span></li>
    <li><a href="usuario.php">Usuários</a></li>
    
  </ul>
  <div class="pageheader">
  <a href="add_usuario.php" class="btn btn-primary btn-mini searchbar"> <i class="icon-plus"></i> &nbsp; Novo</a>
    <div class="pageicon"><span class="iconfa-edit"></span></div>
    <div class="pagetitle">
      <h5>administra&Ccedil;&Atilde;O</h5>
      <h1>Usuário / Funcion&aacute;rios</h1>
    </div>
  </div>
  <!--pageheader-->
  <div class="maincontent">
    <div class="maincontentinner">
      <div class="widget">
        <h4 class="widgettitle"><span class="iconfa-edit"></span>Usuários / Funcion&aacute;rios</h4>
        <div class="widgetcontent">
        
          
          <p align="right"> 
        
          <a href="add_usuario.php" class="btn btn-primary btn-mini"> <i class="icon-plus"></i> &nbsp; Novo</a> </p>
          
         
          <table class="table table-bordered">
            <thead>
              <tr>
                <th width="13%">id</th>
                <th width="15%">Login</th>
                <th width="23%">Nome</th>
                <th width="19%">Email</th>
                <th width="11%" style="text-align:center">Status</th>
                <th width="19%" style="text-align:center">OP&Ccedil;&Otilde;ES</th>
              </tr>
            </thead>
            <tbody>
            
            <?php
			if($totalRows_rs_usuario > 0){
			 do{?>
              <tr>
                <td><?php echo $row_rs_usuario['id'];?></td>
                <td><?php echo $row_rs_usuario['login'];?></td>
                <td><?php echo $row_rs_usuario['nome'];?></td>
                <td><?php echo $row_rs_usuario['email'];?></td>
                <td style="text-align:center"><?php echo ativo($row_rs_usuario['status']);?></td>
                <td class="centeralign">
                    
                    <a href="editar_usuario.php?id=<?php echo $row_rs_usuario['id'];?>" class="btn btn-primary btn-mini"> <i class="icon-pencil"></i> &nbsp; Editar
                    
                    </a>
                    
                    <a href="sql_excluir.php?id=<?php echo $row_rs_usuario['id']; ?>&acao=excluirUsuario" class="btn btn-danger btn-mini" style="margin-left:7px;"> <i class="iconfa-remove"></i> Excluir
                    </a>
                    
                   
				</td>
              </tr>
            <?php }while($row_rs_usuario = mysql_fetch_assoc($rs_usuario));
			}
			?>
              
            </tbody>
          </table>
        </div>
        <!--widgetcontent-<?php
mysql_free_result($rs_usuario);
?>->
            </div><!--widget-->
        <?php include_once('footer.php');?>