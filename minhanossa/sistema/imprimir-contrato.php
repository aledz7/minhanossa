<?php 
include('restrito.php');
include('Connections/conexao.php');
include('funcoes.php');
include('pagamento.php');

$colname_rs_contrato = "-1";
if(isset($_GET['id'])) {
	$colname_rs_contrato = $_GET['id'];
}
mysql_select_db($database_conexao, $conexao);
$query_rs_contrato = sprintf("
SELECT 
	tbl_contrato.*,
	tbl_loja.nome as nomeLoja,
	tbl_loja.telefone1 as telLoja,
	tbl_loja.razao_social,
	tbl_loja.cnpj,
	tbl_loja.logradouro as logradouroLoja,
	tbl_loja.numero as numeroLoja,
	dados_estados.uf as estadoLoja,
	dados_cidades.nome as cidadeLoja,
	tbl_cliente.nome as nomeCliente,
	tbl_cliente.cpf as cpfCliente,
	tbl_cliente.rg as rgCliente,
	tbl_cliente.endereco as enderecoCliente,
	tbl_cliente.numero as numeroCliente,
	estadoCliente.uf as estadoCliente,
	cidadeCliente.nome as cidadeCliente
FROM 
	tbl_contrato 
	left join tbl_loja on tbl_contrato.loja = tbl_loja.id
	left join dados_estados on tbl_loja.estado = dados_estados.id
	left join dados_cidades on tbl_loja.cidade = dados_cidades.id
	left join tbl_cliente on tbl_contrato.codigo_cliente = tbl_cliente.id
	left join dados_estados as estadoCliente on tbl_cliente.estado = estadoCliente.id
	left join dados_cidades as cidadeCliente on tbl_cliente.cidade = cidadeCliente.id
WHERE 
	tbl_contrato.id = %s", GetSQLValueString($colname_rs_contrato, "int"));
$rs_contrato = mysql_query($query_rs_contrato, $conexao) or die(mysql_error());
$row_rs_contrato = mysql_fetch_assoc($rs_contrato);
$totalRows_rs_contrato = mysql_num_rows($rs_contrato);


mysql_select_db($database_conexao, $conexao);
$query_rs_itens = "
SELECT 
	tbl_item.*,
	tbl_produto.nome as nomeProduto
FROM 
	tbl_item
	left join tbl_produto on tbl_item.nome_produto = tbl_produto.id
where id_contrato = '{$_GET['id']}'";
$rs_itens = mysql_query($query_rs_itens, $conexao) or die(mysql_error());
$row_rs_itens = mysql_fetch_assoc($rs_itens);
$totalRows_rs_itens = mysql_num_rows($rs_itens);



mysql_select_db($database_conexao, $conexao);
$query_rs_contratoClausula = "select * from clausula_contrato";
$rs_contratoClausula = mysql_query($query_rs_contratoClausula, $conexao) or die(mysql_error());
$row_rs_contratoClausula = mysql_fetch_assoc($rs_contratoClausula);
$totalRows_rs_contratoClausula = mysql_num_rows($rs_contratoClausula);



mysql_select_db($database_conexao, $conexao);
$query_rs_pagamentos = "SELECT * FROM tbl_pagamento where id_contrato = '{$_GET['id']}'";
$rs_pagamentos = mysql_query($query_rs_pagamentos, $conexao) or die(mysql_error());
//$row_rs_editar_pagamento = mysql_fetch_assoc($rs_editar_pagamento);
$totalRows_rs_pagamentos = mysql_num_rows($rs_pagamentos);

if($_GET['qtdPago'] == '') {
	$_GET['qtdPago'] = $totalRows_rs_editar_pagamento;
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Impressão de Contrato</title>
<link rel="stylesheet" type="text/css" href="css.css">
</head>

<body>
<table width="100%" border="0">
  <tbody>
    <tr>
      <td width="22%"><?php echo $row_rs_contrato['nomeLoja'];?></td>
      <td width="36%">Data do Contrato: <?php echo formataData($row_rs_contrato['data_contrato']);?> <?php echo substr($row_rs_contrato['data_contrato'],11,5);?></td>
      <td width="27%">Fone: <?php echo $row_rs_contrato['telLoja'];?></td>
      <td width="15%" align="right">Contrato nº.: <?php echo $_GET['id'];?></td>
    </tr>
  </tbody>
</table>
<div style="font-weight:bold; text-align:center; margin:8px;">CONTRATO DE LOCAÇÃO DE VESTIDOS, TRAJES E ACESSÓRIOS</div>
<div style="font-weight:bold; margin-bottom:8px;">IDENTIFICAÇÃO DAS PARTES</div>

<div style="margin-bottom:8px;"><span style="font-weight:bold">LOCADORA:</span> <?php echo $row_rs_contrato['razao_social'];?>, 
CNPJ: <?php echo $row_rs_contrato['cnpj'];?>, 
localizada na: <?php echo $row_rs_contrato['logradouroLoja'];?>, 
<?php echo $row_rs_contrato['numeroLoja'];?> - <?php echo $row_rs_contrato['cidadeLoja'];?> - <?php echo $row_rs_contrato['estadoLoja'];?>.</div>

<div style="margin-bottom:8px;"><span style="font-weight:bold">LOCATÁRIO:</span> <?php echo $row_rs_contrato['nomeCliente'];?>, CPF: <?php echo $row_rs_contrato['cpfCliente'];?>, RG: <?php echo $row_rs_contrato['rgCliente'];?>, domiciliado na: <?php echo $row_rs_contrato['enderecoCliente'];?>, <?php echo $row_rs_contrato['numeroCliente'];?> - <?php echo $row_rs_contrato['cidadeCliente'];?> / <?php echo $row_rs_contrato['estadoCliente'];?>.
</div>

<div style="font-weight:bold; margin-bottom:8px;">As partes identificadas acima têm, entre si, justo e acertado o presente Contrato de Locação de Artigos de Vestuário, que se regerá pelas cláusulas seguintes e pelas condições de preço, forma e termo de pagamento descritas no presente.</div>

<div style="font-weight:bold; margin-bottom:8px; text-align:center;">DO OBJETO DO CONTRATO</div>

<div style="font-weight:bold; margin-bottom:8px;">É objeto do presente contrato a locação do seguintes trajes e acessórios:</div>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tbody>
    <tr>
      <td width="10%" height="28"><strong>Código</strong></td>
      <td width="25%"><strong>Nome</strong></td>
      <td width="13%"><strong>QTD.</strong></td>
      <td width="18%"><strong>Valor</strong></td>
      <td width="18%"><strong>Desconto</strong></td>
      <td width="16%" align="right"><strong>SubTotal</strong></td>
    </tr>
    <tr>
          <td height="" colspan="6" style="border-top:#B0B0B0 solid 1px;"></td>
    </tr>
	<?php do { ?>
      <tr>
      <td height="28"><?php echo $row_rs_itens['nome_produto'];?></td>
      <td><?php echo $row_rs_itens['nomeProduto'];?></td>
      <td><?php echo $row_rs_itens['quantidade_produto'];?></td>
      <td><?php echo number_format($row_rs_itens['valor_unitario_produto'],2,',','.');?></td>
      <td><?php echo number_format($row_rs_itens['desconto_produto'],2,',','.');?></td>
      <td align="right"><?php $subtotal = $row_rs_itens['valor_total_produto']-$row_rs_itens['desconto_produto']; 
	  	echo number_format($subtotal,2,',','.');
		$total += $subtotal;
		?></td>
    </tr>
    <tr>
          <td height="" colspan="6" style="border-top:#B0B0B0 solid 1px;"></td>
      </tr>
    <?php } while($row_rs_itens = mysql_fetch_assoc($rs_itens)); 
	
	 $rows = mysql_num_rows($rs_itens);
  if($rows > 0) {
      mysql_data_seek($rs_itens, 0);
	  $row_rs_itens = mysql_fetch_assoc($rs_itens);
  }
	
	?>
    <tr>
      <td height="28" colspan="5" align="right"><strong>Total:&nbsp;</strong></td>
      <td align="right"><strong><?php echo number_format($total,2,',','.');?></strong></td>
    </tr>
    <tr>
          <td height="" colspan="6" style="border-top:#B0B0B0 solid 1px;"></td>
      </tr>
  </tbody>
</table>

<table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-top:20px;">
  <tbody>
    <tr>
      <td width="10%" height="28"><strong>Código</strong></td>
      <td width="25%"><strong>Nome do item</strong></td>
      <td width="19%"><strong>Data do Evento</strong></td>
      <td width="15%"><strong>Data Prova</strong></td>
      <td width="18%"><strong>Data de Retirada</strong></td>
      <td width="13%"><strong>Devolução</strong></td>
    </tr>
    <tr>
          <td height="" colspan="6" style="border-top:#B0B0B0 solid 1px;"></td>
    </tr>
	<?php do { ?>
      <tr>
      <td height="28"><?php echo $row_rs_itens['nome_produto'];?></td>
      <td><?php echo $row_rs_itens['nomeProduto'];?></td>
      <td><?php echo formataData($row_rs_contrato['data_evento']);?></td>
      <td><?php echo formataData($row_rs_itens['data_prova']);?></td>
      <td><?php echo formataData($row_rs_itens['data_retirada']);?></td>
      <td><?php echo formataData($row_rs_itens['data_devolucao']);?></td>
    </tr>
    <tr>
          <td height="" colspan="6" style="border-top:#B0B0B0 solid 1px;"></td>
      </tr>
    <?php } while($row_rs_itens = mysql_fetch_assoc($rs_itens)); ?>
  </tbody>
</table>

<div style="font-weight:bold; margin-bottom:8px; margin-top:15px;">Observações Adicionais:</div>
<div style="font-weight:bold; margin-bottom:8px; text-align:center">DO PREÇO E DAS CONDIÇÕES DE PAGAMENTO</div>

<div style="margin-bottom:8px; ">A presente locação será remunerada pela quantia total de <span style="font-weight:bold;">R$ <?php echo number_format($total,2,',','.');?></span>, pelo período informado de acordo com cada item locado e informado neste contrato</div>

<table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-top:20px;">
  <tbody>
    <tr>
      <td width="25%" height="28"><strong>Data do Pagamento</strong></td>
      <td width="29%"><strong>Forma de Pagamento</strong></td>
      <td width="15%"><strong>Parcelas</strong></td>
      <td width="17%"><strong>Valor</strong></td>
      <td width="14%" align="right"><strong>Status</strong></td>
    </tr>
    <tr>
          <td height="" colspan="5" style="border-top:#B0B0B0 solid 1px;"></td>
    </tr>
	<?php do { ?>
      <tr>
      <td height="28"><?php echo formataData($row_rs_pagamentos['data_pagamento']);?></td>
      <td><?php echo $row_rs_pagamentos['formaPagamento'];?></td>
      <td><?php echo $row_rs_pagamentos['parcelas'];?></td>
      <td><?php echo number_format($row_rs_pagamentos['valor_pagamento'],2,',','.');?></td>
      <td align="right">PAGO</td>
      </tr>
    <tr>
          <td height="" colspan="5" style="border-top:#B0B0B0 solid 1px;"></td>
      </tr>
    <?php }while($row_rs_pagamentos = mysql_fetch_assoc($rs_pagamentos)); ?>
    <tr>
      <td height="28" colspan="4" align="right"><strong>Total Pago:&nbsp;</strong></td>
      <td align="right"><strong><?php echo number_format($total,2,',','.');?></strong></td>
    </tr>
    <tr>
          <td height="" colspan="5" style="border-top:#B0B0B0 solid 1px;"></td>
    </tr>
  </tbody>
</table>

<div style="margin-bottom:8px; margin-top:15px;"><?php echo $row_rs_contratoClausula['clausula']?></div>

<table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-top:20px;">
  <tbody>
    <tr>
      <td width="19%" height="28"><strong>LOCATÁRIO</strong></td>
      <td width="35%"><strong><?php echo $row_rs_contrato['nomeCliente'];?></strong></td>
      <td width="14%"><strong>LOCADORA</strong></td>
      <td width="32%" colspan="2"><strong><?php echo $row_rs_contrato['nomeLoja'];?></strong></td>
    </tr>
    <tr>
          <td height="" colspan="5" style="border-top:#B0B0B0 solid 1px;"></td>
    </tr>

      <tr>
      <td height="28">CPF: <?php echo $row_rs_contrato['cpfCliente'];?></td>
      <td>RG: <?php echo $row_rs_contrato['rgCliente'];?></td>
      <td colspan="3">CNPJ: <?php echo $row_rs_contrato['cnpj'];?></td>
      </tr>
    <tr>
          <td height="" colspan="5" style="border-top:#B0B0B0 solid 1px;"></td>
      </tr>
      
      
      <tr>
      <td height="28" colspan="2">Assinatura: </td>
      <td colspan="3">Assinatura: </td>
      </tr>
    <tr>
          <td height="" colspan="5" style="border-top:#B0B0B0 solid 1px;"></td>
      </tr>
    
    
  </tbody>
</table>
<script>
/*print()
setTimeout(function(){ close(); }, 1000);*/
</script>
</body>
</html>