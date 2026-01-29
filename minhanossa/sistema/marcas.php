<?php 
include('restrito.php');
include('Connections/conexao.php');
include('funcoes.php');

$currentPage = 'marcas.php';

mysql_select_db($database_conexao, $conexao);
$query_rs_marcas = "SELECT * FROM tbl_marcas ORDER BY titulo ASC";
$rs_marcas = mysql_query($query_rs_marcas, $conexao) or die(mysql_error());
$row_rs_marcas = mysql_fetch_assoc($rs_marcas);
$totalRows_rs_marcas = mysql_num_rows($rs_marcas);
?>
<!DOCTYPE html>
<html>
<head>

<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Cadastro de Marcas</title>

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
  
    	<a href="add_marca.php"class="btn btn-primary btn-mini searchbar"> <i class="icon-plus"></i> &nbsp; Novo</a>
    
    <!--<form action="results.html" method="post" class="searchbar" />
                <input type="text" name="keyword" placeholder="To search type and hit enter..." />
            </form>-->
    <div class="pageicon"><span class="iconfa-edit"></span></div>
    <div class="pagetitle" >
      <h5>Cadastro</h5>
      <h1>Marcas</h1>
    </div>
    
    
    
  </div>
  <!--pageheader-->
  <div class="maincontent">
    <div class="maincontentinner">
      <div class="widget">
        <h4 class="widgettitle"><span class="iconfa-edit"></span>Marcas</h4>
        <div class="widgetcontent">
        
          
        <?php /*?>  <div class="mediamgr_head">
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
                    </div><?php */?>
          
          <?php if($totalRows_rs_marcas > 0) { ?>
          <table class="table table-bordered">
           
            <tbody>
              
              <tr>
                <td width="68"><strong>C&oacute;digo</strong></td>
                <td width="183"><strong>Foto</strong></td>
                <td width="747"><strong>Instagram</strong></td>
              	<td width="123">&nbsp;</td>
                <td width="113">&nbsp;</td>
              </tr>
            
            <?php
			if($totalRows_rs_marcas > 0){
			 do{?>
              <tr>
                <td><?php echo $row_rs_marcas['id'];?></td>
                <td><img src="../img_noticias/<?php echo $row_rs_marcas['foto'];?>" width="70" alt=""></td>
                <td><?php echo $row_rs_marcas['instagram'];?></td>
                <td class="centeralign">
                    <a href="editar_marca.php?id=<?php echo $row_rs_marcas['id'];?>" class="btn btn-primary btn-mini"> <i class="icon-pencil"></i> &nbsp; Editar
                    
                    </a>
                </td>
                <td>
                	<a href="sql_excluir.php?id=<?php echo $row_rs_marcas['id']; ?>&acao=excluirMarca" class="btn btn-danger btn-mini"> <i class="iconfa-remove"></i> Excluir
                    </a>
				</td>
              </tr>
            <?php }while($row_rs_marcas = mysql_fetch_assoc($rs_marcas));
			}
			?>
              
            </tbody>
          </table>
          <?php } else { ?>
          <div align="center" style="font-size:15px;">Nenhum registro encontrado.</div>
          <?php } ?>
        </div>
        <!--widgetcontent-<?php
mysql_free_result($rs_marcas);
?>
           
        <?php include_once('footer.php');?>