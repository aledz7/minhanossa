<?php 
include('restrito.php');
include('Connections/conexao.php');
include('funcoes.php');
session_start();


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

mysql_select_db($database_conexao, $conexao);
$query_rs_editar_cliente = "SELECT * FROM tbl_cliente ORDER BY nome ASC";
$rs_editar_cliente = mysql_query($query_rs_editar_cliente, $conexao) or die(mysql_error());
$row_rs_editar_cliente = mysql_fetch_assoc($rs_editar_cliente);
$totalRows_rs_editar_cliente = mysql_num_rows($rs_editar_cliente);


$editFormAction = $_SERVER['PHP_SELF'];
if(isset($_SERVER['QUERY_STRING'])) {
	$editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "formEditcontrato")) {
	
	$updateSQL = sprintf("UPDATE tbl_contrato SET loja=%s, vendedor=%s, data_evento=%s, codigo_cliente=%s, nome_cliente=%s, tipo_contrato=%s, comentario=%s WHERE id=%s",
                       GetSQLValueString($_POST['loja'], "text"),
                       GetSQLValueString($_POST['vendedor'], "text"),
                       GetSQLValueString($_POST['data_evento'], "text"),
                       GetSQLValueString($_POST['codigo_cliente'], "text"),
                       GetSQLValueString($_POST['nome_cliente'], "text"),
					   GetSQLValueString($_POST['tipo_contrato'], "text"),
					   GetSQLValueString($_POST['comentario'], "text"),
					   GetSQLValueString($_POST['id'], "int"));
	mysql_select_db($database_conexao, $conexao);
	$Result1 = mysql_query($updateSQL, $conexao) or die(mysql_error());
	$idConteudo = mysql_insert_id();
		
		
	//// ITENS
	$deleteSQL = sprintf("DELETE FROM tbl_item WHERE id_contrato=%s",GetSQLValueString($_POST['id'], "int"));
	mysql_select_db($database_conexao, $conexao);
	$Result1 = mysql_query($deleteSQL, $conexao) or die(mysql_error());	
		
	for($i = 0 ; $i < count($_POST[nome_produto]);$i++){
		$insertSQL = sprintf("INSERT INTO tbl_item (nome_produto, quantidade_produto, valor_unitario_produto, desconto_produto, valor_total_produto, id_contrato, data_prova, data_retirada, data_devolucao, retirado_em, devolvido_em, busto, cintura, quadril, corpo, saia, paleto, comprimento, manga, camisa, colete, tamanho, colarinho, calca, barra, cintura_homem, sapato, comentario_item, id_cliente) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['nome_produto'][$i], "text"),
                       GetSQLValueString($_POST['quantidade_produto'][$i], "text"),
                       GetSQLValueString(valorCalculavel($_POST['valor_unitario_produto'][$i]), "text"),
                       GetSQLValueString($_POST['desconto_produto'][$i], "text"),
                       GetSQLValueString(valorCalculavel($_POST['valor_total_produto'][$i]), "text"),
					   GetSQLValueString($_POST['id'], "int"),
					   GetSQLValueString($_POST['data_prova'][$i], "text"),
					   GetSQLValueString($_POST['data_retirada'][$i], "text"),
					   GetSQLValueString($_POST['data_devolucao'][$i], "text"),
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
	}
	
	//// PAGAMENTO
	$deleteSQL = sprintf("DELETE FROM tbl_pagamento WHERE id_contrato=%s",GetSQLValueString($_POST['id'], "int"));
	mysql_select_db($database_conexao, $conexao);
	$Result1 = mysql_query($deleteSQL, $conexao) or die(mysql_error());	
	
	$deleteSQL = sprintf("DELETE FROM tbl_contas WHERE id_contrato=%s",GetSQLValueString($_POST['id'], "int"));
	mysql_select_db($database_conexao, $conexao);
	$Result1 = mysql_query($deleteSQL, $conexao) or die(mysql_error());	
		
	for($o = 0 ; $o < count($_POST[valor_pagamento]);$o++){			
		$insertSQL = sprintf("INSERT INTO tbl_pagamento (data_pagamento, forma_pagamento, parcelas, valor_pagamento, id_contrato, id_cliente) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['data_pagamento'][$o], "text"),
                       GetSQLValueString($_POST['forma_pagamento'][$o], "text"),
                       GetSQLValueString($_POST['parcela_pagamento'][$o], "text"),
                       GetSQLValueString(valorCalculavel($_POST['valor_pagamento'][$o]), "text"),
                       GetSQLValueString($_POST['id'], "int"),
					   GetSQLValueString($_POST['codigo_cliente'], "text")); 
		mysql_select_db($database_conexao, $conexao);
		$Result1 = mysql_query($insertSQL, $conexao) or die(mysql_error());
		$idPagamento = mysql_insert_id();
		
		$_POST['id_contrato'] = $_POST['id'];
		$_POST['tipo'] = 'R';
		$_POST['id_pagamento_contrato'] = $idPagamento;
		$_POST['valor_total'] = $_POST['valor_pagamento'][$o];
		$_POST['data_emissao'] = date('Y-m-d');
		$_POST['data_vencimento'] = $_POST['data_pagamento'][$o];
		include('add-conta-inc.php');
	}

	echo "	<script>
			window.location='contrato_cadastro.php';
			</script>";
			exit;
}

$colname_rs_contrato = "-1";
if(isset($_GET['id'])) {
	$colname_rs_contrato = $_GET['id'];
}
mysql_select_db($database_conexao, $conexao);
$query_rs_contrato = sprintf("SELECT * FROM tbl_contrato WHERE id = %s", GetSQLValueString($colname_rs_contrato, "int"));
$rs_contrato = mysql_query($query_rs_contrato, $conexao) or die(mysql_error());
$row_rs_contrato = mysql_fetch_assoc($rs_contrato);
$totalRows_rs_contrato = mysql_num_rows($rs_contrato);
?>
<!DOCTYPE html>
<html>
<head>

<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Editar Contrato</title>

<link rel="stylesheet" href="css/style.default.css" type="text/css" />
<link rel="stylesheet" href="css/bootstrap-fileupload.min.css" type="text/css" />
<link rel="stylesheet" href="css/bootstrap-timepicker.min.css" type="text/css" />
<link rel="stylesheet" href="prettify/prettify.css" type="text/css" />

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
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript" src="load.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
<script type="text/javascript" src="js/elements.js"></script>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript">
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
</script>
</head>

<body>
<?php //include_once('head.php');?>

<div class="mainwrapper">
    
<?php include_once('header.php');?>
    
<?php include_once('inc_coluna.php');?>
    
    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="."><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li><a href="contrato_cadastro.php">Contrato</a> <span class="separator"></span></li>
            <li>Editar Contrato</li>
        </ul>
        <div class="maincontent">
            <div class="maincontentinner">
            
            <div class="widget">
            <h4 class="widgettitle"><span class="iconfa-edit"></span>Contrato</h4>
            <div class="widgetcontent">
           
           
               <form class="stdform" action="" method="post" name="formEditcontrato" id="formEditcontrato" />
                    	
                        <div class="row">
                            <div class="col-md-12">
                            	<div class="col-md-2">
                                    Código<br>
                                    <div class="input-prepend">
                                        <input type="text" name="id" class="input-small" placeholder="Código" disabled  value="<?php echo $row_rs_contrato['id']?>"/>
                                		<span class="add-on"><i class="icon-qrcode"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    Data Contrato<br>
                                    <div class="input-prepend">
                                    	<input type="datetime" name="data_contrato" class="input-medium" readonly value="<?php echo formataData($row_rs_contrato['data_contrato']).' às '.substr($row_rs_contrato['data_contrato'],11)?>"/>
                                		<span class="add-on"><i class="icon-calendar"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                     Loja<br>
                                    <div class="input-prepend">
                                    	<select name="loja" class="uniformselect">
                <option />              
                Selecione
                 <?php do{?>                   
                <option value="<?php echo $row_rs_loja['id'];?>" <?php if($row_rs_contrato['loja'] == $row_rs_loja['id']){ echo "selected";}?>  />              
                <?php echo $row_rs_loja['nome'];?>
                 <?php }while($row_rs_loja = mysql_fetch_assoc($rs_loja));?>
                    </select>
                                        
                                		
                                    </div>
                                </div>
                                
                                <div class="col-md-2">
                                    Vendedor<br>
                                    <div class="input-prepend">
                                    	
                                         <select name="vendedor" class="uniformselect">
                <option />              
                Selecione
                 <?php do{?>                   
                <option value="<?php echo $row_rs_vendedor['id'];?>" <?php if($row_rs_contrato['vendedor'] == $row_rs_vendedor['id']){ echo "selected";}?> />              
                <?php echo $row_rs_vendedor['nome'];?>
                 <?php }while($row_rs_vendedor = mysql_fetch_assoc($rs_vendedor));?>
                    </select>
                                        
                                	
                                    </div>
                                </div>
                            
                            </div>
                        </div>
                        <div class="row" style="margin-top:7px; margin-bottom:7px;">
                            <div class="col-md-12">
                            	<div class="col-md-3">
                                    Data do Evento<br>
                                    <div class="input-prepend">
                                    	<input type="date" name="data_evento" class="input-medium" placeholder="Data do Evento" value="<?php echo $row_rs_contrato['data_evento']?>" />
                                		<span class="add-on"><i class="icon-calendar"></i></span>
                                    </div>
                                </div>
                                
                                <div class="col-md-5">
                                    Nome do Cliente<br>
                                    <div class="input-prepend">
                                    <select name="codigo_cliente" class="uniformselect" style="height:32px; width:100%">
                <option />              
                Selecione o Cliente
                 <?php do{?>                   
                <option value="<?php echo $row_rs_editar_cliente['id'];?>" <?php if($row_rs_contrato['codigo_cliente'] == $row_rs_editar_cliente['id']){ echo "selected";}?> />              
                <?php echo $row_rs_editar_cliente['nome'];?>
                 <?php }while($row_rs_editar_cliente = mysql_fetch_assoc($rs_editar_cliente));?>
                    </select>
                                    	
                                		<span class="add-on"><i class="icon-user"></i></span>
                                    </div>
                                </div>
                                
                                <div class="col-md-2">
                                    Tipo do contrato<br>
                                    <div class="input-prepend">
                                         
                                    	<select name="tipo_contrato" class="uniformselect">
                <option />              
                Selecione
                <option value="1" <?php if($row_rs_contrato['tipo_contrato'] == 1){ echo "selected";}?>/>Noiva
                <option value="2" <?php if($row_rs_contrato['tipo_contrato'] == 2){ echo "selected";}?>/>Noivo
                <option value="3" <?php if($row_rs_contrato['tipo_contrato'] == 3){ echo "selected";}?>/>Debutante
                <option value="4" <?php if($row_rs_contrato['tipo_contrato'] == 4){ echo "selected";}?>/>Convidado
                
                    </select>
                                    </div>
                                </div>
                            
                            </div>
                        </div>
                        
                      
                        
                        <div class="row">
                            <div class="col-md-12">
                            	
                               
                                    Comentário<br>
                                    <div class="input-prepend">
                                    	<textarea name="comentario" rows="5" class="span5" placeholder="Informações importantes sobre o rs_contrato" style="width:1018px;"><?php echo $row_rs_contrato['comentario']?></textarea>
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
                                    QTD. de Itens:<br>
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
                            <div id="janela_Itens">
                            	<?php include_once'itens.php';?>
                            </div>
                                
                                </div>
                                </div>
                                
                                <br>
                        <div class="row">
                            <div class="col-md-12">
                            	<h3>Forma de Pagamento</h3>
                            </div>
                        </div>
                                
                                 <div class="row">
                            <div class="col-md-12">
                            	<div class="col-md-2">
                                    QTD. de Pagamentos:<br>
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
                            <div id="janela_Pagamento">
                            	<?php include_once'pagamento.php';?>
                            </div>
                                
                                </div>
                                </div>
                                
                                 
                              
                        
					<div class="row" style="margin-top:10px;">
                      	<div class="col-md-12" align="right">
                        	 <a href="javascript:;" onClick="document.getElementById('formEditcontrato').submit();" class="btn btn-mini btn-success"> <i class="iconfa-ok"></i>&nbsp; Salvar</a> 
                             
                             <a href="javascript:;" class="btn btn-mini btn-info" onClick="MM_openBrWindow('imprimir-contrato.php?id=<?=$_GET['id'];?>','imprimirContrato','toolbar=yes,status=yes,scrollbars=yes,width=800,height=600')"> <i class="iconfa-ok"></i>&nbsp; Contrato</a> 
                             
                             <a href="contrato_cadastro.php" class="btn btn-danger btn-mini"> <i class="iconfa-remove"></i>&nbsp; Cancelar</a>
                        </div>
                      </div>
                   <input type="hidden" name="MM_update" id="MM_update" value="formEditcontrato">
                   <input type="hidden" name="id" id="id" value="<?php echo $row_rs_contrato['id']?>">
                </form>
           
            </div><!--widgetcontent-->
            </div><!--widget-->
            
       
            <?php include_once('footer.php');?>