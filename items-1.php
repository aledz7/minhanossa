

<?php
include('Connections/conexao.php');
include('funcoes.php');


if($_GET['pagina'] == '') {
	$inicio = 0;
	if($_SESSION['clienteLogado'] == ''){
		$limite = 5;
	} else {
		$limite = 6;
	}
	$_GET['pagina'] = 0;
} else {
	$inicio = $_GET['pagina']*6;
	$limite = 6;
}


mysql_select_db($database_conexao, $conexao);
//$query_rs_roupas = "SELECT * FROM tbl_pecas ORDER BY id DESC limit {$inicio},{$limite}";
$query_rs_roupas = "SELECT * FROM tbl_pecas ORDER BY id DESC limit 0,2";
$rs_roupas = mysql_query($query_rs_roupas, $conexao) or die( mysql_error());
$row_rs_roupas = mysql_fetch_assoc($rs_roupas);
$total_rows_rs_roupas = mysql_num_rows($rs_roupas);


mysql_select_db($database_conexao, $conexao);
$query_rs_cats = "SELECT * FROM tbl_cats ORDER BY ID ASC";
$rs_cats = mysql_query($query_rs_cats, $conexao) or die(mysql_error());
$row_rs_cats = mysql_fetch_assoc($rs_cats);
$totalRows_rs_cats = mysql_num_rows($rs_cats);


include('funcoes/cortar-imagem.php');
  $i=0;
	if($total_rows_rs_roupas > 0) {
	  do { $i++;
?>

									<div class="col-12 col-sm-6 col-lg-3 isotope-item <?php echo $row_rs_cats['id'];?>">
										<div class="thumbnail">
											<a href="desc-minhas-pecas.php?id=<?php echo $row_rs_roupas['id']?>">
												<?php $img_reduz_peca = "sistema/img_noticias/".cortaImagem($row_rs_roupas['foto'], 'sistema/img_noticias', '360', '500', 'img_reduz_peca', '#FFFFFF');?>
												<img src="<?php echo $img_reduz_peca;?>" alt="<?php echo $row_rs_roupas['titulo']?>" class="img_mod">
											</a>
											<div class="caption deg-produto-rosa text-left caption-color" style="padding: 53px 10px 0px;">

												<a href="add-lista-desejos.php?id_produto=<? echo $row_rs_roupas['id'];?>"><h5 style="color: #FFFFFF;">Clique e descubra mais</h5></a>
												<div class="clearfix">&nbsp;</div>
												<a href="add-lista-desejos.php?id_produto=<? echo $row_rs_roupas['id'];?>">
													<div class="estrela">
														<i class="fa fa-star"></i>
													</div>
												</a>
											</div>
										</div>
									</div>





								<?php if($i == 2 and $_GET['pagina'] < 1 and $_SESSION['clienteLogado'] == ''){ ?>
									<div class="col-12 col-sm-6 col-lg-3 isotope-item">
										<div class="thumbnail">
											<div class="caption text-center" style="color: #f05b66">
												<h4>Faça sua wishlist!</h4>
												
										<form method="POST" action="login.php" class="login" name="formLogin" id="formLogin" class="form-inline" role="form">
											<div class="form-group text-center">
												<label for="" style="color: #c6d5ed;font-weight: 100;">Login</label>
												<input type="text" style="text-align: center; border: none" class="form-control" id="" name="email">
											</div>
											<hr class="traco">
											<div class="form-group text-center">
												<label for="" style="color: #c6d5ed;font-weight: 100;">Senha</label>
												<!--<input type="password" style="text-align: center; border: none" class="form-control" id="" name="senha">-->
												<input class="form-control" name="senha" type="password" style="text-align: center; border: none" required="">
											</div>
											<hr class="traco">
											<span class="input-group-btn btn-lg text-center">
												<!--<button type="button" style="border-color: #d76e79; color: #d76e79; border-radius: 0; padding: 15px 45px 15px;" class="btn btn-default" onClick="document.getElementById('formLogin').submit()">Entrar</button>-->
												<button type="submit" style="border-color: #d76e79; color: #d76e79; border-radius: 0; padding: 15px 45px 15px;" class="btn btn-default">Entrar</button>
											</span>
										   	<span class="text-center" style="color: #c6d5ed;font-weight: 100; font-size: 11px;">
												<a href="esqueci-minha-senha.php">ESQUECI MINHA SENHA</a></span>
												<span class="input-group-btn btn-lg text-center">
													<a href="cadastrar.php" class="btn btn-default" style="background-color: #d76e79; color: #fff; border: none; padding: 20px 51px 17px; margin-left: -10px; border-radius: 0;">Criar login</a>
												</span>
												<input type="hidden" name="acao" value="login.php">
										</form>
												
											</div>
										</div>
									</div>
									<?php } ?>
										<?php } while($row_rs_roupas = mysql_fetch_assoc($rs_roupas));
									} ?>
									<div id="janela_pagina<?php echo $_GET['pagina'];?>"></div>
