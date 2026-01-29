<?php 
include('restrito.php');
include('Connections/conexao.php');
include('funcoes.php');

$currentPage = 'cliente.php';


if($_GET['busca'] <> ''){
	$sql = "and (nome LIKE '%".$_GET['busca']."%' or cpf LIKE '%".$_GET['busca']."%' or telefone1 LIKE '%".$_GET['busca']."%' or email LIKE '%".$_GET['busca']."%' or endereco LIKE '%".$_GET['busca']."%')";
}

mysql_select_db($database_conexao, $conexao);
$query_rs_cliente = "SELECT * FROM tbl_cliente WHERE id is not null $sql ORDER BY id DESC";
$rs_cliente = mysql_query($query_rs_cliente, $conexao) or die(mysql_error());
$row_rs_cliente = mysql_fetch_assoc($rs_cliente);
$totalRows_rs_cliente = mysql_num_rows($rs_cliente);
?>
<!DOCTYPE html>
<html>
<head>

<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Cadastro de Contrato</title>

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
    <li><a href="cliente.php">Cadastro</a></li>
   
  </ul>
  <div class="pageheader">
  
    	<a href="add_cliente.php"class="btn btn-primary btn-mini searchbar"> <i class="icon-plus"></i> &nbsp; Novo</a>
	  
    
    <!--<form action="results.html" method="post" class="searchbar" />
                <input type="text" name="keyword" placeholder="To search type and hit enter..." />
            </form>-->
    <div class="pageicon"><span class="iconfa-edit"></span></div>
    <div class="pagetitle" >
      <h5>Cadastro</h5>
      <h1>Clientes</h1>
    </div>
    
    
    
  </div>
  <!--pageheader-->
  <div class="maincontent">
    <div class="maincontentinner">
      <div class="widget">
        <h4 class="widgettitle"><span class="iconfa-edit"></span>Clientes</h4>
        <div class="widgetcontent">
        
          
          <div class="mediamgr_head">
					<form method="get" enctype="application/x-www-form-urlencoded" id="formProvas">
                    	<ul class="mediamgr_menu">
                            <li class="filesearch">
                            		<div class="input-prepend">
                                      <span class="add-on">Palavra-Chave</span>
                                      <input id="busca" type="text" name="busca" class="input-small" style="padding:5px; width:200px;" value="<?php echo $_GET['busca'];?>" />                                    </div>
                                  
                            </li>
                            <li class="left newfilebtn"><a href="javascript:;" onClick="document.getElementById('formProvas').submit()" class="btn btn-primary"  style="padding:4px; margin-left:10px;">Pesquisar</a></li>	
							
                        <span class="clearall"></span>
                        </ul>
            </form>
			  <a href="exportar-contatos-clientes.php"class="btn btn-primary btn-mini searchbar" style="margin-top: 37px; margin-right: 23px;"> &nbsp; Exportar clientes</a>
			  
                    </div>
          
          <?php if($totalRows_rs_cliente > 0) { ?>
          <table width="100%" class="table table-bordered">
           
            <tbody>
              
              <tr>
                <td width="116"><strong>C&oacute;digo</strong></td>
                <td width="331"><strong>Cliente</strong><strong></strong></td>
                <td width="159"><strong>Telefone</strong></td>
                <td width="290"><strong>Plano</strong></td>
                <td width="145">&nbsp;</td>
                <td width="107">&nbsp;</td>
              </tr>
            
            <?php
			if($totalRows_rs_cliente > 0){
			 do{
				mysql_select_db($database_conexao, $conexao);
				$query_rs_plano = "SELECT * FROM tbl_plano WHERE id = '".$row_rs_cliente['id_plano']."'";
				$rs_plano = mysql_query($query_rs_plano, $conexao) or die(mysql_error());
				$row_rs_plano = mysql_fetch_assoc($rs_plano);
				$totalRows_rs_plano = mysql_num_rows($rs_plano);
				?>
              <tr>
                <td><?php echo $row_rs_cliente['id'];?></td>
                <td><strong>Nome: </strong><?php echo ($row_rs_cliente['nome']);?><br>
                  <strong>CPF: </strong><?php echo $row_rs_cliente['cpf'];?><br>
  <strong>E-mail: </strong><?php echo $row_rs_cliente['email'];?></td>
                <td><?php echo $row_rs_cliente['telefone1'];?></td>
                <td><?php echo ($row_rs_plano['nome']);?><br>
<strong>Contrata&ccedil;&atilde;o: </strong><?php echo formataData($row_rs_cliente['data_contratacao']);?></td>
                <td class="centeralign">
                    <a href="editar_cliente.php?id=<?php echo $row_rs_cliente['id'];?>" class="btn btn-primary btn-mini"> <i class="icon-pencil"></i> &nbsp; Editar
                    
                    </a>
                </td>
                <td>
                	<!--<a href="sql_excluir.php?id=<?php echo $row_rs_cliente['id']; ?>&acao=excluirCliente" class="btn btn-danger btn-mini"> <i class="iconfa-remove"></i> Excluir
                    </a>-->
				</td>
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