<?php
include('restrito.php');
include('Connections/conexao.php');
include('funcoes.php');

mysql_select_db($database_conexao, $conexao);
$query_rs_produtos = "SELECT * FROM tbl_produto";
$rs_produtos = mysql_query($query_rs_produtos, $conexao) or die(mysql_error());
$row_rs_produtos = mysql_fetch_assoc($rs_produtos);
$totalRows_rs_produtos = mysql_num_rows($rs_produtos);

do {
	echo $updateSQL = sprintf("UPDATE tbl_produto SET nome=%s WHERE id=%s",
                       GetSQLValueString($row_rs_produtos['nome'], "text"),
                       GetSQLValueString($row_rs_produtos['id'], "int"));  
	mysql_select_db($database_conexao, $conexao);
	//$Result1 = mysql_query($updateSQL, $conexao) or die(mysql_error());
} while($row_rs_produtos = mysql_fetch_assoc($rs_produtos));