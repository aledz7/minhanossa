<?php 
//include('restrito.php');
include('Connections/conexao.php');
include('funcoes.php');

if($_POST['acao'] == 'enviarCPF') {
	$cpf = str_replace(array('.','-', ' '), array('','', ''), $_POST['cpf']);
	
	mysql_select_db($database_conexao, $conexao);
	$query_rs_verificaCliente = "SELECT * FROM tbl_cliente WHERE replace(replace(replace(cpf, ' ', ''), '-', ''), '.', '') = '{$cpf}'";
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
<title>Novo Contrato com CPF</title>
<script src="outras-funcoes.js"></script>
<link href="css.css" rel="stylesheet" type="text/css">
</head>

<body>
<form action="" method="post" id="formCPF">
	<table width="100%" border="0">
      <tbody>
        <tr>
          <td width="4%" align="right">CPF:</td>
          <td width="96%"><input name="cpf" type="text" class="txtbox97" id="cpf" onKeyPress="return txtBoxFormat(this.name, '999.999.999-99', event);" maxlength="14" ></td>
        </tr>
        <tr>
          <td align="right">&nbsp;</td>
          <td><a href="javascript:;" class="bt86px" onClick="document.getElementById('formCPF').submit();">Confirmar</a></td>
        </tr>
      </tbody>
    </table>
    <input type="hidden" name="acao" value="enviarCPF">
</form>
</body>
</html>