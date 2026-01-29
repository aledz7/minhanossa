<?php 
include('restrito.php');
include('Connections/conexao.php');
include('funcoes.php');

if (!isset($_SESSION)) { session_start(); }

mysql_select_db($database_conexao, $conexao);
$query_rs_ordem_servico = "
SELECT 
	tbl_ordem_servico.*,
	tbl_loja.nome as nomeLoja,
	tbl_loja.logradouro as logradouroLoja,
	tbl_loja.numero as numeroLoja,
	tbl_loja.cnpj as cnpjLoja,
	dados_estados.uf as estadoLoja,
	dados_cidades.nome as cidadeLoja,
	tbl_loja.telefone1 as telefoneLoja
FROM 
	tbl_ordem_servico 
	left join tbl_loja on tbl_ordem_servico.id_loja = tbl_loja.id
	left join dados_estados on tbl_loja.estado = dados_estados.id
	left join dados_cidades on tbl_loja.cidade = dados_cidades.id
where 
	tbl_ordem_servico.id = '{$_GET['id']}'";
$rs_ordem_servico = mysql_query($query_rs_ordem_servico, $conexao) or die(mysql_error());
$row_rs_ordem_servico = mysql_fetch_assoc($rs_ordem_servico);
$totalRows_rs_ordem_servico = mysql_num_rows($rs_ordem_servico);

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Impressão de Ordem de Serviço</title>
<link rel="stylesheet" type="text/css" href="css.css">
</head>

<body>
<table width="100%" style="border:solid 1px #CCCCCC" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="50%" height="50" style="padding-left:8px;" ><strong><?php echo $row_rs_ordem_servico['nomeLoja'];?></strong></td>
    <td width="50%" align="right" valign="top"  style="padding-top:5px; padding-bottom:5px; padding-right:5px;"><?php echo $row_rs_ordem_servico['logradouroLoja'];?> <br />
     <?php echo $row_rs_ordem_servico['cidadeLoja'];?> / <?php echo $row_rs_ordem_servico['estadoLoja'];?> - Fone: <?php echo $row_rs_ordem_servico['telefoneLoja'];?><br />
      <?php echo $row_rs_ordem_servico['cnpjLoja'];?></td>
  </tr>
</table>
<div align="center" style="font-family:Arial, Helvetica, sans-serif; margin:5px; font-weight:bold; letter-spacing:1px;"> ORDEM DE SERVI&Ccedil;O Nº.
  <?php echo $_GET['id'];?>
</div>
<table width="100%"  border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td style="padding-bottom:6px;" class="preto_arial_12" ><strong>SERVI&Ccedil;OS:</strong></td>
  </tr>
  <tr>
    <td  style="border:solid 1px #CCCCCC; padding:5px"><?php echo $row_rs_ordem_servico['servico'];?></td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" >Data de Entrada: <?php echo formataData($row_rs_ordem_servico['data_entrada']);?></td>
  </tr>
  <tr>
   
    <td colspan="4" >Data de Saída: <?php echo formataData($row_rs_ordem_servico['data_saida']);?></td>
  </tr>
  <tr>
    <td width="22%" height="140" class="preto_arial_12">&nbsp;</td>
    <td width="2%">&nbsp;</td>
    <td style="border-bottom:solid 1px #000000"><br /></td>
    <td width="3%" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
    <td style="border-bottom:solid 1px #000000; "><br /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td width="25%" align="center" class="preto_arial_12"><strong>Assinatura do Atendente</strong></td>
    <td >&nbsp;</td>
    <td width="48%" height="20" align="center" class="preto_arial_12"><strong>Autorizo o 
      or&ccedil;amento no valor de
      R$ <?php echo number_format($row_rs_ordem_servico['valor'],2,',','.'); ?>
    </strong></td>
  </tr>
</table>
<script>
print()
setTimeout(function(){ close(); }, 1000);
</script>
</body>
</html>