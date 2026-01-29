<?php 
include('Connections/conexao.php'); 
include('funcoes.php');

//pega cliente//
mysql_select_db($database_conexao, $conexao);
$query_rs_pega_cliente = "SELECT * FROM tbl_cliente WHERE id = '".$_GET['id']."'"; 
$rs_pega_cliente = mysql_query($query_rs_pega_cliente, $conexao) or die(mysql_error());
$row_rs_pega_cliente = mysql_fetch_assoc($rs_pega_cliente);
$totalRows_rs_pega_cliente = mysql_num_rows($rs_pega_cliente);
//final pega cliente//


?>

<script>
     <? if($row_rs_pega_cliente['id_plano'] <> ''){?>
        parent.document.getElementById('tipo_contrato').value = '<? echo $row_rs_pega_cliente['id_plano'];?>';
	 <? }?>
</script>