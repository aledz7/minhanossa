<?php
include('class/textos.php');
$textos = Textos::getInstance(Conexao::getInstance());

include('class/planos.php');
$planos = Planos::getInstance(Conexao::getInstance());

include( 'class/clientes.php');
$clientes = Clientes::getInstance( Conexao::getInstance());
$clientes->login( $_POST[ 'login' ], $_POST[ 'senha' ], 'perfil-usuario.php');
?>
<!DOCTYPE html>
<html lang="pt_BR">
<head>
	<title>Seu closet infinito e estiloso.  Assinatura mensal e aluguel avulso</title>
	<meta charset="utf-8">
	<meta name="author" content="DFinformatica">
	<meta name="keywords" content="roupas">
	<meta name="description" content="Transformando o guarda-roupa feminino em um universo de possibilidades">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<!-- Ultima versão compactada BOOTSTRAP.CSS -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/animate.css">
	<link href="css/style.css" rel="stylesheet">
	<link rel="shortcut icon" href="images/fav.png" type="image/x-icon" />
	<!-- Global Site Tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-133752527-1"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());
		gtag('config', 'UA-133752527-1');
	</script>
</head>
<body>
	<style>
	.yell {
		background: #f0e6dd !important;
	}
	.imagem {
    	width: 50%;

	}
	.infor {
		background: #4155a1;
    	display: flex !important;
	}
    .centro {
    	text-align:center !important;
    	margin: 0 0 0px !important;
    }
	</style>
	<?php include('header.php');?>

	<style>
	.borda-sobre1 {
		border: 2px solid #d76e79;
		padding: 242px 354px 160px;
		margin: 79px 0 0;
		position: absolute;
		z-index: 9;
	}
		
  	@media screen and (min-width: 1400px){
		.navbar-collapse {
			padding-left: 24%;
		}
	}
	</style>

	<section class="slide-wrapper">
		<div class="banner" style="padding: 0px 0 0">
			<img src="minhanossa.gif" class="img-responsive">
			<div class="row infor">
				<div class="col-md-12">
					<p class="centro"><img class="imagem" src="images/banner-princ.gif"></p>		
				</div>
			</div>
			<br>
		</div></div>
	<!--<section class="infor">
				
			<div class="col-md-12">
				<p class="centro"><img class="imagem" src="images/banner-princ.gif"></p>		
			</div>
	</section>-->
	</section>
	<!--- INTRO -->
	<?php include('destaques.php'); ?>
	<!-- END INTRO -->
<!--
	<div class="clearfix">&nbsp;</div>
	<div class="clearfix">&nbsp;</div>
	<div class="clearfix">&nbsp;</div>
	<div class="clearfix">&nbsp;</div>
	<div class="clearfix">&nbsp;</div>
	<div class="clearfix">&nbsp;</div>
	<div class="clearfix">&nbsp;</div>
	<div class="clearfix">&nbsp;</div>
	<div class="clearfix">&nbsp;</div>
-->
	<?php include('footer.php');?>
</body>
<!-- Latest compiled and minified JS -->
<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/script.js"></script>
</html>