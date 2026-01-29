<?php 
include('restrito.php');
include('Connections/conexao.php');
include('funcoes.php');

session_start();

mysql_select_db($database_conexao, $conexao);
$query_rs_cliente = "SELECT * FROM tbl_cliente ORDER BY nome ASC";
$rs_cliente = mysql_query($query_rs_cliente, $conexao) or die(mysql_error());
$row_rs_cliente = mysql_fetch_assoc($rs_cliente);
$totalRows_rs_cliente = mysql_num_rows($rs_cliente);

mysql_select_db($database_conexao, $conexao);
$query_rs_reserva = "SELECT tbl_lista_espera.*,  tbl_produto.nome as nomeProduto FROM tbl_lista_espera left join tbl_produto on tbl_lista_espera.id_produto = tbl_produto.id where tbl_lista_espera.id = '{$_GET['id']}'";
$rs_reserva = mysql_query($query_rs_reserva, $conexao) or die(mysql_error());
$row_rs_reserva = mysql_fetch_assoc($rs_reserva);
$totalRows_rs_reserva = mysql_num_rows($rs_reserva);

/*mysql_select_db($database_conexao, $conexao);
$query_rs_reserva = "SELECT * FROM tbl_lista_espera where id = '{$_GET['id']}' ORDER BY nome ASC";
$rs_reserva = mysql_query($query_rs_reserva, $conexao) or die(mysql_error());
$row_rs_reserva = mysql_fetch_assoc($rs_reserva);
$totalRows_rs_reserva = mysql_num_rows($rs_reserva);*/

//print_r($row_rs_reserva);  
//echo $query_rs_reserva;

/*if((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formEditarCLiente")) {	
	  $insertSQL = sprintf("INSERT INTO tbl_lista_espera (id_produto, id_cliente, data) VALUES (%s, %s, %s)",
            GetSQLValueString($_POST['id_produto'], "text"),
            GetSQLValueString($_POST['id_cliente'], "text"),
            GetSQLValueString($_POST['data'], "text"));
  	mysql_select_db($database_conexao, $conexao);
  	$Result1 = mysql_query($insertSQL, $conexao) or die(mysql_error());
  	$idConteudo = mysql_insert_id();
	
 ///HISTORIC PRODUCT
		
  	echo "<script>
  			       window.location='lista-espera.php';
  			  </script>";
  	exit;
  }*/

if((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formEditarCLiente")) {	
	
	$updateSQL = sprintf("UPDATE tbl_lista_espera SET id_cat_produto=%s, id_vendedor=%s, id_loja=%s, id_produto=%s, servico=%s, valor=%s, data_retirada=%s, data_devolucao=%s, data_evento=%s WHERE id=%s",
                       GetSQLValueString($_POST['id_cat_produto'], "text"),
                       GetSQLValueString($_POST['id_vendedor'], "text"),
                       GetSQLValueString($_POST['id_loja'], "text"),
                       GetSQLValueString($_POST['id_produto'], "text"),
                       GetSQLValueString($_POST['servico'], "text"),
                       GetSQLValueString(valorCalculavel($_POST['valor']), "text"),
                       GetSQLValueString($_POST['data_retirada'], "text"),
                       GetSQLValueString($_POST['data_devolucao'], "text"),
                       GetSQLValueString($_POST['data_evento'], "text"),
                       GetSQLValueString($_POST['id'], "int")); 
	mysql_select_db($database_conexao, $conexao);
	$Result1 = mysql_query($updateSQL, $conexao) or die(mysql_error());
	
	//// ITENS
	$deleteSQL = sprintf("DELETE FROM tbl_item WHERE id_lavanderia=%s",GetSQLValueString($_POST['id'], "int"));
	mysql_select_db($database_conexao, $conexao);
	$Result1 = mysql_query($deleteSQL, $conexao) or die(mysql_error());
	
	$deleteSQL = sprintf("DELETE FROM tbl_historico_produto WHERE id_lavanderia=%s",GetSQLValueString($_POST['id'], "int"));
	mysql_select_db($database_conexao, $conexao);
	$Result1 = mysql_query($deleteSQL, $conexao) or die(mysql_error());	
		
	for($i = 0 ; $i < count($_POST[nome_produto]);$i++){
		
		
		$insertSQL = sprintf("INSERT INTO tbl_item (nome_produto, quantidade_produto, valor_unitario_produto, desconto_produto, valor_total_produto, id_lavanderia, data_prova, data_retirada, data_devolucao, retirado_em, devolvido_em, busto, cintura, quadril, corpo, saia, paleto, comprimento, manga, camisa, colete, tamanho, colarinho, calca, barra, cintura_homem, sapato, comentario_item, id_cliente, id_reserva) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['nome_produto'][$i], "text"),
                       GetSQLValueString($_POST['quantidade_produto'][$i], "text"),
                       GetSQLValueString(valorCalculavel($_POST['valor_unitario_produto'][$i]), "text"),
                       GetSQLValueString($_POST['desconto_produto'][$i], "text"),
                       GetSQLValueString(valorCalculavel($_POST['valor_total_produto'][$i]), "text"),
					   GetSQLValueString($_POST['id'], "int"),
					   GetSQLValueString($_POST['data_prova'][$i], "text"),
					   GetSQLValueString($_POST['data_retirada'], "text"),
					   GetSQLValueString($_POST['data_devolucao'], "text"),
					   GetSQLValueString($_POST['retirado_em'][$i], "text"),
					   GetSQLValueString($_POST['devolvido_em'][$i], "text"),
					   GetSQLValueString($_POST['busto'][$i], "text"),
					   GetSQLValueString($_POST['cintura'][$i], "text"),
					   GetSQLValueString($_POST['quadril'][$i], "text"),
					   GetSQLValueString($_POST['corpo'][$i], "text"),
					   GetSQLValueString($_POST['saia'][$i], "text"),
					   GetSQLValueString($_POST['paleto'][$i], "text"),
					   GetSQLValueString($_POST['comprimento'][$i], "text"),
					   GetSQLValueString($_POST['manga'][$i], "text"),
					   GetSQLValueString($_POST['camisa'][$i], "text"),
					   GetSQLValueString($_POST['colete'][$i], "text"),
					   GetSQLValueString($_POST['tamanho'][$i], "text"),
					   GetSQLValueString($_POST['colarinho'][$i], "text"),
					   GetSQLValueString($_POST['calca'][$i], "text"),
					   GetSQLValueString($_POST['barra'][$i], "text"),
					   GetSQLValueString($_POST['cintura_homem'][$i], "text"),
					   GetSQLValueString($_POST['sapato'][$i], "text"),
					   GetSQLValueString($_POST['comentario_item'][$i], "text"),
					   GetSQLValueString($_POST['codigo_cliente'], "text"));
		mysql_select_db($database_conexao, $conexao);
		$Result1 = mysql_query($insertSQL, $conexao) or die(mysql_error());
		
		///HISTORIC PRODUCT
		$insertSQL = sprintf("INSERT INTO tbl_historico_produto (id_produto, condicao, data_saida, data_retorno, id_lavanderia, id_reserva) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['nome_produto'][$i], "text"),
                       GetSQLValueString('C', "text"),
                       GetSQLValueString($_POST['data_retirada'], "text"),
					   GetSQLValueString($_POST['data_devolucao'], "text"),
					   GetSQLValueString($_POST['id_lavanderia'], "int"),
					   GetSQLValueString($idConteudo, "int"));
		mysql_select_db($database_conexao, $conexao);
		$Result1 = mysql_query($insertSQL, $conexao) or die(mysql_error());
	}

    /// HISTORIC PRODUCT
	$updateSQL = sprintf("UPDATE tbl_historico_produto SET id_produto=%s, condicao=%s, data_saida=%s, data_retorno=%s WHERE id_lavanderia=%s, id_reserva=%s",
                       GetSQLValueString($_POST['id_produto'], "text"),
                       GetSQLValueString('L', "text"),
                       GetSQLValueString($_POST['data_retirada'], "text"),
                       GetSQLValueString($_POST['data_devolucao'], "text"),
                       GetSQLValueString($_POST['id_lavanderia'], "int"),
                       GetSQLValueString($_POST['id'], "int")); 
	mysql_select_db($database_conexao, $conexao);
	$Result1 = mysql_query($updateSQL, $conexao) or die(mysql_error());
	
	marcaHistoricoAlteracao("Modificou a reserva Código: {$_POST['id']}.");
	
	echo "	<script>
			window.location='lista-espera.php';
			</script>";
			exit;
}

mysql_select_db($database_conexao, $conexao);
$query_rs_vendedores = "SELECT * FROM tbl_admin ORDER BY nome ASC";
$rs_vendedores = mysql_query($query_rs_vendedores, $conexao) or die(mysql_error());
$row_rs_vendedores = mysql_fetch_assoc($rs_vendedores);
$totalRows_rs_vendedores = mysql_num_rows($rs_vendedores);

mysql_select_db($database_conexao, $conexao);
$query_rs_tipo_lavagem = "SELECT * FROM tbl_composicoes ORDER BY nome ASC";
$rs_tipo_lavagem = mysql_query($query_rs_tipo_lavagem, $conexao) or die(mysql_error());
$row_rs_tipo_lavagem = mysql_fetch_assoc($rs_tipo_lavagem);
$totalRows_rs_tipo_lavagem = mysql_num_rows($rs_tipo_lavagem);

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>

<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Lista Espera > Editar</title>

<link rel="stylesheet" href="css/style.default.css" type="text/css" />
<link rel="stylesheet" href="css/bootstrap-fileupload.min.css" type="text/css" />
<link rel="stylesheet" href="css/bootstrap-timepicker.min.css" type="text/css" />
<style type="text/css">
body,td,th {
	font-family: RobotoRegular, "Helvetica Neue", Helvetica, sans-serif;
}
</style>
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
<script type="text/javascript" src="js/custom.js"></script>
<script type="text/javascript" src="js/forms.js"></script>


<meta charset="UTF-8" /></head>

<body>
<?php //include_once('head.php');?>

<div class="mainwrapper">
    
<?php include_once('header.php');?>
    
<?php include_once('inc_coluna.php');?>
    
    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="."><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li><a href="">Lista Espera</a> <span class="separator"></span></li>
            <li>Novo</li>
        </ul>
        <div class="maincontent">
            <div class="maincontentinner">
            
            <div class="widget">
            <h4 class="widgettitle"><span class="iconfa-edit"></span>Nova Espera</h4>
            <div class="widgetcontent">
           
           
               <form class="stdform" action="" method="post" name="formEditarCLiente" id="formEditarCLiente" />
                    	
                        <div class="row">
                            <div class="col-md-12">
                            
                            	<div class="col-md-3">
                                    Cliente<br>
                                    <div class="input-prepend">
                                        <select name="id_cliente" style="height:32px;" >
                       					<?php do{?>
                            				<option <?php if( $row_rs_cliente['id']==$row_rs_reserva['id_cliente']){ echo 'selected';}?> value="<?php echo $row_rs_cliente['id'];?>" /><?php echo $row_rs_cliente['nome'];?>
                       					<?php }while($row_rs_cliente = mysql_fetch_assoc($rs_cliente));?>         
                       					</select>
                                		<span class="add-on"><i class="icon-edit"></i></span>
                                    </div>
                                </div>                                
                                
                               <!-- <div class="col-md-2">
                                    Data do Evento<br>
                                    <div class="input-prepend">
                                      <input type="date" name="data_evento" style="width:130px;" class="input-xlarge" />
                                    <span class="add-on"><i class="icon-edit"></i></span>
                                    </div>
                                </div>-->
                                
                                <div class="col-md-2">
                                    Data<br>
                                    <div class="input-prepend">
                                    	<input type="date" name="data" style="width:130px;" class="input-xlarge" value="<?php echo $row_rs_reserva['data']?>" />
                                		<span class="add-on"><i class="icon-edit"></i></span>
                                    </div>
                                </div>
                          
                            
                            </div>
                        </div>
                          
                           <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-2">
                                        Adicionar qtd. de Itens:<br>
                                        <div class="input-prepend">
                                            <input name="qtdItens" type="text" class="input-small" id="qtdItens" />
                                        </div>
                                    </div>
                                    <div class="col-md-2" style="margin-left:10px;">
                                       <br>
                                        <div class="input-prepend">
                                            <a href="javascript:;" onClick="AtualizaJanela('item-reserva.php?qtdItens=' + document.getElementById('qtdItens').value, 'Itens');" class="btn btn-mini btn-success"  >Mostrar Op&ccedil;&otilde;es</a>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                                
                             <div class="row">
								<div class="col-md-12">
									<div id="janela_Itens">
										<?php include'item-reserva.php';?>
									</div>
								</div>
				            </div>
                       
                        
                          <div class="row" style="margin-right:12px;">
                            <div class="col-md-12" align="right">
                                 <a href="javascript:;" onClick="document.getElementById('formEditarCLiente').submit();" class="btn btn-mini btn-success"> <i class="iconfa-ok"></i>&nbsp; Salvar</a>
                                 <a href="lista-espera.php" class="btn btn-danger btn-mini"> <i class="iconfa-remove"></i>&nbsp; Cancelar</a>
                            </div>
                          </div>
                   <input type="hidden" name="MM_insert" id="MM_insert" value="formEditarCLiente">
                   <input type="hidden" name="id_loja" value="2">
                </form>
           
            </div><!--widgetcontent-->
            </div><!--widget-->
            
       
            <?php include_once('footer.php');?>