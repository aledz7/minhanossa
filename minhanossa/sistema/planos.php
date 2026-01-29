<?php 
include('restrito.php');
include('Connections/conexao.php');
include('funcoes.php');

$currentPage = 'planos.php';


if($_GET['busca'] <> ''){
	$sql = "and (nome LIKE '%".$_GET['busca']."%' or descricao LIKE '%".$_GET['busca']."%' or pontuacao_mensal LIKE '%".$_GET['busca']."%')";
}

mysql_select_db($database_conexao, $conexao);
$query_rs_planos = "SELECT * FROM tbl_plano WHERE id is not null $sql ORDER BY id ASC";
$rs_planos = mysql_query($query_rs_planos, $conexao) or die(mysql_error());
$row_rs_planos = mysql_fetch_assoc($rs_planos);
$totalRows_rs_planos = mysql_num_rows($rs_planos);
?>
<!DOCTYPE html>
<html>
<head>

<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Cadastro de Planos</title>

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
    <li><a href="planos.php">Cadastro</a></li>
   
  </ul>
  <div class="pageheader">
  
    	<a href="add_plano.php"class="btn btn-primary btn-mini searchbar"> <i class="icon-plus"></i> &nbsp; Novo</a>
    
    <!--<form action="results.html" method="post" class="searchbar" />
                <input type="text" name="keyword" placeholder="To search type and hit enter..." />
            </form>-->
    <div class="pageicon"><span class="iconfa-edit"></span></div>
    <div class="pagetitle" >
      <h5>Cadastro</h5>
      <h1>Planos</h1>
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
                                      <input id="busca" type="text" name="busca" class="input-small" style="padding:5px; width:200px;" value="<?=$_GET['busca'];?>" />                                    </div>
                                  
                            </li>
                            <li class="left newfilebtn"><a href="javascript:;" onClick="document.getElementById('formProvas').submit()" class="btn btn-primary"  style="padding:4px; margin-left:10px;">Pesquisar</a></li>
                        </ul>
            </form>
                        <span class="clearall"></span>
                    </div>
          
          <?php if($totalRows_rs_planos > 0) { ?>
          <table class="table table-bordered">
           
            <tbody>
              
              <tr>
                <td><strong>C&oacute;digo</strong></td>
                <td><strong>Plano</strong></td>
                <td><strong>Valor</strong></td>
              
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            
            <?php
			if($totalRows_rs_planos > 0){
			 do{?>
              <tr>
                <td><?php echo $row_rs_planos['id'];?></td>
                <td><?php echo utf8_decode($row_rs_planos['nome']);?></td>
                <td><?php echo number_format($row_rs_planos['valor'],2,',','.');?></td>
                <td class="centeralign">
                    <a href="editar_plano.php?id=<?php echo $row_rs_planos['id'];?>" class="btn btn-primary btn-mini"> <i class="icon-pencil"></i> &nbsp; Editar
                    
                    </a>
                </td>
                <td>
                	<a href="sql_excluir.php?id=<?php echo $row_rs_planos['id']; ?>&acao=excluirPlano" class="btn btn-danger btn-mini"> <i class="iconfa-remove"></i> Excluir
                    </a>
				</td>
              </tr>
            <?php }while($row_rs_planos = mysql_fetch_assoc($rs_planos));
			}
			?>
              
            </tbody>
          </table>
          <?php } else { ?>
          <div align="center" style="font-size:15px;">Nenhum registro encontrado.</div>
          <?php } ?>
        </div>
        <!--widgetcontent-<?php
mysql_free_result($rs_planos);
?>
           
        <?php include_once('footer.php');?>