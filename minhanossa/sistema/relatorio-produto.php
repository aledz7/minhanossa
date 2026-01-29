<?php 
include('restrito.php');
include('Connections/conexao.php');
include('funcoes.php');

$currentPage = 'cliente.php';

if($_GET['busca'] <> ''){
	$sql = "and (nome LIKE '%".$_GET['busca']."%' or data_saida LIKE '%".$_GET['busca']."%' or data_retorno LIKE '%".$_GET['busca']."%' or nome LIKE '%".$_GET['busca']."%' or endereco LIKE '%".$_GET['busca']."%')";
}

if($_GET['busca'] <> ''){
	$sql = "and id_produto LIKE '%".$_GET['busca']."%'";
}
//if(filter_input(INPUT_GET, 'id_produto') <> ''){
//        $sql .= " and tbl_produto.id = '".filter_input(INPUT_GET, 'id_produto')."'";
//}
if($_GET['dataSaida'] <> ''){
	$sql .= "and data_saida >= '".$_GET['dataSaida']."'";
}

if($_GET['dataRetorno'] <> ''){
	$sql .= "and data_retorno <= '".$_GET['dataRetorno']."'";
}
if(filter_input(INPUT_GET, 'condicao') <> ''){
        $sql .= " and tbl_historico_produto.condicao = '".filter_input(INPUT_GET, 'condicao')."'";
}

if($_GET['buscaCodigo'] <> ''){
	$sql_item .= " and tbl_item.nome_produto = '".$_GET['buscaCodigo']."'";
}

mysql_select_db($database_conexao, $conexao);
$query_rs_historico = "SELECT *, tbl_produto.nome, tbl_produto.numeracao FROM tbl_historico_produto INNER JOIN tbl_produto on tbl_produto.id = tbl_historico_produto.id_produto WHERE tbl_historico_produto.id_contrato is not null and tbl_historico_produto.id_contrato <> 0 $sql ORDER BY tbl_historico_produto.id DESC limit 0,200";
$rs_historico = mysql_query($query_rs_historico, $conexao) or die(mysql_error());
$row_rs_historico = mysql_fetch_assoc($rs_historico);
$totalRows_rs_historico = mysql_num_rows($rs_historico);


?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Relatório de Clientes</title>
<link rel="stylesheet" href="css/style.default.css" type="text/css" />
<link rel="stylesheet" href="css/bootstrap-fileupload.min.css" type="text/css" />
<link rel="stylesheet" href="css/bootstrap-timepicker.min.css" type="text/css" />
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />	
<style type="text/css">
body,td,th {
	font-family: RobotoRegular, "Helvetica Neue", Helvetica, sans-serif;
}
</style>
	

</head>

<body>
<?php //include_once('head.php');?>

<div class="mainwrapper">
<?php include_once('header.php');?>
<?php include_once('inc_coluna.php');?>
<div class="rightpanel">
  <ul class="breadcrumbs">
    <li><a href="."><i class="iconfa-home"></i></a> <span class="separator"></span></li>
    <li><a href="relatorio-cliente.php">Relatório</a></li>
   
  </ul>
  <div class="pageheader">
  
<!--    	<a href="add_cliente.php"class="btn btn-primary btn-mini searchbar"> <i class="icon-plus"></i> &nbsp; Novo</a>-->
    
    <!--<form action="results.html" method="post" class="searchbar" />
                <input type="text" name="keyword" placeholder="To search type and hit enter..." />
            </form>-->
    <div class="pageicon"><span class="iconfa-edit"></span></div>
    <div class="pagetitle" >
      <h5>Relatório</h5>
      <h1>Relatório de Peças</h1>
    </div>
    
    
    
  </div>
  <!--pageheader-->
  <div class="maincontent">
    <div class="maincontentinner">
      <div class="widget">
        <h4 class="widgettitle"><span class="iconfa-edit"></span>Relatório de Peças</h4>
        <div class="widgetcontent">
        
          
           <div class="mediamgr_head">
					<form method="get" enctype="application/x-www-form-urlencoded" id="formProvas">
                    	<ul class="mediamgr_menu">
                            <li class="filesearch">
<!--
                            		<div class="input-prepend">
                                      <span class="add-on">Data Retirada</span>
                                      <input id="dataSaida" type="date" name="dataSaida" class="input-small datepicker" style="padding:5px;" value="<?=$_GET['dataSaida'];?>" />                                    
                                      </div>
-->
<!--
                                      <div class="input-prepend">
                                      <span class="add-on">Data Devolu&ccedil;&atilde;o</span>
                                      <input id="dataRetorno" type="date" name="dataRetorno" class="input-small datepicker" style="padding:5px;" value="<?=$_GET['dataRetorno'];?>" />                                    
                                      </div>
-->
                                   
                                  
                                   
                              <div class="input-prepend">
                                      <span class="add-on" style="width: 43px">Produto</span>
								  		<input type="text" name="busca"  value="<?=$_GET['busca'];?>" placeholder="Código do Produto" style="height: 22px;">


                                   </div>
                                      
<!--
                                       <div class="input-prepend">
										  <span class="add-on" style="width: 55px">Condição</span>


										  <select name="condicao" id="condicao" style="height:32px; width: 104px;" >
											<option value=""></option>
											<option value="C">Alugado</option>
											<option value="A">Ajustes</option>
											<option value="L">Lavanderia</option>
										  </select>
								      </div>
-->
                                
                            </li>
                            <li class="left newfilebtn"><a href="javascript:;" onClick="document.getElementById('formProvas').submit()" class="btn btn-primary"  style="padding:4px; margin-left:10px;">Pesquisar</a></li>
                            <li class="left newfilebtn"><a href="imprimir-localiza-peca.php?dataSaida=<?php echo $_GET['id']?>" onClick="document.getElementById('formProvas').submit()" class="btn btn-primary"  style="padding:4px; margin-left:10px;">Imprimir</a></li>
                        </ul>
            </form>
                        <span class="clearall"></span>
                    </div>
          
          <?php if($totalRows_rs_historico > 0) { ?>
          <table class="table table-bordered">
           
            <tbody>
              
              <tr>
                <td width="146"><strong>C&oacute;digo do Produto</strong></td>
                <td width="135"><strong>Nome do Produto</strong></td>
                <td width="126"><strong>Nome do Cliente</strong></td>
                <td width="105"><strong>Data da Retirada</strong></td>
                <td width="151"><strong>Data de Devolução</strong></td>
                <td width="151"><strong>Código do Aluguel</strong></td>
<!--				<td><strong>C&oacute;digo do Aluguel</strong></td>  -->
              </tr>
            
            <?php
			
			if($totalRows_rs_historico > 0){
			 do{
				 	mysql_select_db($database_conexao, $conexao);
					$query_rs_contrato = "
					SELECT 
						tbl_contrato.id, 
						tbl_cliente.nome 
					FROM 
						tbl_contrato 
						inner join tbl_cliente on tbl_contrato.codigo_cliente = tbl_cliente.id
					WHERE tbl_contrato.id = $row_rs_historico[id_contrato]";
					$rs_contrato = mysql_query($query_rs_contrato, $conexao) or die(mysql_error());
					$row_rs_contrato = mysql_fetch_assoc($rs_contrato);
					$totalRows_rs_contrato = mysql_num_rows($rs_contrato);
				 
				 
				 	
								
				?>
              <tr>
                <td><?php echo $row_rs_historico['id'];?></td>
                <td><?php echo $row_rs_historico['nome'];?> - Tamanho <?php echo $row_rs_historico['numeracao'];?></td>
				<td><?php echo $row_rs_contrato['nome'];?></td>
                

                <td><?php echo formataData($row_rs_historico['data_saida']);?></td>
                <td><?php echo formataData($row_rs_historico['data_retorno'])?></td>
				<td width="31"><?php echo $row_rs_contrato['id'];?></td>
               	 
              </tr>
            <?php }while($row_rs_historico = mysql_fetch_assoc($rs_historico));
			}
			?>
              
            </tbody>
          </table>
          <?php } else { ?>
          <div align="center" style="font-size:15px;">Nenhum registro encontrado.</div>
          <?php } ?>
        </div>
        <!--widgetcontent-<?php
mysql_free_result($rs_historico);
?>->
            </div><!--widget-->
 <?php include_once('footer.php');?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>		  
<!--<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>-->
<!--<script type="text/javascript" src="js/jquery-migrate-1.1.1.min.js"></script>-->
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>  		  
<!--<script type="text/javascript" src="js/jquery-ui-1.9.2.min.js"></script>-->
<!--
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
-->
<!--<script type="text/javascript" src="js/jquery.cookie.js"></script>-->
<!--
<script type="text/javascript" src="js/modernizr.min.js"></script>
<script type="text/javascript" src="js/custom.js"></script>
<script type="text/javascript" src="js/forms.js"></script>
-->
<!--<script type="text/javascript" src="jquery.js"></script>-->
<!--<script type="text/javascript" src="load.js"></script>-->

		  
<script>
	$(function() {
	  <?php mysql_select_db($database_conexao, $conexao);
			$query_rs_busca_produto = "SELECT * FROM tbl_produto GROUP BY nome ORDER BY nome ASC";
			$rs_busca_produto = mysql_query($query_rs_busca_produto, $conexao) or die(mysql_error());
			$row_rs_busca_produto = mysql_fetch_assoc($rs_busca_produto);
			$totalRows_rs_busca_produto = mysql_num_rows($rs_busca_produto);
		?>	
	  var buscaNome = <?php  $array = array(); 
				               do{
					              $array[] = $row_rs_busca_produto['nome'];
					   
				               }while($row_rs_busca_produto = mysql_fetch_assoc($rs_busca_produto));
				               echo json_encode($array);
				        ?>
       
	  $("#id_produto" ).autocomplete({
		source: buscaNome
	  });
	});
</script>		  