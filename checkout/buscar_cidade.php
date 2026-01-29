<?php 
include('Connections/conexao.php');
include('funcoes.php');

mysql_select_db($database_conexao, $conexao);
$query_rs_cidade = "SELECT * FROM dados_cidades WHERE id_estado = '".$_GET['estado']."' ORDER BY nome ASC";
$rs_cidade = mysql_query($query_rs_cidade, $conexao) or die(mysql_error());
$row_rs_cidade = mysql_fetch_assoc($rs_cidade);
$totalRows_rs_cidade = mysql_num_rows($rs_cidade); 
?>
<!--<link href="css.css" rel="stylesheet" type="text/css" />-->
<select name="id_cidade" id="id_cidade" class="email s-email">
        <option value="">Cidade</option>
        <? do { ?>
         <option value="<?php echo $row_rs_cidade['id'] ?>">
          <?php echo $row_rs_cidade['nome'] ?>
         </option>
        <? } while($row_rs_cidade = mysql_fetch_assoc($rs_cidade)); ?>
</select>
<input type="hidden" name="id_estado" id="id_estado" value="<?php echo $_GET['estado']?>" />
<?
mysql_free_result($rs_cidade);
?>

      