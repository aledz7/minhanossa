<?php
include('restrito.php');
include('Connections/conexao.php');
include('funcoes.php');

$currentPage = 'cliente.php';

mysql_select_db($database_conexao, $conexao);
$query_rs_cliente = "SELECT * FROM tbl_cliente WHERE id is not null $sql ORDER BY id DESC";
$rs_cliente = mysql_query($query_rs_cliente, $conexao) or die(mysql_error());
$row_rs_cliente = mysql_fetch_assoc($rs_cliente);
$totalRows_rs_cliente = mysql_num_rows($rs_cliente);


$lin="Nome\tE-mail\tTelefone\n";
	
do {
	$lin .= $row_rs_cliente['nome']."\t{$row_rs_cliente['email']}\t{$row_rs_cliente['telefone1']}";
	$lin .= "\n";
} while($row_rs_cliente = mysql_fetch_assoc($rs_cliente));

header("Content-type: application/octet-stream");

# replace excelfile.xls with whatever you want the filename to default to
header("Content-Disposition: attachment; filename=Lista-de-emails-clientes-".date('d-m-Y').".xls");
header("Pragma: no-cache");
header("Expires: 0");

echo $lin;