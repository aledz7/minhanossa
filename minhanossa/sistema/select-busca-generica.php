<?php
include('../Connections/conexao.php');
include('funcoes.php');

session_start();

if ($_GET[tabelas] == '') {
	$_GET[tabelas] = $_SESSION['tabelas' . $_SESSION['sessionTabelas']];
}

if ($_POST[busca] <> '' or $_GET[id] <> '') {
	$campoTitulo = $_GET[tituloBanco];
	if ($_GET[concatCampos] <> '') {
		$campoTitulo = "CONCAT(" . str_replace("\'", "'", $_GET[concatCampos]) . ")";
	}

	//$_POST[busca] = utf8_encode($_POST[busca]);

	$sql = "($_GET[tituloBanco] like '%" . ($_POST[busca]) . "%' or $_GET[campoId] like '%" . ($_POST[busca]) . "%')";

	if ($_GET['where'] <> '') {
		$sql .= str_replace("\'", "'", $_GET['where']);
	}

	if ($_GET['id'] <> '') {
		$sql = " tbl_produto.id = '$_GET[id]'";
	}

	mysql_select_db($database_conexao, $conexao);
	$query_rs_busca = "SELECT * FROM " . str_replace("\'", "'", $_GET[tabelas]) . " where $sql ORDER BY $_GET[tituloBanco] ASC";
	$rs_busca = mysql_query($query_rs_busca, $conexao) or die(mysql_error());
	$row_rs_busca = mysql_fetch_assoc($rs_busca);
	$totalRows_rs_busca = mysql_num_rows($rs_busca);


	

	if ($_GET['id'] <> '') {
		$idProduto = $row_rs_busca['id'];
							$nome = $row_rs_busca['nome'];
							$valor_aluguel = $row_rs_busca['valor_aluguel'];
							$tamanho = $row_rs_busca['numeracao'];
							$qnt_estoque = $row_rs_busca['qnt_estoque'];
							$valor_venda = $row_rs_busca['valor_venda'];

							$query_rs_cores = "SELECT * FROM tbl_cores WHERE id = '" . $row_rs_busca['id_cor'] . "'";
							$rs_cores = mysql_query($query_rs_cores, $conexao) or die(mysql_error());
							$row_rs_cores = mysql_fetch_assoc($rs_cores);
							$totalRows_rs_cores = mysql_num_rows($rs_cores);
		
		echo "	<script>
				" . str_replace('[titulo]', $row_rs_busca['titulo'], str_replace('[id]', $row_rs_busca['id'], $_SESSION[javascript_ . $_GET[inputCampo]])) . "
				parent.document.getElementById('desc_$_GET[inputCampo]').innerHTML='".($row_rs_busca['nome'].' - '.$row_rs_cores['nome'].' '.$tamanho)."';
				</script>";
		exit;
	}
}

//print_r($row_rs_produtos);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Busca iBooking</title>
	<link href="css.css" rel="stylesheet" type="text/css" />
</head>

<body>
	<form name="form1Pesquisa" id="form1Pesquisa" method="post">
		<table width="100%" border="0" cellspacing="3" cellpadding="0">
			<tr>
				<td width="49%">

					<input name="busca" type="search" results='10' autofocus="autofocus" class="txtbox2" id="busca" placeholder="Palavra-Chave" value="<?= ($_POST[busca]); ?>">

				</td>
				<td width="51%"><a href="javascript:;" onclick="document.getElementById('form1Pesquisa').submit()" class="bt71px" style="float:left; margin-left:10px;">Buscar</a><a href="javascript:;" onclick="javascript:parent.window['temp_' + <?= $_GET[janela]; ?>].close();" class="bt63px" style="float:left; margin-left:7px;">Fechar</a>

					&nbsp;&nbsp;<span id="Loading_busca"><img src="../images/loading2.gif" width="0" height="0" /></span>
					<input name="input" type="image" style="width:0px; height:0px;" value="" onclick="javascript:document.getElementById('Loading_busca').innerHTML = '&lt;img src=../images/loading2.gif&gt;';" />

				</td>
			</tr>
			<? if ($totalRows_rs_busca > 0) { ?><tr>
					<td colspan="2">
						<?php do {
					
							//print_r($row_rs_busca);
							$idProduto = $row_rs_busca['id'];
							$nome = $row_rs_busca['nome'];
							$valor_aluguel = $row_rs_busca['valor_aluguel'];
							$tamanho = $row_rs_busca['numeracao'];
							$qnt_estoque = $row_rs_busca['qnt_estoque'];
							$valor_venda = $row_rs_busca['valor_venda'];

							$query_rs_cores = "SELECT * FROM tbl_cores WHERE id = '" . $row_rs_busca['id_cor'] . "'";
							$rs_cores = mysql_query($query_rs_cores, $conexao) or die(mysql_error());
							$row_rs_cores = mysql_fetch_assoc($rs_cores);
							$totalRows_rs_cores = mysql_num_rows($rs_cores);


						?>
							<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:8px; <? if ($n / 2 == 0) {
																															echo 'background:#f1f1f1;';
																															$cor = '#f1f1f1';
																															$n = 1;
																														} else {
																															echo $cor = '#fff';
																															$n = 0;
																														} ?>">
								<tr>
									<td width="50%" class="borda_tabela"><?php echo $row_rs_busca['nome'] ?></td>
									<td width="20%" class="borda_tabela"><?php echo $row_rs_cores['nome'] ?></td>
									<td width="20%" class="borda_tabela"><?php echo $tamanho ?></td>
									<td width="10%" nowrap="nowrap" class="borda_tabela"><a href="javascript:;" onClick="<?= str_replace('[titulo]', str_replace(array("'", '"'), array("\'", "\'"), $row_rs_busca['titulo']), str_replace('[id]', $row_rs_busca['id'], $_SESSION[javascript_ . $_GET[inputCampo]])); ?>parent.document.getElementById('<?= $_GET[inputCampo]; ?>').value='<?= $row_rs_busca['id']; ?>';parent.document.getElementById('desc_<?= $_GET[inputCampo]; ?>').innerHTML=' - <?php echo str_replace(array("'", '"'), array("\'", "\'"), ($row_rs_busca['nome'].' - '.$row_rs_cores['nome'].' '.$tamanho)); ?>'; parent.window['temp_' + <?= $_GET[janela]; ?>].close();" class="bt86px" style="float:left; margin-left:5px;">Selecionar</a></td>
								</tr>
							</table>
						<?php } while ($row_rs_busca = mysql_fetch_assoc($rs_busca)); ?>
					</td>
				</tr><? } ?>
		</table>
	</form>
</body>

</html>
<?php
@mysql_free_result($rs_busca);
?>