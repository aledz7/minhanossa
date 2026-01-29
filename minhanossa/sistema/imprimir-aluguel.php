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
	$query_rs_contrato = "SELECT tbl_contrato.*, tbl_cliente.nome as nomeCliente FROM tbl_contrato left join tbl_cliente on tbl_contrato.codigo_cliente = tbl_cliente.id WHERE tbl_contrato.id = '".$_GET['id']."'";
	$rs_contrato = mysql_query($query_rs_contrato, $conexao) or die(mysql_error());
	$row_rs_contrato = mysql_fetch_assoc($rs_contrato);
	$totalRows_rs_contrato = mysql_num_rows($rs_contrato);

	mysql_select_db($database_conexao, $conexao);
	$query_rs_editar_item = "SELECT * FROM tbl_item WHERE id_contrato = '".$_GET['id']."'";
	$rs_editar_item = mysql_query($query_rs_editar_item, $conexao) or die(mysql_error());
	$row_rs_editar_item = mysql_fetch_assoc($rs_editar_item);
	$totalRows_rs_editar_item = mysql_num_rows($rs_editar_item);
	
	
	
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Impressão de Aluguel</title>
<link rel="stylesheet" type="text/css" href="css.css">
</head>

<body>
<table width="100%" style="border:solid 1px #CCCCCC" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="50%" height="50" style="padding-left:8px;" ><strong><?=$row_rs_loja['nome'];?></strong></td>
    <td width="50%" align="right" valign="top"  style="padding-top:5px; padding-bottom:5px; padding-right:5px;"><?=$row_rs_loja['logradouro'];?> <br />
     <?//=$row_rs_loja['cidade'];?>  <?//=$row_rs_loja['estado'];?>  Fone: <?=$row_rs_loja['telefone1'];?><br />
      <?=$row_rs_loja['cnpj'];?></td>
  </tr>
</table>
<div align="center" style="font-family:Arial, Helvetica, sans-serif; margin:5px; font-weight:bold; letter-spacing:1px;"> ALUGUEL N°
  <?=$_GET['id'];?>
</div>
<table width="100%"  border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td style="padding-bottom:6px;" class="preto_arial_12" >Cliente: <strong><?php echo $row_rs_contrato['nomeCliente'];?></strong></td>
  </tr>
  <tr>
    <td  style="border:solid 1px #CCCCCC; padding:5px" align="center"><h4>Rela&ccedil;&atilde;o de Itens <?php if($_GET['tipo'] == 'R'){ echo " (Retirada)";}if($_GET['tipo'] == 'D'){ echo " (Devolu&ccedil;&atilde;o)";}?></h4></td>
  </tr>
   <tr>
    <td  style="border:solid 1px #CCCCCC; padding:5px" ><strong>Foram listados <?php echo $totalRows_rs_editar_item;?> itens.</strong></td>
  </tr>
</table>
<?php do{
	mysql_select_db($database_conexao, $conexao);
	$query_rs_itens_produtos = "SELECT * FROM tbl_produto WHERE id = '".$row_rs_editar_item['nome_produto']."'";
	$rs_itens_produtos = mysql_query($query_rs_itens_produtos, $conexao) or die(mysql_error());
	$row_rs_itens_produtos = mysql_fetch_assoc($rs_itens_produtos);
	$totalRows_rs_itens_produtos = mysql_num_rows($rs_itens_produtos);
	
	mysql_select_db($database_conexao, $conexao);
	$query_rs_mostrar_cor = "SELECT * FROM 	tbl_cores WHERE id = '".$row_rs_itens_produtos['id_cor']."'";
	$rs_mostrar_cor = mysql_query($query_rs_mostrar_cor, $conexao) or die(mysql_error());
	$row_rs_mostrar_cor = mysql_fetch_assoc($rs_mostrar_cor);
	$totalRows_rs_mostrar_cor = mysql_num_rows($rs_mostrar_cor);
	
	?>
<!--Imprimir Produtos-->
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border:solid 1px #CCCCCC; padding:5px">
  <tr>
    <td colspan="4">Id Produto: <strong><?=$row_rs_itens_produtos['id'];?></strong></td>
  </tr>
   <tr>
    <td colspan="2">Produto: <strong><?=$row_rs_itens_produtos['nome'];?></strong></td>
	   <td colspan="2">Cor: <strong><?=$row_rs_mostrar_cor['nome'];?></strong></td>
     
  </tr>
	<tr>
	<td colspan="2">Tamanho: <strong><?=$row_rs_itens_produtos['numeracao'];?></strong></td>
     <td colspan="2">Valor: <strong>R$<?php echo number_format($row_rs_itens_produtos['valor_venda'],2,",",".");?></strong></td>
	</tr>
  <tr>
    <td colspan="2">Data do Retirada: <strong><?=formataData($row_rs_editar_item['data_retirada']);?></strong></td>
    <td colspan="2">Data da Devolução: <strong><?=formataData($row_rs_editar_item['data_devolucao']);?></strong></td>
  </tr>
  <tr>   
    <td colspan="2">Quantidade: <strong><?=$row_rs_editar_item['quantidade_produto'];?></strong></td>
    <!-- <td colspan="2">Pontua&ccedil;&atilde;o: <strong>teste<?php echo $row_rs_itens_produtos['pontuacao'];?></strong></td> -->
  </tr>
 
 <?php $somaPontuacao += $row_rs_itens_produtos['pontuacao'];?>
 <?php $somaProduto += $row_rs_itens_produtos['valor_venda'];?>
</table>
<!--Fim-->
<!--Observações-->
<?php /*?><table width="100%" border="0" cellpadding="0" cellspacing="0" style="border:solid 1px #CCCCCC; padding:5px">
<tr>
	<td>
 <?php $row_rs_itens_produtos['pontuacao'];?>
		</td>
	</tr> 
</table><?php */?>
<!--Fim-->
	
<?php }while($row_rs_editar_item = mysql_fetch_assoc($rs_editar_item));?>
<table width="100%"  border="0" cellpadding="0" cellspacing="0">
 <?php /*?> <tr>
    <td colspan="2" style="border:solid 1px #CCCCCC; padding:5px" >Comentário: <strong><?=$row_rs_contrato['comentario'];?></strong></td>
  </tr><?php */?>
   <tr>
    <!-- <td  style="border:solid 1px #CCCCCC; padding:5px" ><strong>Total de <?php echo $somaPontuacao;?> pontos.</strong></td> -->
    <td  style="border:solid 1px #CCCCCC; padding:5px" ><strong>Total R$<?php echo number_format($somaProduto,2,",",".");?>.</strong></td>
  </tr>
</table>

<table width="100%"  border="0" cellpadding="0" cellspacing="0">
   <tr>
    <td  colspan="2" style="padding-top:7px;"><?php if($_GET['tipo'] == 'R'){ echo "<strong>Data Retirada:</strong> ";} if($_GET['tipo'] == 'D'){ echo "<strong>Data Devolu&ccedil;&atilde;o:</strong> ";}?> <?php echo date('d/m/Y');?></td>
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
    <td align="center"><strong>Assinatura Cliente</strong></td>
    <td align="center"><strong>Assinatura Loja</strong></td>
  </tr>
</table>
<br/>
<br/>
Obs.: <?php echo $row_rs_contrato['comentario']; ?>


 <script>
print();
//  function redireciona() {
//  	window.location='editar_contrato.php?id=<?=$_GET['id'];?>';
//  }
setTimeout(function(){ redireciona(); }, 1000);
</script>
</body>
</html>