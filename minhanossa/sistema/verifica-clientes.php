<?php
include('restrito.php');
include('Connections/conexao.php');
include('funcoes.php');

mysql_select_db($database_conexao, $conexao);
$query_rs_clientes = "SELECT tbl_cliente.*, tbl_prazos.nome as prazo FROM tbl_cliente left join tbl_emprestimos as tbl_prazos on tbl_cliente.id_prazo = tbl_prazos.id where tbl_cliente.id = '{$_GET['id']}'";
$rs_clientes = mysql_query($query_rs_clientes, $conexao) or die(mysql_error());
$row_rs_clientes = mysql_fetch_assoc($rs_clientes);
$totalRows_rs_clientes = mysql_num_rows($rs_clientes);

if($_GET['acao'] == 'altera_plano') {
	echo "	<script>
			parent.document.getElementById('tipo_contrato').value = '{$row_rs_clientes['id_plano']}';
			parent.document.getElementById('prazo_cliente').value = '{$row_rs_clientes['prazo']}';
			</script>";
			exit;
}