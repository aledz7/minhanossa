<?php 
include('restrito.php');
include('Connections/conexao.php');
include('funcoes.php');

if (!isset($_SESSION)) { session_start(); }

$currentPage = 'news.php';

mysql_select_db($database_conexao, $conexao);
$query_rs_cliente = "SELECT * FROM tbl_newsletter ORDER BY id DESC";
$rs_cliente = mysql_query($query_rs_cliente, $conexao) or die(mysql_error());
$row_rs_cliente = mysql_fetch_assoc($rs_cliente);
$totalRows_rs_cliente = mysql_num_rows($rs_cliente);

?>
<!DOCTYPE html>
<html>
<head>

<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Newsletter</title>

<link rel="stylesheet" href="css/style.default.css" type="text/css" />
<link rel="stylesheet" href="css/bootstrap-fileupload.min.css" type="text/css" />
<link rel="stylesheet" href="css/bootstrap-timepicker.min.css" type="text/css" />

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
    <li><a href="news.php">Newsletter</a></li>
    
  </ul>
  <div class="pageheader">
  
    	<?php /*?><a href="javascript:;" class="btn btn-primary btn-mini searchbar" onClick="abreJanelaJquery('novo-contrato-codigo-cliente.php', 'Codigo Cliente', '', '250px', '120', rand(1,9999));"> <i class="icon-plus"></i> &nbsp; Novo Aluguel</a><?php */?>
    	<!--<a href="add_contrato.php" class="btn btn-primary btn-mini searchbar" > <i class="icon-plus"></i> &nbsp; Novo News</a>-->
    
    <div class="pageicon"><span class="iconfa-edit"></span></div>
    <div class="pagetitle" >
      <h5>Newsletter</h5>
      <h1>Newsletter</h1>
    </div>
    
    
    
  </div>
  <!--pageheader-->
  <div class="maincontent">
    <div class="maincontentinner">
      <div class="widget">
        <h4 class="widgettitle"><span class="iconfa-shopping-cart"></span>Newsletter</h4>
        <div class="widgetcontent">
        
          <div class="divider30"></div>
          <table class="table table-bordered" width="100%">
           
            <tbody>
            
            
              
              <tr>
                
                <td width="82%"><strong>E-mail</strong></td>
                <td width="18%" style="text-align:center; font-weight:bold;">Op&ccedil;&otilde;es</td>
              </tr>
            
            <?php
			if($totalRows_rs_cliente > 0){
			 do{?>
              <tr>
                <td style="text-align:left"><?php echo $row_rs_cliente['email'];?></td>
                
                <td colspan="2" class="centeralign">
                   
                	<a href="sql_excluir.php?id=<?php echo $row_rs_cliente['id']; ?>&acao=excluirNews" class="btn btn-danger btn-mini" style="margin-left:7px;"> <i class="iconfa-remove"></i> Excluir
                    </a>
				</td>
              </tr>
            <?php }while($row_rs_cliente = mysql_fetch_assoc($rs_cliente));
			}
			?>
              
            </tbody>
          </table>
        </div>
        <!--widgetcontent-<?php
mysql_free_result($rs_contrato);
?>->
            </div><!--widget-->
        <?php include_once('footer.php');?>