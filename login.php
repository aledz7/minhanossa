<?php 
if (!isset($_SESSION)) { session_start(); }

include('Connections/conexao.php'); 
include('funcoes.php');

include('class/clientes.php');
$clientes = Clientes::getInstance(Conexao::getInstance());

if($_GET['volta'] == 'lista_desejos') {
	$volta = $_SESSION['volta_login']; 
} elseif($_GET['volta'] <> '') {
	$volta = $_GET['volta'];
} else {
	$volta = 'lista-de-desejos.php';
}
$clientes->login($_POST['email'], $_POST['senha'], $volta);

?>

<!DOCTYPE html>
<html lang="pt_BR">
	<head>
		<title>Minha Nossa! - Multimarcas de Empréstimos de Roupas em Brasília DF</title>
		<meta charset="UTF-8">
		<meta name="author" content="DFinformatica">
		<meta name="keywords" content="roupas">
		<meta name="description" content="Transformando o guarda-roupa feminino em um universo de possibilidades">
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
		<!-- Ultima versão compactada BOOTSTRAP.CSS -->
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/font-awesome.min.css">
		<link rel="stylesheet" href="css/animate.css">
		<link href="css/style.css" rel="stylesheet">
		<link rel="stylesheet" href="dist/css/lightbox.css">
		<link rel="shortcut icon" href="images/fav.png" type="image/x-icon" />
		<style>
			.more_add {
				background-color: #fff;
				font-weight: 700;
				color: #d76e79;
				border: 2px solid #d76e79;
				padding: 7px 30px 14px;
				margin-left: 0px;
				margin-top: 25px;
				margin-bottom: 25px;
			}
			.foto{
				margin-bottom: 20px;
			}
			.img_mod{
				width: 100%;
			}
			.mg-lft-15p{
				margin-left: 10px;
			}
			.icom{
				color: #d76e79;
			}
			.icom:hover{
				color: #21294d;
			}
			.traco{
					margin-top: -12px!important;
						margin-bottom: 28px;
			}
		</style>
		
     </head>
        <body>
          <?php include('header.php');?>
			
			<div class="col-sm-4 foto">
		
	</div>
          <div class="col-sm-4 foto">
			<!--<div class="thumbnail" style=" padding-bottom: 184px;">-->
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


	  	<div class="clearfix">&nbsp;</div>
	   <div class="clearfix">&nbsp;</div>
	  <div class="clearfix">&nbsp;</div>
	 <div class="clearfix">&nbsp;</div>
	 <div class="clearfix">&nbsp;</div>
	 <div class="clearfix">&nbsp;</div>
	 <div class="clearfix">&nbsp;</div>
	 <div class="clearfix">&nbsp;</div>
	 <div class="clearfix">&nbsp;</div>
				<?php include('footer.php');?>
			</body>
          <!-- Latest compiled and minified JS -->
          <script src="js/jquery-3.2.1.min.js"></script>
          <script src="js/bootstrap.min.js"></script>
          <script src="js/script.js"></script>
          <script src="dist/js/lightbox-plus-jquery.min.js"></script>
          <script src="load.js"></script>
					<script>
							function bt_add() {
								var proxima_pagina = parseInt(document.getElementById('n_pagina_atual').value)+1;
								var url = 'mais-pecas.php?pagina='+proxima_pagina;
								//alert(url);
								AtualizaJanela(url, 'pagina'+document.getElementById('n_pagina_atual').value);
								document.getElementById('n_pagina_atual').value = proxima_pagina;
							}
						</script> 
</html>