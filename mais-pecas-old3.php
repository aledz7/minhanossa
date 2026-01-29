<?php 
include('Connections/conexao.php');
include('funcoes.php');

if($_GET['pagina'] == '') {
	$inicio = 0;
	$limite = 6;
	$_GET['pagina'] = 0;
} else {
	$inicio = $_GET['pagina']*6;
	$limite = 6;
}

mysql_select_db($database_conexao, $conexao);
$query_rs_roupas = "SELECT * FROM tbl_pecas ORDER BY id DESC limit {$inicio},{$limite}";
$rs_roupas = mysql_query($query_rs_roupas, $conexao) or die( mysql_error());
$row_rs_roupas = mysql_fetch_assoc($rs_roupas);
$total_rows_rs_roupas = mysql_num_rows($rs_roupas);

include('funcoes/cortar-imagem.php');

if($total_rows_rs_roupas > 0) {
	do { ?>
	<div class="col-sm-4 foto">
		<?php $img_reduz_peca = "sistema/img_noticias/".cortaImagem($row_rs_roupas['foto'], 'sistema/img_noticias', '360', '500', 'img_reduz_peca', '#FFFFFF');?>
        <a href="desc-minhas-pecas.php?id=<?php echo $row_rs_roupas['id']?>">
        <img src="<?php echo $img_reduz_peca;?>" alt="<?php echo $row_rs_roupas['titulo']?>" class="img_mod"></a>
    </div>
<?php } while($row_rs_roupas = mysql_fetch_assoc($rs_roupas));
} ?>
<div id="janela_pagina<?php echo $_GET['pagina'];?>"></div>