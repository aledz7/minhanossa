<?php
include('funcoes.php');

mysql_select_db($database_conexao, $conexao);
$query_rs_vendedor = "SELECT * FROM tbl_admin where id = '{$_POST['id_user_vendedor']}'";
$rs_vendedor = mysql_query($query_rs_vendedor, $conexao) or die(mysql_error());
$row_rs_vendedor = mysql_fetch_assoc($rs_vendedor);
$totalRows_rs_vendedor = mysql_num_rows($rs_vendedor);

$insertSQL = sprintf("INSERT INTO tbl_comissoes (id_user_vendedor, valor_comissao, id_contrato) VALUES (%s, %s, %s)",
		   GetSQLValueString($_POST['id_user_vendedor'], "text"),
		   GetSQLValueString(valorCalculavel(($_POST['totalContrato']/100)*$row_rs_vendedor['comissao']), "text"),
		   GetSQLValueString($_POST['id_contrato'], "text"));
mysql_select_db($database_conexao, $conexao);
$Result1 = mysql_query($insertSQL, $conexao) or die(mysql_error());
?>