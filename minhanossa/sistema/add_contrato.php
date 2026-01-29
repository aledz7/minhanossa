<?php
session_start();
include('restrito.php');
include('Connections/conexao.php');
include('funcoes.php');

mysql_select_db($database_conexao, $conexao);
$query_rs_loja = "SELECT * FROM tbl_loja ORDER BY nome ASC";
$rs_loja = mysql_query($query_rs_loja, $conexao) or die(mysql_error());
$row_rs_loja = mysql_fetch_assoc($rs_loja);
$totalRows_rs_loja = mysql_num_rows($rs_loja);

mysql_select_db($database_conexao, $conexao);
$query_rs_vendedor = "SELECT * FROM tbl_admin ORDER BY nome ASC";
$rs_vendedor = mysql_query($query_rs_vendedor, $conexao) or die(mysql_error());
$row_rs_vendedor = mysql_fetch_assoc($rs_vendedor);
$totalRows_rs_vendedor = mysql_num_rows($rs_vendedor);

/*mysql_select_db($database_conexao, $conexao);
$query_rs_cliente = "SELECT * FROM tbl_cliente where id = '{$_GET['id_cliente']}'";
$rs_cliente = mysql_query($query_rs_cliente, $conexao) or die(mysql_error());
$row_rs_cliente = mysql_fetch_assoc($rs_cliente);
$totalRows_rs_cliente = mysql_num_rows($rs_cliente);
*/
$editFormAction = $_SERVER['PHP_SELF'];
if(isset($_SERVER['QUERY_STRING'])) {
	$editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formAddContrato")) {
	///AQUI SE FAZ A SOMA DE PONTOS DOS PRODUTOS LANÇADOS
	for($k = 0 ; $k < count($_POST[nome_produto]);$k++){
		$somarPontos += $_POST['pontuacao'][$k];
		$somarPecas += $_POST['qtdItens'][$k];
	}
	//echo $_POST['somaPontos'];
	//exit;
	mysql_select_db($database_conexao, $conexao);
	$query_rs_pega_pontos = "SELECT * FROM tbl_cliente where id = '".$_POST['codigo_cliente']."'";
	$rs_pega_pontos = mysql_query($query_rs_pega_pontos, $conexao) or die(mysql_error());
	$row_rs_pega_pontos = mysql_fetch_assoc($rs_pega_pontos);
	$totalRows_rs_pega_pontos = mysql_num_rows($rs_pega_pontos);
	
	/// subtrai pontos
	mysql_select_db($database_conexao, $conexao);
	$query_rs_planos = "SELECT * FROM tbl_plano where id = '{$_POST['tipo_contrato']}'";
	$rs_planos = mysql_query($query_rs_planos, $conexao) or die(mysql_error());
	$row_rs_planos = mysql_fetch_assoc($rs_planos);
	$totalRows_rs_planos = mysql_num_rows($rs_planos);
	
	/// se for por pontos
	if($row_rs_planos['pontuacao_mensal'] > 0) {
		if($row_rs_pega_pontos['pontos'] < $somarPontos){
			echo "	<script>
					alert('Seus {$row_rs_pega_pontos['pontos']} pontos sao insufucientes para o aluguel desses itens.');
					history.back();
					</script>";
					exit;
		} else {
			///SUBTRAI OS PONTOS QUE O CLIENTE TEM E GRAVA A NOVA QUANTIDADE
			$valorPontos = $row_rs_pega_pontos['pontos'] - $somarPontos;
			$qtsPecas = $row_rs_pega_pontos['quantidade_pecas'] - $somarPecas;
			
			$updateSQL = sprintf("UPDATE tbl_cliente SET pontos=%s, quantidade_pecas=%s WHERE id=%s",
						   GetSQLValueString($valorPontos, "text"),
						   GetSQLValueString($qtsPecas, "text"),
						   GetSQLValueString($_POST['codigo_cliente'], "int"));
			mysql_select_db($database_conexao, $conexao);
			$Result1 = mysql_query($updateSQL, $conexao) or die(mysql_error());
		}
	}
	
	/// subtrai num peças
	
	//exit;
	
	
	
	for($u = 0 ; $u < count($_POST[nome_produto]);$u++){
	  
	  mysql_select_db($database_conexao, $conexao);
	  $query_rs_cliente = "SELECT * FROM tbl_item where nome_produto = '{$_POST['nome_produto'][$u]}' and data_retirada >={$_POST['data_evento']} and data_devolucao <= {$_POST['data_devolucao']} ";
	  $rs_cliente = mysql_query($query_rs_cliente, $conexao) or die(mysql_error());
	  $row_rs_cliente = mysql_fetch_assoc($rs_cliente);
	  $totalRows_rs_cliente = mysql_num_rows($rs_cliente);
		
		//ANTES O SQL ESTAVA DA SEGUINTE MANEIRA SE DER ERRO VOLTAR		
		//data_retirada >={$_POST['data_evento'][$u]} and data_devolucao <= {$_POST['data_devolucao'][$u]
		//FIM DO ANTIGO SQL
		
	  /*and data_devolucao <= {$_POST['data_devolucao']}*/
	  
	  if($totalRows_rs_cliente > 0){
	     echo "<script> alert('Produto Indisponível no estoque');
		 		window.location='add_contrato.php';
		 </script>";
		 exit;
	  }
	}
	
	$insertSQL = sprintf("INSERT INTO tbl_contrato (data_contrato, loja, vendedor, data_evento, data_devolucao, codigo_cliente, nome_cliente, tipo_contrato, comentario) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
					   GetSQLValueString(date('Y-m-d H:i:s'), "text"),
                       GetSQLValueString($_POST['loja'], "text"),
                       GetSQLValueString($_POST['vendedor'], "text"),
                       GetSQLValueString($_POST['data_evento'], "text"),
                       GetSQLValueString($_POST['data_devolucao'], "text"),
                       GetSQLValueString($_POST['codigo_cliente'], "text"),
                       GetSQLValueString($_POST['nome_cliente'], "text"),
					   GetSQLValueString($_POST['tipo_contrato'], "text"),
					   GetSQLValueString($_POST['comentario'], "text"));
	mysql_select_db($database_conexao, $conexao);
	$Result1 = mysql_query($insertSQL, $conexao) or die(mysql_error());
	$idConteudo = mysql_insert_id();
	
	for($i = 0 ; $i < count($_POST[nome_produto]);$i++){
		$insertSQL = sprintf("INSERT INTO tbl_item (nome_produto, quantidade_produto, valor_unitario_produto, desconto_produto, valor_total_produto, id_contrato, data_prova, data_retirada, data_devolucao, retirado_em, devolvido_em, busto, cintura, quadril, corpo, saia, paleto, comprimento, manga, camisa, colete, tamanho, colarinho, calca, barra, cintura_homem, sapato, comentario_item, id_cor, id_cliente) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['nome_produto'][$i], "text"),
                       GetSQLValueString($_POST['quantidade_produto'][$i], "text"),
                       GetSQLValueString(valorCalculavel($_POST['valor_unitario_produto'][$i]), "text"),
                       GetSQLValueString($_POST['desconto_produto'][$i], "text"),
                       GetSQLValueString(valorCalculavel($_POST['valor_total_produto'][$i]), "text"),
					   GetSQLValueString($idConteudo, "int"),
					   GetSQLValueString($_POST['data_prova'][$i], "text"),
					   GetSQLValueString($_POST['data_evento'], "text"),
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
					   GetSQLValueString($_POST['id_cor'][$i], "text"),
					   GetSQLValueString($_POST['codigo_cliente'], "text"));
		mysql_select_db($database_conexao, $conexao);
		$Result1 = mysql_query($insertSQL, $conexao) or die(mysql_error());
		
		///HISTORIC PRODUCT
		$insertSQL = sprintf("INSERT INTO tbl_historico_produto (id_produto, condicao, data_saida, data_retorno, id_contrato) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['nome_produto'][$i], "text"),
                       GetSQLValueString('C', "text"),
                       GetSQLValueString($_POST['data_evento'], "text"),
					   GetSQLValueString($_POST['data_devolucao'], "text"),
					   GetSQLValueString($idConteudo, "int"));
		mysql_select_db($database_conexao, $conexao);
		$Result1 = mysql_query($insertSQL, $conexao) or die(mysql_error());
	}
	
	for($o = 0 ; $o < count($_POST[valor_pagamento]);$o++){
		$insertSQL = sprintf("INSERT INTO tbl_pagamento (data_pagamento, forma_pagamento, parcelas, valor_pagamento, id_contrato, id_cliente) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['data_pagamento'][$o], "text"),
                       GetSQLValueString($_POST['forma_pagamento'][$o], "text"),
                       GetSQLValueString($_POST['parcelas'][$o], "text"),
                       GetSQLValueString(valorCalculavel($_POST['valor_pagamento'][$o]), "text"),
                       GetSQLValueString($idConteudo, "int"),
					   GetSQLValueString($_POST['codigo_cliente'], "text"));
		mysql_select_db($database_conexao, $conexao);
		$Result1 = mysql_query($insertSQL, $conexao) or die(mysql_error());
		$idPagamento = mysql_insert_id();
		
		// Coloca no financeiro
		$_POST['id_contrato'] = $idConteudo;
		$_POST['tipo'] = 'R';
		$_POST['id_pagamento_contrato'] = $idPagamento;
		$_POST['valor_total'] = $_POST['valor_pagamento'][$o];
		$_POST['data_emissao'] = date('Y-m-d');
		$_POST['data_vencimento'] = $_POST['data_pagamento'][$o];
		include('add-conta-inc.php');
	}
	
	marcaHistoricoAlteracao("Incluiu o contrato: {$idConteudo}.");
	
	
	echo "	<script>
			window.location='contrato_cadastro.php';
			</script>";
			exit;
			
}

mysql_select_db($database_conexao, $conexao);
	$query_rs_planos = "SELECT * FROM tbl_plano ORDER BY nome ASC";
	$rs_planos = mysql_query($query_rs_planos, $conexao) or die(mysql_error());
	$row_rs_planos = mysql_fetch_assoc($rs_planos);
	$totalRows_rs_planos = mysql_num_rows($rs_planos);

mysql_select_db($database_conexao, $conexao);
$query_rs_cliente1 = "SELECT * FROM tbl_cliente ORDER BY nome ASC";
$rs_cliente1 = mysql_query($query_rs_cliente1, $conexao) or die(mysql_error());
$row_rs_cliente1 = mysql_fetch_assoc($rs_cliente1);
$totalRows_rs_cliente1 = mysql_num_rows($rs_cliente1);
?>
<!DOCTYPE html>
<html>
<head>

<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Adicionar Aluguel</title>

<link rel="stylesheet" href="css/style.default.css" type="text/css" />
<link rel="stylesheet" href="css/bootstrap-fileupload.min.css" type="text/css" />
<link rel="stylesheet" href="css/bootstrap-timepicker.min.css" type="text/css" />
<link rel="stylesheet" href="prettify/prettify.css" type="text/css" />

<script type="text/javascript" src="jquery.js"></script>

<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/jquery-migrate-1.1.1.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.9.2.min.js"></script>
<script type="text/javascript" src="prettify/prettify.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.jgrowl.js"></script>
<script type="text/javascript" src="js/jquery.alerts.js"></script>
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
<script type="text/javascript" src="js/elements.js"></script>
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript" src="load.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
<script src="js/number_format.js"></script>
<script src="js/outras-funcoes.js"></script>

<script type="text/javascript" src="load.js"></script>

<? include('dialog-jquery/inc-abre-janela.php');?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>

<body>
<?php //include_once('head.php');?>

<div class="mainwrapper">
    
<?php include_once('header.php');?>
    
<?php include_once('inc_coluna.php');?>
    
    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="."><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li><a href="contrato_cadastro.php">Aluguel</a> <span class="separator"></span></li>
            <li>Adicionar Aluguel</li>
        </ul>
        <div class="maincontent">
            <div class="maincontentinner">
            
            <div class="widget">
            <h4 class="widgettitle"><span class="iconfa-edit"></span>Novo Aluguel</h4>
            <div class="widgetcontent">
           
           
               <form class="stdform" action="" method="post" name="formAddContrato" id="formAddContrato" />
                    	
                        <div class="row">
                            <div class="col-md-12">
                            	<div class="col-md-3">
                                    C&oacute;digo<br>
                                    <div class="input-prepend">
                                        <input type="text" name="id" class="input-small" placeholder="C&oacute;digo" disabled />
                                		<span class="add-on"><i class="icon-qrcode"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    Data Cadastro<br>
                                    <div class="input-prepend">
                                    	<input type="datetime" name="data_contrato" class="input-medium" value="<?php echo date('d/m/Y H:i:s');?>" readonly/>
                                		<span class="add-on"><i class="icon-calendar"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                     Loja<br>
                                    <div class="input-prepend">
                                    	<select name="loja" class="uniformselect">
               
                 <?php do{?>                   
                <option value="<?php echo $row_rs_loja['id'];?>" />              
                <?php echo $row_rs_loja['nome'];?>
                 <?php }while($row_rs_loja = mysql_fetch_assoc($rs_loja));?>
                    </select>
                                        
                                		
                                    </div>
                                </div>
                                
                                <div class="col-md-2">
                                    Vendedor<br>
                                    <div class="input-prepend">
                                    	
                     <select name="vendedor" style="height:32px; width:184px;" onChange="this.value = <?=$_SESSION['dadosUser']['id'];?>" >
                       					<?php do{?>
                            				<option value="<?php echo $row_rs_vendedor['id'];?>" <?php if($row_rs_vendedor['id'] == $_SESSION['dadosUser']['id']) { echo 'selected'; } ?> /><?php echo $row_rs_vendedor['nome'];?>
                       					<?php }while($row_rs_vendedor = mysql_fetch_assoc($rs_vendedor));?>         
                       					</select>
                                        
                                	
                                    </div>
                                </div>
                            
                            </div>
                        </div>
                        
                          <div class="row" style="margin-top:7px; margin-bottom:7px;">
                            <div class="col-md-12">
                            	<div class="col-md-4">
                                     Cliente<br>
                                    <div class="input-prepend">
                                         
                  <select name="codigo_cliente" id="codigo_cliente" onChange="document.getElementById('envia').src='verifica-clientes.php?acao=altera_plano&id=' + this.value;" class="uniformselect" style="width: 100% !important;">
                             <option>Selecione</option>
                
                <?php do{?>
                <option value="<?php echo $row_rs_cliente1['id']?>"><?php echo ($row_rs_cliente1['nome'])?></option>
                <?php }while($row_rs_cliente1 = mysql_fetch_assoc($rs_cliente1));?>
                
                    </select>
                                    </div>
                                    
<?php /*?><?php 
$_GET['label'] = $row_rs_cliente['nome'];
$_GET['idAtual'] = $_GET['id_cliente'];
buscaGenericad('codigo_cliente', 'id', '', 'Clientes', 'nome', "parent.document.getElementById('envia').src='busca-plano.php?id=[id]';", 'tbl_cliente', $concatCampos, $where);?><?php */?>
                                </div>
                                
                                <div class="col-md-2" style="padding-right: 0px;">
                                Prazo
                                <br>
                                <input name="prazo_cliente" disabled type="text" class="input-small" id="prazo_cliente">
                                </div>
                                
                            	<div class="col-md-3" style="padding-left: 0px;">
                                    Data de Retirada<br>
                                    <div class="input-prepend">
                                    	<input type="date" name="data_evento" id="data_retirada" class="input-medium" placeholder="Data de Retirada" value="<?php echo date('Y-m-d')?>" />
                                		<span class="add-on"><i class="icon-calendar"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    Data de Devolu&ccedil;&atilde;o<br>
                                    <div class="input-prepend">
                                    	<input type="date" name="data_devolucao" id="data_devolucao" class="input-medium" placeholder="Data de Devolucao" value="<?php echo date('Y-m-d')?>" />
                                		<span class="add-on"><i class="icon-calendar"></i></span>
                                    </div>
                                </div>
                                                              
                            </div>
                        </div>
                        
                            <div class="row" style="margin-top:7px; margin-bottom:7px;">
                            <div class="col-md-12">
                               <div class="col-md-5">
                                    Plano<br>
                                    <div class="input-prepend">
                                         
                                    	<select name="tipo_contrato" id="tipo_contrato" class="uniformselect" style="width: 100% !important;">
                <option />              
                Selecione
                <?php do{?>
                <option value="<?php echo $row_rs_planos['id'];?>" <?php if($row_rs_contrato['tipo_plano'] == $row_rs_planos['id']){ echo "selected";}?>/><?php echo ($row_rs_planos['nome']);?>
                <?php }while($row_rs_planos = mysql_fetch_assoc($rs_planos));?>
                
                    </select>
                                    </div>
                                </div>
                             
                            </div>
                        </div>
                 
                        
                        <div class="row">
                            <div class="col-md-12">
                            	
                               
                                    Coment&aacute;rio<br>
                                    <div class="input-prepend">
                                    	<textarea name="comentario" rows="5" class="span5" placeholder="Informa&ccedil;&otilde;es importantes sobre o contrato" style="width:1018px;"></textarea>
                                    </div>
                                
                                
                            
                            </div>
                        </div>
                        
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                            	<h3>Itens Adicionados</h3>
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
            <a href="javascript:;" onClick="AtualizaJanela('itens.php?qtdItens=' + document.getElementById('qtdItens').value, 'Itens');" class="btn btn-mini btn-success"  >Mostrar Op&ccedil;&otilde;es</a>
                                    </div>
                                </div>
                                
                                </div>
                                </div>
                                
                       <div class="row">
                            <div class="col-md-12">
                            <div id="janela_Itens"></div>
                                
                                </div>
                                </div>
                                <br>
                      <?php /*?>  <div class="row">
                            <div class="col-md-12">
                            	<h3>Forma de Pagamento</h3>
                            </div>
                        </div>
                                
                                
                                <div class="row">
                            <div class="col-md-12">
                            	<div class="col-md-2">
                                    QTD. de Pagamanto:<br>
                                    <div class="input-prepend">
                                    	<input name="qtdPago" type="text" class="input-small" id="qtdPago" />
                                    </div>
                                </div>
                                <div class="col-md-2" style="margin-left:10px;">
                                   <br>
                                    <div class="input-prepend">
            <a href="javascript:;" onClick="AtualizaJanela('pagamento.php?qtdPago=' + document.getElementById('qtdPago').value, 'Pagamento');" class="btn btn-mini btn-success"  >Mostrar Op&ccedil;&otilde;es</a>
                                    </div>
                                </div>
                                
                                </div>
                                </div>
                                
                       <div class="row">
                            <div class="col-md-12">
                            <div id="janela_Pagamento"></div>
                                
                                </div>
                                </div>
                                
                            
                              <?php */?>
                        
					<div class="row">
                      	<div class="col-md-12" align="right">
                        	 <a href="javascript:;" onClick="document.getElementById('formAddContrato').submit();" class="btn btn-mini btn-success"> <i class="iconfa-ok"></i>&nbsp; Salvar</a> 
                             <a href="contrato_cadastro.php" class="btn btn-danger btn-mini"> <i class="iconfa-remove"></i>&nbsp; Cancelar</a>
                        </div>
                      </div>
                   <input type="hidden" name="MM_insert" id="MM_insert" value="formAddContrato">
                </form>
           
            </div><!--widgetcontent-->
            </div><!--widget-->
            <iframe id="envia" name="envia" src="" style="width:0px;height:0px;border:0px;"></iframe>
       
<?php include_once('footer.php');?>