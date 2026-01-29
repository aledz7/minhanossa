<?php 
include('restrito.php');
include('Connections/conexao.php');
include('funcoes.php');

include('class/html.php');
$HTML = new HTML;

$currentPage = 'provas.php';

mysql_select_db($database_conexao, $conexao);
$query_rs_produtos = "SELECT * FROM tbl_produto ORDER BY nome ASC";
$rs_produtos = mysql_query($query_rs_produtos, $conexao) or die(mysql_error());
$row_rs_produtos = mysql_fetch_assoc($rs_produtos);
$totalRows_rs_produtos = mysql_num_rows($rs_produtos);

if($_GET['dataSaida'] <> ''){
	$sql .= "and data_saida <= '".formataDataSQL($_GET['dataSaida'])."'";
}

if($_GET['dataRetorno'] <> ''){
	$sql .= "and data_retorno >= '".formataDataSQL($_GET['dataRetorno'])."'";
}

if($_GET['buscaCodigo'] <> ''){
	$sql .= " and id_produto = '".$_GET['buscaCodigo']."'";
}

if($_GET['id_produto'] <> ''){
	$sql .= " and id_produto = '".$_GET['id_produto']."'";
}

mysql_select_db($database_conexao, $conexao);
$query_rs_provas = "SELECT * FROM tbl_historico_produto WHERE id is not null $sql ORDER BY data_retorno ASC";
$rs_provas = mysql_query($query_rs_provas, $conexao) or die(mysql_error());
$row_rs_provas = mysql_fetch_assoc($rs_provas);
$totalRows_rs_provas = mysql_num_rows($rs_provas);
?>
<!DOCTYPE html>
<html>
<head>

<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Localiza&ccedil;&atilde;o > Provas</title>

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
<div class="rightpanel">
  <ul class="breadcrumbs">
    <li><a href="."><i class="iconfa-home"></i></a> <span class="separator"></span></li>
    <li><a href="provas.php">Provas</a></li>
    
  </ul>
  <div class="pageheader">
  
    	<a href="add_contrato.php"class="btn btn-primary btn-mini searchbar"> <i class="icon-plus"></i> &nbsp; Novo</a>
    
    <div class="pageicon"><span class="iconfa-edit"></span></div>
    <div class="pagetitle" >
      <h5>PRODUTOS</h5>
      <h1>LOCALIZA&Ccedil;&Atilde;O</h1>
    </div>
    
    
    
  </div>
  <!--pageheader-->
  <div class="maincontent">
    <div class="maincontentinner">
      <div class="widget">
        <h4 class="widgettitle"><span class="icon-calendar"></span>Localiza&ccedil;&atilde;o de Pe&ccedil;as</h4>
        <div class="widgetcontent">
        
         
        <?php /*?> <div class="mediamgr_head">
					<form method="get" enctype="application/x-www-form-urlencoded" id="formProvas">
                    	<ul class="mediamgr_menu">
                            <li class="filesearch">
                            		<div class="input-prepend">
                                      <span class="add-on">Data Retirada</span>
                                      <input id="dataSaida" type="text" name="dataSaida" class="input-small datepicker" style="padding:5px;" value="<?php echo $_GET['dataSaida'];?>" />                                    
                                      </div>
                                      <div class="input-prepend">
                                      <span class="add-on">Data Devolu&ccedil;&atilde;o</span>
                                      <input id="dataRetorno" type="text" name="dataRetorno" class="input-small datepicker" style="padding:5px;" value="<?php echo $_GET['dataRetorno'];?>" />                                    
                                      </div>
                                   
                                  
                                   
                              <div class="input-prepend">
                                      <span class="add-on">Produto</span>
                                   
                            
                                      <select name="id_produto" id="id_produto" style="height:32px;" >
                                      	<option value=""></option>
										<?php do { ?>
                                        <option value="<?php echo $row_rs_produtos['id'];?>" <?php if($row_rs_produtos['id'] == $_GET['id_produto']) { echo 'selected'; } ?>><?php echo $row_rs_produtos['nome'];?></option>
                                        <?php } while($row_rs_produtos = mysql_fetch_assoc($rs_produtos)); ?>
                                      </select>
                                   </div>
                                      
                                       <div class="input-prepend">
                                      <span class="add-on">C&oacute;digo</span>
                                      <input id="buscaCodigo" type="text" name="buscaCodigo" class="input-small" style="padding:5px;" value="<?php echo $_GET['buscaCodigo'];?>" />                                    
                                      </div>
                                
                            </li>
                            <li class="left newfilebtn"><a href="javascript:;" onClick="document.getElementById('formProvas').submit()" class="btn btn-primary"  style="padding:4px; margin-left:10px;">Pesquisar</a></li>
                        </ul>
            </form>
                        <span class="clearall"></span>
                    </div><?php */?>
                    
         <?php if($totalRows_rs_provas > 0) { ?>
          <table width="85%" class="table table-bordered">
           
            <tbody>
              
              <!--<tr>
                <td width="31%"><strong>C&oacute;digo Produto</strong></td>
                <td width="31%"><strong>Localiza&ccedil;&atilde;o</strong></td>
                <td width="13%"><strong>Data Retirada</strong></td>
                <td width="12%"><strong>Data Devolu&ccedil;&atilde;o</strong></td>
              </tr>-->
            
            <?php
			if($totalRows_rs_provas > 0){
			 do{
				mysql_select_db($database_conexao, $conexao);
$query_rs_produto = "SELECT * FROM tbl_produto WHERE id = '".$row_rs_provas['id_produto']."'";
$rs_produto = mysql_query($query_rs_produto, $conexao) or die(mysql_error());
$row_rs_produto = mysql_fetch_assoc($rs_produto);
$totalRows_produto = mysql_num_rows($rs_produto); 
		     ?>
              <tr>
                <td><?php echo $row_rs_produto['id'];?></td>
                <td>
                <?php 
                if($row_rs_provas['condicao'] == 'C'){ echo "Encontra-se alugado <a href='editar_contrato.php?id=".$row_rs_provas['id_contrato']."' style='color: #000000;'>(".$row_rs_provas['id_contrato'].")</a>.";} 
                if($row_rs_provas['condicao'] == 'A'){ echo "Encontra-se em ajuste <a href='editar-ajustes.php?id=".$row_rs_provas['id_ajuste']."' style='color: #000000;'>(".$row_rs_provas['id_ajuste'].")</a>.";}
                if($row_rs_provas['condicao'] == 'L'){ echo "Encontra-se na lavanderia <a href='editar-lavanderia.php?id=".$row_rs_provas['id_lavanderia']."' style='color: #000000;'>(".$row_rs_provas['id_lavanderia'].")</a>.";}
                ?>
                </td>
                
                <td><?php echo substr($row_rs_provas['data_evento'],8,2);?> / <?php echo substr($row_rs_provas['data_evento'],5,2);?> / <?php echo substr($row_rs_provas['data_evento'],0,4);?></td>
                
                <td><?php echo substr($row_rs_provas['data_devolucao'],8,2);?> / <?php echo substr($row_rs_provas['data_devolucao'],5,2);?> / <?php echo substr($row_rs_provas['data_devolucao'],0,4);?></td>
                
              </tr>
            <?php }while($row_rs_provas = mysql_fetch_assoc($rs_provas));
			}
			?>
              
            </tbody>
          </table>
          <?php 
		  } else { 
		  	?>
            <div align="center" style="margin-bottom:27px; font-size:15px; color:#00724C">Produto / Traje sem historico.</div>
            <?php
		  }
		  ?>
          
        </div>
        <!--widgetcontent-<?php
mysql_free_result($rs_produtos);
?>->
</div><!--widget-->
<script>
print();
function redireciona() {
	window.location='imprimir-localiza-peca.php?dataSaida=<?php echo $_GET['id']?>';
}
setTimeout(function(){ redireciona(); }, 1000);
</script>
       