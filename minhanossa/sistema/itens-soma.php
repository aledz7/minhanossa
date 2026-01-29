<?php 
include('Connections/conexao.php'); 
include('funcoes.php');

if (!isset($_SESSION)) { session_start(); }

mysql_select_db($database_conexao, $conexao);
$query_rs_itens_produtos = "SELECT * FROM tbl_produto ORDER BY nome ASC";
$rs_itens_produtos = mysql_query($query_rs_itens_produtos, $conexao) or die(mysql_error());
$row_rs_itens_produtos = mysql_fetch_assoc($rs_itens_produtos);
$totalRows_rs_itens_produtos = mysql_num_rows($rs_itens_produtos);
print_r($row_rs_editar_item);

mysql_select_db($database_conexao, $conexao);
$query_rs_cores = "SELECT * FROM tbl_cores ORDER BY nome ASC";
$rs_cores = mysql_query($query_rs_cores, $conexao) or die(mysql_error());
$row_rs_cores = mysql_fetch_assoc($rs_cores);
$totalRows_rs_cores = mysql_num_rows($rs_cores);

if(basename($_SERVER['SCRIPT_NAME']) == 'editar_contrato.php'){
	mysql_select_db($database_conexao, $conexao);
	$query_rs_editar_item = "SELECT 
	                                tbl_item.*,
	                                tbl_produto.nome as nomeProduto, 
									tbl_produto.pontuacao as Pontuacao, 
									tbl_produto.valor_venda as valorVenda, 
									tbl_produto.numeracao as numeracao,
									tbl_produto.id_cor as id_cor,
									tbl_cores.nome as nomeCor
							   FROM 
							        tbl_item 
							   left join 
							        tbl_produto on tbl_item.nome_produto = tbl_produto.id 
							   left join
							        tbl_cores on tbl_produto.id_cor = tbl_cores.id	
							   where 
							        tbl_item.id_contrato = '{$_GET['id']}'";
	$rs_editar_item = mysql_query($query_rs_editar_item, $conexao) or die(mysql_error());
	//$row_rs_editar_item = mysql_fetch_assoc($rs_editar_item);
	$totalRows_rs_editar_item = mysql_num_rows($rs_editar_item);
	
	
	if($_GET['qtdItens'] == '') {
		$_GET['qtdItens'] = $totalRows_rs_editar_item;
	}
	
	
	
	/*mysql_select_db($database_conexao, $conexao);
	$query_rs_contar_item = "SELECT * FROM tbl_item where tbl_item = '{$_GET['id']}'";
	$rs_contar_item = mysql_query($query_rs_contar_item, $conexao) or die(mysql_error());
	$row_rs_contar_item = mysql_fetch_assoc($rs_contar_item);
	$totalRows_rs_contar_item = mysql_num_rows($rs_contar_item);
	
	do{
		$qntItens +=  $row_rs_contar_item['quantidade_produto'];
	}while($row_rs_contar_item = mysql_fetch_assoc($rs_contar_item));*/
}
if(basename($_SERVER['SCRIPT_NAME']) == 'editar-lavanderia.php'){
	mysql_select_db($database_conexao, $conexao);
 	$query_rs_editar_item = "SELECT tbl_item.*,
									tbl_produto.nome as nomeProduto, 
									tbl_produto.pontuacao as Pontuacao, 
									tbl_produto.valor_venda as valorVenda, 
									tbl_produto.numeracao as numeracao, 
									tbl_produto.id_cor as id_cor,
									tbl_cores.nome as cor
							   FROM tbl_item 
							   left join 
							        tbl_produto on tbl_item.nome_produto = tbl_produto.id
							   left join
							        tbl_cores on tbl_item.id_cor = tbl_cores.id
							   where 
							        tbl_item.id_lavanderia = '{$_GET['id']}'";
	$rs_editar_item = mysql_query($query_rs_editar_item, $conexao) or die(mysql_error());
	//$row_rs_editar_item = mysql_fetch_assoc($rs_editar_item);
	$totalRows_rs_editar_item = mysql_num_rows($rs_editar_item);
	
	
	if($_GET['qtdItens'] == '') {
		$_GET['qtdItens'] = $totalRows_rs_editar_item;
	}
}

if(basename($_SERVER['SCRIPT_NAME']) == 'editar_reserva.php'){
	mysql_select_db($database_conexao, $conexao);
 	$query_rs_editar_item = "SELECT tbl_item.*,
									tbl_produto.nome as nomeProduto, 
									tbl_produto.pontuacao as Pontuacao, 
									tbl_produto.valor_venda as valorVenda, 
									tbl_produto.numeracao as numeracao, 
									tbl_produto.id_cor as id_cor,
									tbl_cores.nome as cor
							   FROM tbl_item 
							   left join 
							        tbl_produto on tbl_item.nome_produto = tbl_produto.id
							   left join
							        tbl_cores on tbl_item.id_cor = tbl_cores.id
							   where 
							        tbl_item.id_reserva = '{$_GET['id']}'";
	$rs_editar_item = mysql_query($query_rs_editar_item, $conexao) or die(mysql_error());
	//$row_rs_editar_item = mysql_fetch_assoc($rs_editar_item);
	$totalRows_rs_editar_item = mysql_num_rows($rs_editar_item);
	
	
	if($_GET['qtdItens'] == '') {
		$_GET['qtdItens'] = $totalRows_rs_editar_item;
	}
}
?>
<link rel="stylesheet" type="text/css" href="css.css">
<?php if(basename($_SERVER['SCRIPT_NAME']) == 'editar_contrato.php'){?>
<table width="100%" border="0" style="margin-bottom:10px;">
  <tbody>
    <tr>
      <td colspan="4" style="border-bottom:1px solid #9E9E9E;"><strong>Foram encontrados <?php echo $totalRows_rs_editar_item;?> itens.</strong></td>
    </tr>
  </tbody>
</table>
<?php }?>
<?php if(basename($_SERVER['SCRIPT_NAME']) == 'editar_reserva.php'){?>
<table width="100%" border="0" style="margin-bottom:10px;">
  <tbody>
    <tr>
      <td colspan="4" style="border-bottom:1px solid #9E9E9E;"><strong>Foram encontrados <?php echo $totalRows_rs_editar_item;?> itens.</strong></td>
    </tr>
  </tbody>
</table>
<?php }?>
<?php 
	for($i=0; $i<$_GET['qtdItens']; $i++) {
		if(basename($_SERVER['SCRIPT_NAME']) == 'editar_contrato.php') {
			$row_rs_editar_item = mysql_fetch_assoc($rs_editar_item);
		}
		if(basename($_SERVER['SCRIPT_NAME']) == 'editar-lavanderia.php') {
			$row_rs_editar_item = mysql_fetch_assoc($rs_editar_item);
		}
		if(basename($_SERVER['SCRIPT_NAME']) == 'editar_reserva.php') {
			$row_rs_editar_item = mysql_fetch_assoc($rs_editar_item);
		}
        
        
  ?>
<table width="100%" border="0" style="margin-bottom:10px;">
  <tbody>
    <tr>
      <td colspan="4" style="border-bottom:1px solid #9E9E9E;"><strong>Item <?php echo ($i+1);?>:</strong></td>
    </tr>
    <tr>
      <td width="100%" colspan="4" ><div class="row">
          <div class="col-md-12">
            <div class="col-md-1"> Nome do Produto<br>
                <?php 
				$_GET['idAtual'] = $row_rs_editar_item['nome_produto'];
				$_GET['label'] = utf8_decode($row_rs_editar_item['nomeProduto']);
				buscaGenericad('nome_produto[]', 'id', '', 'Produtos', 'nome', "parent.document.getElementById('enviaItens').src='pega-valor-prods.php?id=[id]&nItem={$i}&data_retirada='+parent.document.getElementById('data_retirada').value + '&data_devolucao='+parent.document.getElementById('data_devolucao').value;", 'tbl_produto', $concatCampos, $where, "nome_produto{$i}");?>
            </div>
            
            <div class="col-md-2"> Qtde<br>
              <div class="input-prepend">
                <input type="text" name="quantidade_produto[]" onKeyUp="calcTotalProd(<?php echo $i;?>)" id="quantidade_produto<?php echo $i;?>" class="input-xxsmall" value="<?php echo ($row_rs_editar_item['quantidade_produto'] <> '') ? $row_rs_editar_item['quantidade_produto'] : 1;?>">
              </div>
            </div>
            <?php //if(basename($_SERVER['SCRIPT_NAME']) <> 'add-lavanderia.php' or basename($_SERVER['SCRIPT_NAME']) <> 'editar-lavanderia.php'){?>
            <div class="col-md-2"> Pontua&ccedil;&atilde;o<br>
              <div class="input-prepend">
                <input type="text" name="pontuacao[]" onKeyUp="calcTotalPontuacao(<?php echo $i;?>)" id="pontuacao<?php echo $i;?>" value="<?php echo $row_rs_editar_item['Pontuacao'];?>" class="input-xxsmall">
               </div>
            </div>
            <div class="col-md-2"> Valor Venda<br>
              <div class="input-prepend">
                <input type="text" onKeyUp="calcTotalProd(<?php echo $i;?>)" id="valorVenda<?php echo $i;?>" value="<?php echo number_format($row_rs_editar_item['valorVenda'],2,',','.');?>" class="input-xxsmall">
               </div>
            </div>
            <?php //}?>
            <div class="col-md-2"> Tamanho<br>
              <div class="input-prepend">
                <input type="text" name="numeracao[]" id="numeracao<?php echo $i;?>" class="input-xxsmall" value="<?php echo $row_rs_editar_item['numeracao'];?>">
              </div>
            </div>
            <div class="col-md-1"> Cor<br>
              <div class="input-prepend">
                <input type="text" name="id_cor[]" id="id_cor<?php echo $i;?>" class="input-xxsmall" value="<?php echo $row_rs_editar_item['nomeCor'];?>">
              </div>
            </div>
          </div>
        </div></td>
    </tr>
    <?php if(basename($_SERVER['SCRIPT_NAME']) == 'editar_contrato.php'){?>
    <tr>
    	<td>
    		<div class="row">
          <div class="col-md-12">
         
            <div class="col-md-2"> Devolvido em<br>
              <div class="input-prepend">
                <input type="date" name="devolvido_em[]" id="devolvido_em<?php echo $i;?>" class="input-xxsmall" value="<?php echo $row_rs_editar_item['devolvido_em'];?>">
                <span class="add-on"><i class="icon-calendar"></i></span> </div>
            </div>
          </div>
        </div>
    	</td>
    </tr>
   <?php }?>
  </tbody>
</table>
<?php $somaPontos += $row_rs_editar_item['Pontuacao'];?>
<?php  $somavalor += $row_rs_editar_item['valorVenda'];?>
<?php } ?>
<?php if(basename($_SERVER['SCRIPT_NAME']) == 'add_contrato.php'){?>
<input type="" name="somaPontos" value="<?php echo $somaPontos;?>">
<?php }?>

<?php if(basename($_SERVER['SCRIPT_NAME']) == 'editar_contrato.php'){?>
<table width="100%" border="0" style="margin-bottom:10px;">
  <tbody>
    <tr>
      <td colspan="4" style="border-bottom:1px solid #9E9E9E;"><strong>Total de <?php echo $somaPontos;?> pontos.</strong></td>
      <input type="hidden" name="somaPontos" value="<?php echo $somaPontos;?>">
    </tr>
  </tbody>
</table>
<?php }?>

<!--Valor total-->


<?php if(basename($_SERVER['SCRIPT_NAME']) == 'add_contrato.php'){?>
<input type="" name="somaPontos" value="<?php echo $somavalor;?>">
<?php }?>

<?php if(basename($_SERVER['SCRIPT_NAME']) == 'editar_contrato.php'){?>
<table width="100%" border="0" style="margin-bottom:10px;">
  <tbody>
    <tr>
      <td colspan="4" style="border-bottom:1px solid #9E9E9E;"><strong>Valor total: <?php echo number_format($somavalor,2,',','.');?></strong></td>
      <input type="hidden" name="somaValor" value="<?php echo $somavalor;?>">
    </tr>
  </tbody>
</table>
<?php }?>
<!--Final Valor Total-->
<script>
function calcTotalProd(nItem) { 
	document.getElementById('valor_total_produto'+nItem).value=number_format(document.getElementById('quantidade_produto'+nItem).value*valorCalculavel(document.getElementById('valor_unitario_produto'+nItem).value),2,',','.');
	
	calcTotal();
}

function calcTotal() {
	document.getElementById('totalItens').value = <?php
	for($i=0; $i<$_GET['qtdItens']; $i++) {
		$scriptSoma .= "document.getElementById('valor_total_produto{$i}').value+";
	}
	
	echo substr($scriptSoma,0,-1);
	?>
}
</script>

<input type="hidden" name="totalItens" id="totalItens">
<iframe src="" frameborder="0" name="enviaItens" id="enviaItens" style="display:none;"></iframe>