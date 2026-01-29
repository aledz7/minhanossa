<?php 
include('Connections/conexao.php');
include('funcoes.php');

//session_start();

mysql_select_db($database_conexao, $conexao);
$query_rs_ordem_servico = "
SELECT 
	tbl_lavanderia.*,
	tbl_produto.nome as nomeProduto
FROM 
	tbl_lavanderia 
	left join tbl_produto on tbl_produto.id = tbl_lavanderia.id_produto
where 
	tbl_lavanderia.id = '{$_GET['id']}'";
$rs_ordem_servico = mysql_query($query_rs_ordem_servico, $conexao) or die(mysql_error());
$row_rs_ordem_servico = mysql_fetch_assoc($rs_ordem_servico);
$totalRows_rs_ordem_servico = mysql_num_rows($rs_ordem_servico);

mysql_select_db($database_conexao, $conexao);
$query_rs_config = "
SELECT 
	tbl_loja.*,
	dados_estados.uf as estadoLoja,
	dados_cidades.nome as cidadeLoja
FROM 
	tbl_loja 
	left join dados_estados on tbl_loja.estado = dados_estados.id
	left join dados_cidades on tbl_loja.cidade = dados_cidades.id";
$rs_config = mysql_query($query_rs_config, $conexao) or die(mysql_error());
$row_rs_config = mysql_fetch_assoc($rs_config);
$totalRows_rs_config = mysql_num_rows($rs_config);

mysql_select_db($database_conexao, $conexao);
	$query_rs_editar_item = "SELECT * FROM tbl_item WHERE id_lavanderia = '".$_GET['id']."'";
	$rs_editar_item = mysql_query($query_rs_editar_item, $conexao) or die(mysql_error());
	$row_rs_editar_item = mysql_fetch_assoc($rs_editar_item);
	$totalRows_rs_editar_item = mysql_num_rows($rs_editar_item);

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Impressão de Lavanderia</title>
<link rel="stylesheet" type="text/css" href="css.css">
</head>

<body>
<table width="100%" style="border:solid 1px #CCCCCC" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="50%" height="50" style="padding-left:8px;" ><strong><?=$row_rs_config['nome'];?></strong></td>
    <td width="50%" align="right" valign="top"  style="padding-top:5px; padding-bottom:5px; padding-right:5px;"><?=$row_rs_config['logradouro'];?> <br />
     <?=$row_rs_config['cidadeLoja'];?> / <?=$row_rs_config['estadoLoja'];?> - Fone: <?=$row_rs_config['telefone'];?><br />
      <?=$row_rs_config['cnpj'];?></td>
  </tr>
</table>
<div align="center" style="font-family:Arial, Helvetica, sans-serif; margin:5px; font-weight:bold; letter-spacing:1px;"> LAVANDERIA Nº.
  <?=$_GET['id'];?>
</div>
<table width="100%"  border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td style="padding-bottom:6px;" class="preto_arial_12" ><strong>SERVI&Ccedil;OS:</strong></td>
  </tr>
  <tr>
    <td  style="border:solid 1px #CCCCCC; padding:5px"><?=$row_rs_ordem_servico['servico'];?></td>
  </tr>
</table>
<?php do{
	mysql_select_db($database_conexao, $conexao);
	$query_rs_itens_produtos = "SELECT * FROM tbl_produto WHERE id = '".$row_rs_editar_item['nome_produto']."'";
	$rs_itens_produtos = mysql_query($query_rs_itens_produtos, $conexao) or die(mysql_error());
	$row_rs_itens_produtos = mysql_fetch_assoc($rs_itens_produtos);
	$totalRows_rs_itens_produtos = mysql_num_rows($rs_itens_produtos);
	
	?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="4">Id Produto: <?=$row_rs_itens_produtos['id'];?></td>
  </tr>
   <tr>
    <td colspan="4">Produto: <?=$row_rs_itens_produtos['nome'];?></td>
  </tr>
 <?php /*?> <tr>
    <td colspan="4">Data do Evento: <?=formataData($row_rs_ordem_servico['data_evento']);?></td>
  </tr><?php */?>
  <tr>
    <td colspan="4">Data da Retirada: <?=formataData($row_rs_editar_item['data_retirada']);?></td>
    <td colspan="4">Data da Devolução: <?=formataData($row_rs_editar_item['data_devolucao']);?></td>
  </tr>
  <tr>
    
  </tr>
	</table>
	<?php }while($row_rs_editar_item = mysql_fetch_assoc($rs_editar_item));?>
	<table width="100%"  border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td  colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td  colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td  colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">_________________________________________</td>
    <td align="center">_________________________________________</td>
  </tr>
  <tr>
    <td align="center"><strong>Assinatura Lavanderia</strong></td>
    <td align="center"><strong>Assinatura Loja</strong></td>
  </tr>
</table>
<script>
print()
setTimeout(function(){ close(); }, 1000);
</script>
</body>
</html>