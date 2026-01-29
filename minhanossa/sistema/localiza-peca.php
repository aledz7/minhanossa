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

if(filter_input(INPUT_GET, 'id_produto') <> ''){
        $sql .= " and tbl_produto.id = '".filter_input(INPUT_GET, 'id_produto')."'";
}

if(filter_input(INPUT_GET, 'condicao') <> ''){
        $sql .= " and tbl_historico_produto.condicao = '".filter_input(INPUT_GET, 'condicao')."'";
}

mysql_select_db($database_conexao, $conexao);
$query_rs_provas = "SELECT * FROM tbl_historico_produto WHERE id is not null $sql ORDER BY data_retorno DESC";
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
<?php include_once('header.php');?>
<?php include_once('inc_coluna.php');?>
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
        
         
         <div class="mediamgr_head">
					<form method="get" enctype="application/x-www-form-urlencoded" id="formProvas">
                    	<ul class="mediamgr_menu">
                            <li class="filesearch">
                            		  <div class="input-prepend">
                                      <span class="add-on">Data Retirada</span>
                                      <input id="dataSaida" type="text" name="dataSaida" class="input-small datepicker" style="padding:5px;" value="<?=$_GET['dataSaida'];?>" />                                    
                                      </div>
                                      <div class="input-prepend">
                                      <span class="add-on">Data Devolu&ccedil;&atilde;o</span>
                                      <input id="dataRetorno" type="text" name="dataRetorno" class="input-small datepicker" style="padding:5px;" value="<?=$_GET['dataRetorno'];?>" />                                    
                                      </div>
                                   
                                  
                                   
                              <div class="input-prepend">
                                      <span class="add-on">Produto</span>
								  
                                      <select name="id_produto" id="id_produto" style="height:32px; width: 104px;" >
                                      	<option value=""></option>
										<?php do { ?>
                                        <option value="<?=$row_rs_produtos['id'];?>" <?php if($row_rs_produtos['id'] == $_GET['id_produto']) { echo 'selected'; } ?>><?=utf8_decode($row_rs_produtos['nome']);?></option>
                                        <? } while($row_rs_produtos = mysql_fetch_assoc($rs_produtos)); ?>
                                      </select>
                                   </div>
                                      
                                       <div class="input-prepend">
                                      <span class="add-on">C&oacute;digo</span>
                                      <input id="buscaCodigo" type="text" name="buscaCodigo" class="input-small" style="padding:5px;" value="<?=$_GET['buscaCodigo'];?>" />                                    
                                      </div>
									  <div class="input-prepend">
										  <span class="add-on" style="width: 55px">Condi&ccedil;&atilde;o</span>


										  <select name="condicao" id="condicao" style="height:32px; width: 104px;" >
											<option value=""></option>
											<option value="C">Alugado</option>
											<option value="A">Ajustes</option>
											<option value="L">Lavanderia</option>
										  </select>
								      </div>	
                                
                            </li>
							
                            <li class="left newfilebtn" style="margin-top: 20px;"><a href="javascript:;" onClick="document.getElementById('formProvas').submit()" class="btn btn-primary"  style="padding:4px; margin-left:10px;">Pesquisar</a></li>
                            <li class="left newfilebtn" style="margin-top: 20px;" ><a href="imprimir-localiza-peca.php?dataSaida=<?php echo $_GET['id']?>" onClick="document.getElementById('formProvas').submit()" class="btn btn-primary"  style="padding:4px; margin-left:10px;">Imprimir</a></li>
                        </ul>
            </form>
                        <span class="clearall"></span>
                    </div>
         <?php if($totalRows_rs_provas > 0) { ?>
          <table width="85%" class="table table-bordered">
           
            <tbody>
              
              <tr>
                <td width="21%"><strong>C&oacute;digo Produto</strong></td>
                <td width="5%"><strong>Tamanho</strong></td>
                <td width="5%"><strong>Cor</strong></td>
                <td width="21%"><strong>Localiza&ccedil;&atilde;o</strong></td>
                <td width="13%"><strong>Data Retirada</strong></td>
                <td width="12%"><strong>Data Devolu&ccedil;&atilde;o</strong></td>
              </tr>
            
            <?php
			if($totalRows_rs_provas > 0){
			 do{
				mysql_select_db($database_conexao, $conexao);
				$query_rs_produto = "SELECT tbl_produto.*, tbl_cores.nome as cor FROM tbl_produto left join tbl_cores on tbl_cores.id = tbl_produto.id_cor WHERE tbl_produto.id = '".$row_rs_provas['id_produto']."'";
				$rs_produto = mysql_query($query_rs_produto, $conexao) or die(mysql_error());
				$row_rs_produto = mysql_fetch_assoc($rs_produto);
				$totalRows_produto = mysql_num_rows($rs_produto);  
		     ?>
              <tr>
                <td><?php echo $row_rs_produto['id'];?> / <?php echo utf8_decode($row_rs_produto['nome']);?> </td>
				<td><?php echo $row_rs_produto['numeracao'];?></td>
                <td><?php echo utf8_decode($row_rs_produto['cor']);?></td> 
                <td>
                <?php 
                if($row_rs_provas['condicao'] == 'C'){ echo "Encontra-se alugado <a href='editar_contrato.php?id=".$row_rs_provas['id_contrato']."' style='color: #000000;'>(".$row_rs_provas['id_contrato'].")</a>.";} 
                if($row_rs_provas['condicao'] == 'A'){ echo "Encontra-se em ajuste <a href='editar-ajustes.php?id=".$row_rs_provas['id_ajuste']."' style='color: #000000;'>(".$row_rs_provas['id_ajuste'].")</a>.";}
                if($row_rs_provas['condicao'] == 'L'){ echo "Encontra-se na lavanderia <a href='editar-lavanderia.php?id=".$row_rs_provas['id_lavanderia']."' style='color: #000000;'>(".$row_rs_provas['id_lavanderia'].")</a>.";}
                ?>
                </td>
               
                <td><?php echo formataData($row_rs_provas['data_saida']);?></td>
                
                <td><?php echo formataData($row_rs_provas['data_retorno']);?></td>
                
              </tr>
            <?php }while($row_rs_provas = mysql_fetch_assoc($rs_provas));
			}
			?>
              
            </tbody>
          </table>
          <? 
		  } else { 
		  	?>
            <div align="center" style="margin-bottom:27px; font-size:15px; color:#00724C">Produto / Traje sem historico.</div>
            <?
		  }
		  ?>
          
        </div>
        <!--widgetcontent-<?php
mysql_free_result($rs_produtos);
?>->
            </div><!--widget-->
        <?php include_once('footer.php');?>