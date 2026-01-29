<?php 
include('restrito.php');
include('Connections/conexao.php');
include('funcoes.php');

$currentPage = 'cliente.php';


if($_GET['busca'] <> ''){
	$sql = "and (nome LIKE '%".$_GET['busca']."%' or cpf LIKE '%".$_GET['busca']."%' or telefone1 LIKE '%".$_GET['busca']."%' or email LIKE '%".$_GET['busca']."%' or endereco LIKE '%".$_GET['busca']."%')";
}
if(filter_input(INPUT_GET, 'id_estado') <> ''){
        $sql .= " and estado = '".filter_input(INPUT_GET, 'id_estado')."'";
}
if(filter_input(INPUT_GET, 'id_cidade') <> ''){
        $sql .= " and cidade = '".filter_input(INPUT_GET, 'id_cidade')."'";
}
if(filter_input(INPUT_GET, 'id_plano') <> ''){
        $sql .= " and id_plano = '".filter_input(INPUT_GET, 'id_plano')."'";
}

mysql_select_db($database_conexao, $conexao);
$query_rs_cliente = "SELECT * FROM tbl_cliente WHERE id is not null $sql ORDER BY nome ASC";
$rs_cliente = mysql_query($query_rs_cliente, $conexao) or die(mysql_error());
$row_rs_cliente = mysql_fetch_assoc($rs_cliente);
$totalRows_rs_cliente = mysql_num_rows($rs_cliente);

mysql_select_db($database_conexao, $conexao);
$query_rs_estado = "SELECT * FROM dados_estados ORDER BY nome ASC";
$rs_estado = mysql_query($query_rs_estado, $conexao) or die(mysql_error());
$row_rs_estado = mysql_fetch_assoc($rs_estado);
$totalRows_rs_estado = mysql_num_rows($rs_estado);

mysql_select_db($database_conexao, $conexao);
$query_rs_plano = "SELECT * FROM tbl_plano ORDER BY nome ASC";
$rs_plano = mysql_query($query_rs_plano, $conexao) or die(mysql_error());
$row_rs_plano = mysql_fetch_assoc($rs_plano);
$totalRows_rs_plano = mysql_num_rows($rs_plano);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>

<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Relat&oacute;rio de Clientes</title>

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
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9" />
</head>

<body>
<?php //include_once('head.php');?>

<div class="mainwrapper">
<?php include_once('header.php');?>
<?php include_once('inc_coluna.php');?>
<div class="rightpanel">
  <ul class="breadcrumbs">
    <li><a href="."><i class="iconfa-home"></i></a> <span class="separator"></span></li>
    <li><a href="relatorio-cliente.php">Relat&oacute;rio</a></li>
   
  </ul>
  <div class="pageheader">
  
<!--    	<a href="add_cliente.php"class="btn btn-primary btn-mini searchbar"> <i class="icon-plus"></i> &nbsp; Novo</a>-->
    
    <!--<form action="results.html" method="post" class="searchbar" />
                <input type="text" name="keyword" placeholder="To search type and hit enter..." />
            </form>-->
    <div class="pageicon"><span class="iconfa-edit"></span></div>
    <div class="pagetitle" >
      <h5>Relat&oacute;rio</h5>
      <h1>Relat&oacute;rio Clientes</h1>
    </div>
    
    
    
  </div>
  <!--pageheader-->
  <div class="maincontent">
    <div class="maincontentinner">
      <div class="widget">
        <h4 class="widgettitle"><span class="iconfa-edit"></span>Relat&oacute;rio Clientes</h4>
        <div class="widgetcontent">
        
          
          <div class="mediamgr_head">
	<form method="get" enctype="application/x-www-form-urlencoded" id="formProvas">
            <ul class="mediamgr_menu">
                <li style="width: 200px;">
                    Estado<br>
                    <select name="id_estado" class="uniformselect" onChange="document.getElementById('janela_cidades').innerHTML='&nbsp;Carregando Cidades!'; AtualizaJanela('cidades1.php?id_estado=' + this.value, 'cidades');" style="width: 160px;">
                       					<?php do{?>
                        <option value="<?php echo $row_rs_estado['id'];?>" <?php if(filter_input(INPUT_GET, 'id_estado') == $row_rs_estado['id']){ echo "selected";}?> /><?php echo $row_rs_estado['nome'];?>
                       					<?php }while($row_rs_estado = mysql_fetch_assoc($rs_estado));?>         
                       					</select>
                </li>
                <li style="width: 200px;">
                    <span id="janela_cidades">
                        <?php 
                            include_once('cidades1.php');
			?>
                    </span>
                </li>
                <li style="width: 200px;">
                    Plano<br>
                    <select name="id_plano" class="uniformselect" style="width: 160px;">
						<option value="">SELECIONE</option>
                       					<?php do{?>
                        <option value="<?php echo $row_rs_plano['id'];?>" <?php if(filter_input(INPUT_GET, 'id_plano') == $row_rs_plano['id']){ echo "selected";}?> /><?php echo utf8_decode($row_rs_plano['nome']);?>
                       					<?php }while($row_rs_plano = mysql_fetch_assoc($rs_plano));?>         
                       					</select>
                </li>
            </ul>
            <ul class="mediamgr_menu">
                <li class="filesearch">
                    <div class="input-prepend">
                    <span class="add-on">Palavra-Chave</span>
                    <input id="busca" type="text" name="busca" class="input-small" style="padding:5px; width:200px;" value="<?php echo $_GET['busca'];?>" /> 
                    </div>
                                  
                </li>
                <li class="left newfilebtn"><a href="javascript:;" onClick="document.getElementById('formProvas').submit()" class="btn btn-primary"  style="padding:4px; margin-left:10px;">Pesquisar</a></li>
            </ul>
        </form>
                        <span class="clearall"></span>
                    </div>
          
          <?php if($totalRows_rs_cliente > 0) { ?>
          <table class="table table-bordered">
           
            <tbody>
              
              <tr>
                <td><strong>C&oacute;digo</strong></td>
                <td><strong>Nome</strong></td>
                <td nowrap="nowrap"><strong>CPF</strong></td>
                <td><strong>RG</strong></td>
                <td><strong>Telefone 1</strong></td>
                <td><strong>Telefone 2</strong></td>
				<td><strong>E-mail</strong></td>  
				<td><strong>Vencimento</strong></td>  
                
              </tr>
            
            <?php
			if($totalRows_rs_cliente > 0){
			 do{?>
              <tr>
                <td><?php echo $row_rs_cliente['id'];?></td>
                <td><?php echo utf8_decode($row_rs_cliente['nome']);?></td>
                <td nowrap><?php echo $row_rs_cliente['cpf'];?></td>
                <td><?php echo $row_rs_cliente['rg'];?></td>
                <td><?php echo utf8_decode($row_rs_cliente['telefone1']);?></td>
                <td><?php echo utf8_decode($row_rs_cliente['telefone2']);?></td>
                <td><?php echo $row_rs_cliente['email'];?></td>
                <td><?php echo formataData($row_rs_cliente['data_vencimento']);?></td>
              </tr>
            <?php }while($row_rs_cliente = mysql_fetch_assoc($rs_cliente));
			}
			?>
              
            </tbody>
          </table>
          <?php } else { ?>
          <div align="center" style="font-size:15px;">Nenhum registro encontrado.</div>
          <?php } ?>
        </div>
        <!--widgetcontent-<?php
mysql_free_result($rs_cliente);
?>->
            </div><!--widget-->
<?php include_once('footer.php');?>