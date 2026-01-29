<?php 
include('restrito.php');
include('Connections/conexao.php');
include('funcoes.php');

include('class/html.php');
$HTML = new HTML;

$currentPage = 'provas.php';

mysql_select_db($database_conexao, $conexao);
$query_rs_vendedores = "SELECT * FROM tbl_admin ORDER BY nome ASC";
$rs_vendedores = mysql_query($query_rs_vendedores, $conexao) or die(mysql_error());
$row_rs_vendedores = mysql_fetch_assoc($rs_vendedores);
$totalRows_rs_vendedores = mysql_num_rows($rs_vendedores);

include('rs-ponto.php');
?>
<!DOCTYPE html>
<html>
<head>

<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Relat&oacute;rios > Folha de Ponto</title>

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
    <li><a href="provas.php">Folha de Ponto</a></li>
    
  </ul>
  <div class="pageheader">
  
    	<a href="add_contrato.php"class="btn btn-primary btn-mini searchbar"> <i class="icon-plus"></i> &nbsp; Novo</a>
    
    <div class="pageicon"><span class="iconfa-edit"></span></div>
    <div class="pagetitle" >
      <h5>Relat&oacute;rio</h5>
      <h1>Folha de Ponto</h1>
    </div>
    
    
    
  </div>
  <!--pageheader-->
  <div class="maincontent">
    <div class="maincontentinner">
      <div class="widget">
        <h4 class="widgettitle"><span class="icon-calendar"></span>Folha de Ponto</h4>
        <div class="widgetcontent">
        
         
         <div class="mediamgr_head">
					<form method="get" enctype="application/x-www-form-urlencoded" id="formProvas">
                    	<ul class="mediamgr_menu">
                            <li class="filesearch">
                            		<div class="input-prepend">
                                      <span class="add-on">Data de In&iacute;cio</span>
                                      <input id="dataInicio" type="text" name="dataInicio" class="input-small datepicker" style="padding:5px;" value="<?php echo $_GET['dataInicio'];?>" />                                    </div>
                                   
                                   
                                   <div class="input-prepend">
                                      <span class="add-on">Data Final</span>
                                      <input id="dataFim" value="<?php echo $_GET['dataFim'];?>" style="padding:5px;" type="text" name="dataFim" class="input-small datepicker" />                                    </div>
                                   
                                   
                                   <div class="input-prepend">
                                      <span class="add-on">Funcion&aacute;rio</span>
                                   
                            
                                      <select name="id_vendedor" id="id_vendedor" style="height:32px;" >
                                      	<option value=""></option>
										<?php do { ?>
                                        <option value="<?php echo $row_rs_vendedores['id'];?>" <?php if($row_rs_vendedores['id'] == $_GET['id_vendedor']) { echo 'selected'; } ?>><?php echo $row_rs_vendedores['nome'];?></option>
                                        <?php } while($row_rs_vendedores = mysql_fetch_assoc($rs_vendedores)); ?>
                                      </select>
                                   </div>
                                      
                                      
                                
                            </li>
                            <li class="left newfilebtn"><a href="javascript:;" onClick="document.getElementById('formProvas').submit()" class="btn btn-primary"  style="padding:4px; margin-left:10px;">Pesquisar</a></li>
                            
                            <?php if($_GET['dataInicio'] <> '' and $_GET['dataFim'] <> '' and $_GET['id_vendedor'] <> '') { ?>
                            <li class="left newfilebtn"><a href="javascript:;" onClick="abreJanelaJquery('imprimir-folha-de-ponto.php?&<?php echo $_SERVER['QUERY_STRING'];?>&imprimir=S', 'Imprimir Folha de Ponto', '', '950px', '500', rand(1,9999))" class="btn btn-primary"  style="padding:4px; margin-left:10px;">Imprimir</a></li>
      <?php } ?>                      
                        </ul>
            </form>
                        <span class="clearall"></span>
                    </div>
         <?php if($totalRows_rs_ponto > 0) { ?>
          <table class="table table-bordered">
           
            <tbody>
              
              <tr>
                <td width="13%" style="text-align:center"><strong>Dia</strong></td>
                <td width="12%" style="text-align:center"><strong>Chegada</strong></td>
                <td width="17%" style="text-align:center" ><strong>Sa&iacute;da Almo&ccedil;o</strong></td>
                <td width="17%" style="text-align:center"><strong>Chegada Almo&ccedil;o</strong></td>
                <td width="11%" style="text-align:center"><strong>Sa&iacute;da</strong></td>
                <td width="17%" style="text-align:center"><strong>Horas Trabalhadas</strong></td>
                <td style="text-align:center"><strong>Op&ccedil;&otilde;es</strong></td>
               
              </tr>
            
            <?php
			if($totalRows_rs_ponto > 0){
			 do {
				 $manhaSegs = hora_to_seg($row_rs_relatorio['Hs Saida almoco'])-hora_to_seg($row_rs_relatorio['hora Chegada']);
				$tardeSegs = hora_to_seg($row_rs_relatorio['hs saida'])-hora_to_seg($row_rs_relatorio['hs chegada almoco']);
				$tempoTrabalhado = $manhaSegs+$tardeSegs;
		     ?>
              <tr>
                <td style="text-align:center"><?php echo formataData($row_rs_ponto['chegada']);?></td>
                <td style="text-align:center"><?php echo substr($row_rs_ponto['chegada'],11,8);?></td>
                <td style="text-align:center" ><?php echo substr($row_rs_ponto['saida_almoco'],11,8);?></td>
                <td style="text-align:center"><?php echo substr($row_rs_ponto['chegada_almoco'],11,8);?></td>
                <td style="text-align:center"><?php echo substr($row_rs_ponto['saida'],11,8);?></td>
                <td style="text-align:center"><?php echo m2h($tempoTrabalhado/60);?></td>
                <td width="13%" style="text-align:center"><a href="editar_contrato.php?id=<?php echo $row_rs_ponto['id_contrato'];?>"class="btn btn-primary btn-mini"> <i class="icon-pencil"></i> &nbsp; Visualizar
                    
                    </a></td>
                
                
              </tr>
             
            <?php }while($row_rs_ponto = mysql_fetch_assoc($rs_ponto)); ?>
             
              <?php
			}
			?>
              
            </tbody>
          </table>
          <?php 
		  } else { 
		  	$HTML->nenhumRegistro("Nenhum registro encontrado. Por favor, realize uma busca.");
		  }
		  ?>
          
        </div>
        <!--widgetcontent-<?php
mysql_free_result($rs_vendedores);
?>->
            </div><!--widget-->
        <?php include_once('footer.php');?>