<?php 
include('Connections/conexao.php'); 
include('funcoes.php');

if(basename($_SERVER['SCRIPT_NAME']) == 'editar_contrato.php'){
	mysql_select_db($database_conexao, $conexao);
	$query_rs_editar_pagamento = "SELECT * FROM tbl_pagamento where id_contrato = '{$_GET['id']}'";
	$rs_editar_pagamento = mysql_query($query_rs_editar_pagamento, $conexao) or die(mysql_error());
	//$row_rs_editar_pagamento = mysql_fetch_assoc($rs_editar_pagamento);
	$totalRows_rs_editar_pagamento = mysql_num_rows($rs_editar_pagamento);
	
	if($_GET['qtdPago'] == '') {
		$_GET['qtdPago'] = $totalRows_rs_editar_pagamento;
	}
}
?>
<link rel="stylesheet" type="text/css" href="css.css">
<?php 
	for($i=0; $i<$_GET['qtdPago']; $i++) {
		if(basename($_SERVER['SCRIPT_NAME']) == 'editar_contrato.php') {
			$row_rs_editar_pagamento = mysql_fetch_assoc($rs_editar_pagamento);
		}
  ?>
<table width="100%" border="0">
  <tbody>
    <tr>
      <td colspan="4" style="border-bottom:1px solid #9E9E9E;">Pagamento
        <?=($i+1);?>
        :</td>
    </tr>
    <tr>
      <td width="100%" colspan="4" ><div class="row">
          <div class="col-md-12">
            <div class="col-md-2"> Data<br>
              <div class="input-prepend">
                <input type="date" name="data_pagamento[]" id="data_pagamento<?=$i;?>" class="input-xsmall" value="<?=$row_rs_editar_pagamento['data_pagamento'];?>" >
                <span class="add-on"><i class="iconfa-calendar"></i></span> </div>
            </div>
            <div class="col-md-3"> Forma de Pagamento<br>
              <div class="input-prepend">
                <select name="forma_pagamento[]" id="forma_pagamento<?=$i;?>">
                  <option>Selecione</option>
                  <option value="1" <?php if($row_rs_editar_pagamento['forma_pagamento'] == 1){ echo "selected";}?> >Dinheiro</option>
                  <option value="2" <?php if($row_rs_editar_pagamento['forma_pagamento'] == 2){ echo "selected";}?>>Cheque</option>
                  <option value="3" <?php if($row_rs_editar_pagamento['forma_pagamento'] == 3){ echo "selected";}?>>1x no Cart&atilde;o</option>
                  <option value="4" <?php if($row_rs_editar_pagamento['forma_pagamento'] == 4){ echo "selected";}?>>2x no Cart&atilde;o</option>
                  <option value="5" <?php if($row_rs_editar_pagamento['forma_pagamento'] == 5){ echo "selected";}?>>3x no Cart&atilde;o</option>
                </select>
              </div>
            </div>
            <div class="col-md-2"> Parcelas<br>
              <div class="input-prepend">
                <input type="text" name="parcela_pagamento[]" id="parcela_pagamento<?=$i;?>" class="input-xxsmall" value="<?=($row_rs_editar_pagamento['parcelas'] <> '') ? $row_rs_editar_pagamento['parcelas'] : 1;?>">
              </div>
            </div>
            <div class="col-md-2"> Valor Pagamento<br>
              <div class="input-prepend">
                <input type="text" name="valor_pagamento[]" id="valor_pagamento<?=$i;?>" value="<?=$row_rs_editar_pagamento['valor_pagamento'];?>" class="input-xxsmall">
                <span class="add-on"><i class="fa fa-usd" aria-hidden="true"></i></span> </div>
            </div>
          </div>
        </div></td>
    </tr>
  </tbody>
</table>
<? } ?>
<iframe name="buscaArquivo" id="buscaArquivo" style="display:none"></iframe>
<?php
for($i=0; $i<$_GET['qtdPago']; $i++) {
	?>
    <script>
	//alert(document.getElementById('totalItens').value);
	document.getElementById('valor_pagamento<?=$i;?>').value = number_format(valorCalculavel(document.getElementById('totalItens').value)/<?=$_GET['qtdPago'];?>,2,',','.');
	</script>
    <?
}
?>