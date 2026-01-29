<?php 
include('Connections/conexao.php'); 
include('funcoes.php');

session_start();

mysql_select_db($database_conexao, $conexao);
$query_rs_itens_produtos = "SELECT * FROM tbl_produto ORDER BY nome ASC";
$rs_itens_produtos = mysql_query($query_rs_itens_produtos, $conexao) or die(mysql_error());
$row_rs_itens_produtos = mysql_fetch_assoc($rs_itens_produtos);
$totalRows_rs_itens_produtos = mysql_num_rows($rs_itens_produtos);

if(basename($_SERVER['SCRIPT_NAME']) == 'editar_contrato.php'){
	mysql_select_db($database_conexao, $conexao);
	$query_rs_editar_item = "SELECT tbl_item.*, tbl_produto.nome as nomeProduto FROM tbl_item left join tbl_produto on tbl_item.nome_produto = tbl_produto.id where tbl_item.id_contrato = '{$_GET['id']}'";
	$rs_editar_item = mysql_query($query_rs_editar_item, $conexao) or die(mysql_error());
	//$row_rs_aulasAtuais = mysql_fetch_assoc($rs_aulasAtuais);
	$totalRows_rs_editar_item = mysql_num_rows($rs_editar_item);
	
	
	if($_GET['qtdItens'] == '') {
		$_GET['qtdItens'] = $totalRows_rs_editar_item;
	}
}
?>
<link rel="stylesheet" type="text/css" href="css.css">

<?php 
	for($i=0; $i<$_GET['qtdItens']; $i++) {
		if(basename($_SERVER['SCRIPT_NAME']) == 'editar_contrato.php') {
			$row_rs_editar_item = mysql_fetch_assoc($rs_editar_item);
		}
  ?>
<table width="100%" border="0" style="margin-bottom:10px;">
  <tbody>
    <tr>
      <td colspan="4" style="border-bottom:1px solid #9E9E9E;"><strong>Item <?=($i+1);?>:</strong></td>
    </tr>
    <tr>
      <td width="100%" colspan="4" ><div class="row">
          <div class="col-md-12">
            
            <div class="col-md-3"> Nome do Produto<br>
             
                <?php 
				$_GET['idAtual'] = $row_rs_editar_item['nome_produto'];
				$_GET['label'] = $row_rs_editar_item['nomeProduto'];
				buscaGenericad('nome_produto[]', 'id', '', 'Produtos', 'nome', "parent.document.getElementById('enviaItens').src='pega-valor-prods.php?id=[id]&nItem={$i}';", 'tbl_produto', $concatCampos, $where, "nome_produto{$i}");?>
                
           
            </div>
            
            
            
            <div class="col-md-2"> Qtde<br>
              <div class="input-prepend">
                <input type="text" name="quantidade_produto[]" onKeyUp="calcTotalProd(<?=$i;?>)" id="quantidade_produto<?=$i;?>" class="input-xxsmall" value="<?=($row_rs_editar_item['quantidade_produto'] <> '') ? $row_rs_editar_item['quantidade_produto'] : 1;?>">
              </div>
            </div>
            <div class="col-md-2"> Valor Unit&aacute;rio<br>
              <div class="input-prepend">
                <input type="text" name="valor_unitario_produto[]" onKeyUp="calcTotalProd(<?=$i;?>)" id="valor_unitario_produto<?=$i;?>" value="<?=$row_rs_editar_item['valor_unitario_produto'];?>" class="input-xxsmall">
                <span class="add-on"><i class="fa fa-usd" aria-hidden="true"></i></span> </div>
            </div>
            <div class="col-md-2"> Desconto<br>
              <div class="input-prepend">
                <input type="text" name="desconto_produto[]" id="desconto_produto<?=$i;?>" class="input-xxsmall" value="<?=$row_rs_editar_item['desconto_produto'];?>">
              </div>
            </div>
            <div class="col-md-2"> Valor Total<br>
              <div class="input-prepend">
                <input type="text" name="valor_total_produto[]" id="valor_total_produto<?=$i;?>" value="<?=$row_rs_editar_item['valor_total_produto'];?>" readonly class="input-xxsmall">
                <span class="add-on"><i class="fa fa-usd" aria-hidden="true"></i></span> </div>
            </div>
          </div>
        </div></td>
    </tr>
    <tr>
      <td><div class="row">
          <div class="col-md-12">
           <?php /*?> <div class="col-md-2"> Data da Prova<br>
              <div class="input-prepend">
                <input type="date" name="data_prova[]" id="data_prova<?=$i;?>" class="input-xxsmall" value="<?=$row_rs_editar_item['data_prova'];?>" >
                <span class="add-on"><i class="icon-calendar"></i></span> </div>
            </div><?php */?>
            <div class="col-md-2"> Data da Retirada<br>
              <div class="input-prepend">
                <input type="date" name="data_retirada[]" id="data_retirada<?=$i;?>" class="input-xxsmall" value="<?=$row_rs_editar_item['data_retirada'];?>">
                <span class="add-on"><i class="icon-calendar"></i></span> </div>
            </div>
            <div class="col-md-2"> Data de Devolu&ccedil;&atilde;o<br>
              <div class="input-prepend">
                <input type="date" name="data_devolucao[]" id="data_devolucao<?=$i;?>" class="input-xxsmall" value="<?=$row_rs_editar_item['data_devolucao'];?>">
                <span class="add-on"><i class="icon-calendar"></i></span> </div>
            </div>
           <?php /*?> <div class="col-md-2"> Retirado em<br>
              <div class="input-prepend">
                <input type="date" name="retirado_em[]" id="retirado_em<?=$i;?>" class="input-xxsmall" value="<?=$row_rs_editar_item['retirado_em'];?>">
                <span class="add-on"><i class="icon-calendar"></i></span> </div>
            </div>
            <div class="col-md-2"> Devolvido em<br>
              <div class="input-prepend">
                <input type="date" name="devolvido_em[]" id="devolvido_em<?=$i;?>" class="input-xxsmall" value="<?=$row_rs_editar_item['devolvido_em'];?>">
                <span class="add-on"><i class="icon-calendar"></i></span> </div>
            </div><?php */?>
            
          </div>
        </div>
       <?php /*?>
        <div class="row">
          <div class="col-md-12">
            <div class="col-md-2"> Busto<br>
              <div class="input-prepend">
                <input type="text" name="busto[]" id="busto<?=$i;?>" class="input-xxsmall" value="<?=$row_rs_editar_item['busto'];?>" >
                <span class="add-on"><i class="icon-certificate"></i></span> </div>
            </div>
            <div class="col-md-2"> Cintura<br>
              <div class="input-prepend">
                <input type="text" name="cintura[]" id="cintura<?=$i;?>" class="input-xxsmall" value="<?=$row_rs_editar_item['cintura'];?>">
                <span class="add-on"><i class="icon-certificate"></i></span> </div>
            </div>
            <div class="col-md-2"> Quadril<br>
              <div class="input-prepend">
                <input type="text" name="quadril[]" id="quadril<?=$i;?>" class="input-xxsmall" value="<?=$row_rs_editar_item['quadril'];?>">
                <span class="add-on"><i class="icon-certificate"></i></span> </div>
            </div>
            <div class="col-md-2"> Corpo<br>
              <div class="input-prepend">
                <input type="text" name="corpo[]" id="corpo<?=$i;?>" class="input-xxsmall" value="<?=$row_rs_editar_item['corpo'];?>">
                <span class="add-on"><i class="icon-certificate"></i></span> </div>
            </div>
            <div class="col-md-2"> Saia<br>
              <div class="input-prepend">
                <input type="text" name="saia[]" id="saia<?=$i;?>" class="input-xxsmall" value="<?=$row_rs_editar_item['saia'];?>">
                <span class="add-on"><i class="icon-certificate"></i></span> </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="col-md-2"> Paleto<br>
              <div class="input-prepend">
                <input type="text" name="paleto[]" id="paleto<?=$i;?>" class="input-xxsmall" value="<?=$row_rs_editar_item['paleto'];?>" >
                <span class="add-on"><i class="icon-cog"></i></span> </div>
            </div>
            <div class="col-md-2"> Comprimento<br>
              <div class="input-prepend">
                <input type="text" name="comprimento[]" id="comprimento<?=$i;?>" class="input-xxsmall" value="<?=$row_rs_editar_item['comprimento'];?>">
                <span class="add-on"><i class="icon-cog"></i></span> </div>
            </div>
            <div class="col-md-2"> Manga<br>
              <div class="input-prepend">
                <input type="text" name="manga[]" id="manga<?=$i;?>" class="input-xxsmall" value="<?=$row_rs_editar_item['manga'];?>">
                <span class="add-on"><i class="icon-cog"></i></span> </div>
            </div>
            <div class="col-md-2"> Camisa<br>
              <div class="input-prepend">
                <input type="text" name="camisa[]" id="camisa<?=$i;?>" class="input-xxsmall" value="<?=$row_rs_editar_item['camisa'];?>">
                <span class="add-on"><i class="icon-cog"></i></span> </div>
            </div>
            <div class="col-md-2"> Colete<br>
              <div class="input-prepend">
                <input type="text" name="colete[]" id="colete<?=$i;?>" class="input-xxsmall" value="<?=$row_rs_editar_item['colete'];?>">
                <span class="add-on"><i class="icon-cog"></i></span> </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="col-md-2"> Tamanho<br>
              <div class="input-prepend">
                <input type="text" name="tamanho[]" id="tamanho<?=$i;?>" class="input-xxsmall" value="<?=$row_rs_editar_item['tamanho'];?>">
                <span class="add-on"><i class="icon-cog"></i></span> </div>
            </div>
            
            <div class="col-md-2"> Colarinho<br>
              <div class="input-prepend">
                <input type="text" name="colarinho[]" id="colarinho<?=$i;?>" class="input-xxsmall" value="<?=$row_rs_editar_item['colarinho'];?>" >
                <span class="add-on"><i class="icon-asterisk"></i></span> </div>
            </div>
            <div class="col-md-2"> Cal&ccedil;a<br>
              <div class="input-prepend">
                <input type="text" name="calca[]" id="calca<?=$i;?>" class="input-xxsmall" value="<?=$row_rs_editar_item['calca'];?>">
                <span class="add-on"><i class="icon-asterisk"></i></span> </div>
            </div>
            <div class="col-md-2"> Barra<br>
              <div class="input-prepend">
                <input type="text" name="barra[]" id="barra<?=$i;?>" class="input-xxsmall" value="<?=$row_rs_editar_item['barra'];?>">
                <span class="add-on"><i class="icon-asterisk"></i></span> </div>
            </div>
            
            <div class="col-md-2"> Cintura<br>
              <div class="input-prepend">
                <input type="text" name="cintura_homem[]" id="cintura_homem<?=$i;?>" class="input-xxsmall" value="<?=$row_rs_editar_item['cintura_homem'];?>">
                <span class="add-on"><i class="icon-asterisk"></i></span> </div>
            </div>
          </div>
          
          
        </div>
        <div class="row">
          <div class="col-md-12">
            
            
            <div class="col-md-2"> Sapato<br>
              <div class="input-prepend">
                <input type="text" name="sapato[]" id="sapato<?=$i;?>" class="input-xxsmall" value="<?=$row_rs_editar_item['sapato'];?>">
                <span class="add-on"><i class="icon-asterisk"></i></span> </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12"> Coment&aacute;rio<br>
            <div class="input-prepend">
              <textarea name="comentario_item" id="comentario_item<?=$i;?>" rows="5" class="span5" placeholder="<?=texto('Informações importantes sobre o contrato');?>" style="width:1018px;"><?=$row_rs_editar_item['comentario_item'];?>
</textarea>
            </div>
          </div>
        </div>
        <?php */?>
        </td>
    </tr>
  </tbody>
</table>
<? } ?>
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