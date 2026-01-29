<?php 
//include('restrito.php');
include('Connections/conexao.php');
include('funcoes.php');

if($_POST['acao'] == 'enviarCodigo') {
	$codigo = $_POST['codigo'];
	
	mysql_select_db($database_conexao, $conexao);
	$query_rs_verificaCliente = "SELECT * FROM tbl_cliente WHERE id = '{$codigo}'";
	$rs_verificaCliente = mysql_query($query_rs_verificaCliente, $conexao) or die(mysql_error());
	$row_rs_verificaCliente = mysql_fetch_assoc($rs_verificaCliente);
	$totalRows_rs_verificaCliente = mysql_num_rows($rs_verificaCliente);
	
	if($totalRows_rs_verificaCliente > 0) {
		echo "	<script>
				parent.window.location='add_contrato.php?id_cliente={$row_rs_verificaCliente['id']}';
				</script>";
				exit;
	} else {
		echo "	<script>
				alert('Codigo n&atilde;o encontrado!');
				parent.window.location='add_cliente.php?acao=novoContrato&cpf={$_POST['cpf']}';
				</script>";
				exit;
	}
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Novo Contrato com Codigo Cliente</title>
<script src="outras-funcoes.js"></script>
<link href="css.css" rel="stylesheet" type="text/css">
</head>

<body>
<form action="" method="post" id="formCodigo">
	<table width="100%" border="0">
      <tbody>
        <tr>
          <td width="4%" align="right">C&oacute;digo:</td>
          <td width="96%"><input name="codigo" type="text" class="txtbox97" id="codigo" maxlength="14" ></td>
        </tr>
        <tr>
          <td align="right">&nbsp;</td>
          <td><a href="javascript:;" class="bt86px" onClick="document.getElementById('formCodigo').submit();">Confirmar</a></td>
        </tr>
      </tbody>
    </table>
    <input type="hidden" name="acao" value="enviarCodigo">
</form>
</body>
</html>