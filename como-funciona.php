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
	<link rel="stylesheet" type="text/css" href="css/planos.css">
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
	<!--<img src="https://www.minhanossa.net.br/images/banner-principal-topo.gif" class="img-responsive">
		<div class="row infor">
			<div class="col-md-12">
				<p class="centro"><img class="imagem" src="images/banner-princ.gif"></p>
			</div>
		</div>-->
		<br>

		<div class="container">
			<div class="row row-centered" style="background-color: #fff; padding-top: 40px;">
				<div class="col-xs-12 col-sm-10 col-md-10 col-lg-10 col-centered">
					<div class="col-md-12 no-padding lib-item pull-right" data-category="view">
						<div class="lib-panel">
							<div class="row box-shadow">
								<div class="borda-sobre1">
									&nbsp;
									<div class="botao-termos">
										<a href="termos.php">termos & condições de uso</a>
									</div>
								</div>

								<div class="col-md-6">
									<div class="lib-row lib-header">
										<h1>como funciona</h1>
										<div class="lib-header-seperator"></div>
									</div>
									<?php $comoFunciona = $textos->rsDados(1);?>
									<div class="lib-row lib-desc">
										<?php echo $comoFunciona->textos;?>
									</div>
								</div>
								<div class="col-md-6">
									<img class="lib-img-show" src="images/loja2.jpg" style="width: 476px; margin-left: 13px;">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		</div></div>
	<!--<section class="infor">
				
			<div class="col-md-12">
				<p class="centro"><img class="imagem" src="images/banner-princ.gif"></p>
				
			</div>

	</section>-->

		
	</section>




	<br>
	<br>
	<br>
<!--
	<section>

		<div class="container">
			<div class="row row-centered">
				<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 col-centered">
					<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
						<div class="thumbnail">
							<img src="images/minha-nossa.png" alt="">
							<div class="caption text-center">
								<h4>mas como funciona?</h4>

							</div>
						</div>
					</div>
					<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
						<div class="thumbnail">
							<img src="images/icone-camisa.png" alt="">
							<div class="caption text-center">
								<h4>escolha uma peça limpinha</h4>

							</div>
						</div>
					</div>
					<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
						<div class="thumbnail">
							<img src="images/icone-girl.png" alt="">
							<div class="caption text-center">
								<h4>arrase no look</h4>
								<div class="clearfix">&nbsp;</div>
							</div>
						</div>
						<i class="fa fa-angle-double-right seta-span hidden-xs"></i>
						<i class="fa fa-angle-double-down seta-span-down hidden-sm hidden-md hidden-lg"></i>
					</div>



					<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
						<div class="thumbnail">
							<img src="images/icone-maquina.png" alt="">
							<div class="caption text-center">
								<h4>devolva sem precisar lavar</h4>

							</div>
						</div>
						<i class="fa fa-angle-double-right seta-span hidden-xs"></i>
						<i class="fa fa-angle-double-down seta-span-down hidden-sm hidden-md hidden-lg"></i>
					</div>
				</div>
			</div>
		</div>
	</section>
-->






    <section>
    	
		<div class="row amarelo">
			<div class="container">					
				<h1 class="tit">MEUS PLANOS</h1>
				<h1 class="tit">Clique no seu preferido e assine</h1>
				<h2 class="subt">
					Sem fidelidade, você escolhe o que melhor te veste a cada mês. <br> Ah, e a lavagem é por minha conta ;
				</h2>
			</div>
		</div>

    </section>


	<section id="planos" class="banner">

		
<div class="container mt-5 espaco">

	<div class="row">
		<div class="col-lg-12 col-sm-12 col-12 main-section">
			<div class="row text-center">

				<div class="col-lg-6 col-sm-4 col-12 margem">
					<div class="row-fluid section">
						<div class="col-lg-6 col-sm-6 col-6">
							<img src='images/phyna-1.jpg'>							
						</div>
						<div class="col-lg-6 col-sm-6 col-6 text-left">
							<div class="row user-detail">
								<div class="col-lg-12 col-sm-12 col-12 text-left">
										<h1>PHYNA</h1>
										<p>2 PEÇAS POR MÊS</p>
										<a href="https://pag.ae/7VUHpjujp" target="_blank">
										<button class="btn btn-primary preco">R$ 90,00</button></a>
								</div>
							</div>
						</div>
					</div>
				</div>




				<div class="col-lg-6 col-sm-4 col-12 margem">
					<div class="row-fluid section">
						<div class="col-lg-6 col-sm-6 col-6">
							<img src='images/plena-1.jpg'>							
						</div>

						<div class="col-lg-6 col-sm-6 col-6 text-left">
							<div class="row user-detail">
								<div class="col-lg-12 col-sm-12 col-12 text-left">
										<h1>PLENA</h1>
										<p>4 PEÇAS POR MÊS</p>
										<a href="https://pag.ae/7VUHpYScK" target="_blank">
										<button class="btn btn-primary preco">R$ 176,00</button></a>
								</div>
							</div>
						</div>
					</div>
				</div>





				<div class="col-lg-6 col-sm-4 col-12 margem">
					<div class="row-fluid section">
						<div class="col-lg-6 col-sm-6 col-6">
							<img src='images/musa-1.jpg'>							
						</div>

						<div class="col-lg-6 col-sm-6 col-6 text-left">
							<div class="row user-detail">
								<div class="col-lg-12 col-sm-12 col-12 text-left">
										<h1>MUSA</h1>
										<p>6 PEÇAS POR MÊS</p>
										<a href="https://pag.ae/7VUHqhfEq" target="_blank">
										<button class="btn btn-primary preco">R$ 261,00</button></a>
								</div>
							</div>
						</div>
					</div>
				</div>




				<div class="col-lg-6 col-sm-4 col-12 margem">
					<div class="row-fluid section">
						<div class="col-lg-6 col-sm-6 col-6">
							<img src='images/diva-1.jpg'>							
						</div>

						<div class="col-lg-6 col-sm-6 col-6 text-left">
							<div class="row user-detail">
								<div class="col-lg-12 col-sm-12 col-12 text-left">
										<h1>DIVA</h1>
										<p>8 PEÇAS POR MÊS</p>
										<a href="https://pag.ae/7VUHqtRM6" target="_blank">
										<button class="btn btn-primary preco">R$ 336,00</button></a>
								</div>
							</div>
						</div>
					</div>
				</div>




				<!-- <div class="col-lg-6 col-sm-4 col-12 margem">
							<?php $planoAvulso = $planos->rsDados(12, 'S'); 
							   		 $planoAvulso->id = 7;
							   ?>
					<div class="row-fluid section">
						<div class="col-lg-6 col-sm-6 col-6">
							<?php
							if($plano->foto =='')
								{
									echo "<img src='img_noticias/sem-foto.jpg'>";
								}

								else {
									echo "<img src='sistema/img_noticias/$plano->foto'>";
								}

							?>	
						</div>

						<div class="col-lg-6 col-sm-6 col-6 text-left">
							<div class="row user-detail">
								<div class="col-lg-12 col-sm-12 col-12 text-left">
										<h1><?php echo utf8_decode($planoAvulso->nome); ?></h1>
										<p>2 PEÇAS POR MÊS</p>
										<a href="criar-conta-plano.php?plano=<?php echo $plano->id?>">
										<button class="btn btn-primary preco"><?=number_format($plano->valor,2,',','.');?></button></a>
								</div>
							</div>
						</div>
					</div>
				</div> -->




			</div>


		</div>


	</div>
</div>


	</section>










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