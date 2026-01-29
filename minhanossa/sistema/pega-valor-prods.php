<?php 
include('../Connections/conexao.php'); 
include('funcoes.php');

mysql_select_db($database_conexao, $conexao);
$query_rs_itens_produtos = "SELECT tbl_produto.*, tbl_cores.nome as cor FROM tbl_produto left join tbl_cores on tbl_produto.id_cor = tbl_cores.id where tbl_produto.id = '{$_GET['id']}'";
$rs_itens_produtos = mysql_query($query_rs_itens_produtos, $conexao) or die(mysql_error());
$row_rs_itens_produtos = mysql_fetch_assoc($rs_itens_produtos);
$totalRows_rs_itens_produtos = mysql_num_rows($rs_itens_produtos);

if($_GET['tipo'] == 'lavanderia') {
	echo "	<script>
					parent.document.getElementById('valorVenda".$_GET['nItem']."').value = '".number_format($row_rs_itens_produtos['valor_venda'],2,',','.')."';
					parent.document.getElementById('pontuacao".$_GET['nItem']."').value = '".$row_rs_itens_produtos['pontuacao']."';
					parent.document.getElementById('numeracao".$_GET['nItem']."').value = '".$row_rs_itens_produtos['numeracao']."';
					parent.document.getElementById('id_cor".$_GET['nItem']."').value = '".$row_rs_itens_produtos['cor']."';
					</script>";
					exit;
}

/// -- verifica se já tá reservado.
mysql_select_db($database_conexao, $conexao);
$query_rs_lista_espera = "
SELECT
	tbl_lista_espera.*,
	tbl_produto.nome as nomeProduto,
	tbl_produto.id as codigoProduto,
	tbl_produto.numeracao as tamanho,
	tbl_cores.nome as cor,
	tbl_cliente.nome as nomeCliente
FROM
	tbl_lista_espera
	left join tbl_produto on tbl_lista_espera.id_produto = tbl_produto.id
	left join tbl_cores on tbl_cores.id = tbl_produto.id_cor
	left join tbl_cliente on tbl_lista_espera.id_cliente = tbl_cliente.id
where
	tbl_lista_espera.data >= '{$_GET['data_retirada']}' 
	and tbl_lista_espera.data <= '{$_GET['data_devolucao']}'
	and tbl_lista_espera.id_produto = '{$_GET['id']}'";
$rs_lista_espera = mysql_query($query_rs_lista_espera, $conexao) or die(mysql_error());
$row_rs_lista_espera = mysql_fetch_assoc($rs_lista_espera);
$totalRows_rs_lista_espera = mysql_num_rows($rs_lista_espera);
?>
<script>

<?php
if($totalRows_rs_lista_espera > 0) { ?>
alert('Esse produto tem reserva registrada para este período.');
<?php } ?>
/*parent.document.getElementById('valor_unitario_produto<?//=$_GET['nItem'];?>').value='<?//=number_format($row_rs_itens_produtos['valor_aluguel'],2,',','.');?>';*/
parent.document.getElementById('pontuacao<?php echo $_GET['nItem'];?>').value='<?php echo $row_rs_itens_produtos['pontuacao'];?>';
parent.document.getElementById('valorVenda<?php echo $_GET['nItem'];?>').value='<?php echo number_format($row_rs_itens_produtos['valor_venda'],2,',','.');?>';
parent.document.getElementById('numeracao<?php echo $_GET['nItem'];?>').value='<?php echo $row_rs_itens_produtos['numeracao'];?>';
parent.document.getElementById('id_cor<?php echo $_GET['nItem'];?>').value='<?php echo $row_rs_itens_produtos['id_cor'];?>';
parent.document.getElementById('valor_total_produto<?php echo $_GET['nItem'];?>').value=parent.number_format(<?php echo $row_rs_itens_produtos['valor_aluguel'];?>*parent.document.getElementById('quantidade_produto<?php echo $_GET['nItem'];?>').value,2,',','.');
</script>