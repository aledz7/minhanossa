<?php
include('funcoes.php');

$insertSQL = sprintf("INSERT INTO tbl_contas (id_contrato,tipo,  id_pagamento_contrato, valor_total, data_emissao, data_vencimento, descricao) VALUES (%s, %s, %s, %s, %s, %s, %s)",
		   GetSQLValueString($_POST['id_contrato'], "text"),
		   GetSQLValueString($_POST['tipo'], "text"),
		   GetSQLValueString($_POST['id_pagamento_contrato'], "text"),
		   GetSQLValueString(valorCalculavel($_POST['valor_total']), "text"),
		   GetSQLValueString($_POST['data_emissao'], "text"),
		   GetSQLValueString($_POST['data_vencimento'], "text"),
		   GetSQLValueString($_POST['descricao'], "text"));
mysql_select_db($database_conexao, $conexao);
$Result1 = mysql_query($insertSQL, $conexao) or die(mysql_error());
?>