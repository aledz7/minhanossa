<?php
include('Connections/conexao.php');
include('funcoes.php');

include( 'class/fotos.php' );
$fotos = Fotos::getInstance( Conexao::getInstance() );

$currentPage = 'desc-minhas-pecas.php';

mysql_select_db($database_conexao, $conexao);
$query_rs_pecas = "SELECT * FROM tbl_pecas WHERE id = '".intval($_GET['id'])."'";
$rs_pecas = mysql_query($query_rs_pecas, $conexao) or die(mysql_error());
$row_rs_pecas = mysql_fetch_assoc($rs_pecas);
$totalRows_rs_pecas = mysql_num_rows($rs_pecas);

mysql_select_db($database_conexao, $conexao);
$query_rs_fotos = "SELECT * FROM tbl_fotos  WHERE id_galeria = '".intval($_GET['id'])."' and tipo = 'Pecas'";
$rs_fotos = mysql_query($query_rs_fotos, $conexao) or die(mysql_error());
$row_rs_fotos = mysql_fetch_assoc($rs_fotos);
$totalRows_rs_fotos = mysql_num_rows($rs_fotos);

include('class/textos.php');
$textos = Textos::getInstance(Conexao::getInstance());

include( 'funcoes/cortar-imagem.php' );

?>

<!DOCTYPE html>
<html lang="pt_BR">

<!-- Head -->

<head>
	<title>Minha Nossa! - <?php echo $row_rs_pecas['tipo1'];?> Roupas em Brasília DF</title>
	<meta charset="UTF-8">
	<meta name="author" content="DFinformatica">
	<meta name="keywords" content="roupas">
	<meta name="description" content="<?php echo $row_rs_pecas['tipo1'];?> - Transformando o guarda-roupa feminino em um universo de possibilidades">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<!-- Ultima versão compactada BOOTSTRAP.CSS -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/animate.css">
	<link rel="stylesheet" href="css/demostyles.css">
	<link rel="stylesheet" href="css/responsive-carousel.fade.css">
	<link href="css/style.css" rel="stylesheet">
	<link rel="shortcut icon" href="images/fav.png" type="image/x-icon"/>
	<!--Slider-vertical-->
	<link rel="stylesheet" href="fancybox/sv-stylesheet.css">
	<link rel="stylesheet" href="fancybox/jquerysctipttop.css">
	<link rel="stylesheet" href="fancybox/jquery.fancybox.css">


</head>
<!-- Head //-->
<!-- Body -->
<body>

	<!-- Header -->
	<?php include('header.php');?>
	<!-- Header -->
	
	<style>
		
		.foto img {
			width: 360px;
			height: 503px;
			float: none;
			margin: 5px 5px;
		}
		
		.box_total {
			background-color: #fff;
			padding: 15px 25px;
		}
		
		.alt_word {
			font-size: 36px;
			margin-bottom: 20px;
			font-family: inherit;
			font-weight: 500;
			line-height: 1.1;
			color: inherit;
			margin-left: 3px;
		}
		
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
		
		.btn-default:hover {
			color: #fff!important;
			background-color: #d76e79!important;
			border-color: #d76e79!important;
		}
		
		.plus_edit {
			position: relative;
			top: 5px;
			margin-left: 16px;
			font-size: 30px;
		}
		
		.box_border {
			border: 2px solid #f8abb2;
		}
		
		.alt2{
			margin-top: 60px;
		}
		
		.banner {
			padding: 48px 0 15px!important;
		}
		.pd_rosa {
			color: #f8abb2;
			margin-top: 60px;
		}
		.pd_az_ps{
			color: #99d2d2;
		}
		.pd_az_es{
			color: #21294d;
		}
		
		.pd_rosa > h4{
			font-weight: 600;
		}
		.pd_az_ps > h4{
			font-weight: 600;
		}
		.pd_az_es > h4{
			font-weight: 600;
		}
		
		.newsletter {
    	padding: 20px 0 50px!important;
		}
		.text-left > a{
			color: #21294d;
		}
		.text-left > a:hover{
			color: #21294d;
		}
		
		

	</style>
	<style>

		.alt_f{
			width: 92px;
		}
		.alt_f2{
			width: 84px;
		}
		.alt_full{
			width: 84px;
		}
	</style>
	<style>
		
	@media screen and (min-width: 1200px){
			.pd_az_es{
				margin-bottom: 164px;
			}
			.pd_rosa {
				margin-top: 0px;
			}
			.navbar-collapse {
				padding-left: 25%;
			}
		}
		
	@media only screen and (min-width: 1024px){
		.container {
			width: 990px;
			padding: 0 5px;
		}
		.col-sm-7{
			padding-right: 5px;
    	padding-left: 0px;
		}
		.newsletter{
			width: 100%;
		}
		.box_border {
    		min-height: 580px;
			height: auto;
		}
	}	
		
	@media only screen and (width: 768px){
		
		.container {
				padding: 0 0px!important;
				width: 92%;
		}
		.col-sm-12{
		padding-right: 5px!important;
		padding-left: 0px!important;
			
		}
		.alt_full {
			width: 100%;
		}
		.gallery .previews {
    	width: 15%;
		}
		.gallery .full {
    	width: 76%;
			padding-bottom: 11px;
		}
		.alt_f{
			width: 100%;
		}
		.alt_f2{
			width: 100%;
		}
		.item_rep{
			width: 100%;
		}
		.box-news{
			margin-left: 20px;
		}
		.pd_rosa {
			margin-left: 5px;
			margin-top: 26px;
		}
		.pd_az_ps{
			margin-left: 5px;
		}
		.pd_az_es{
			margin-left: 5px;
		}
		.clearfix{
			margin-left: 0px;
			width: 100%;
		}
		.box-assine { 
			height: 85px;
		}
		.news{
			width: 70%!important;
		}
		.box-assine h1{
			font-size: 34px;
		}
		
	}
		
	@media screen and (max-width: 480px) {
			.foto img {
				width: 100%!important;
				height: auto!important;
				margin: 5px 5px;
			}
		}
	
	@media only screen and (min-width : 321px) and (max-width : 480px){

		.col-xs-12{
		padding-right: 5px!important;
    	padding-left: 10px!important;
   		width: 98%;
		}
		.container {
			padding: 0 0px!important;
			width: 89%;
		}
		.alt_full {
			width: 40px;
		}
		.gallery .previews {
    	width: 15%;
		}
		.gallery .full {
    	width: 76%;
		}
		.alt_f{
			width: 50px;
		}
		.alt_f2{
			width: 40px;
		}
		.item_rep{
			width: 100%;
		}
		.box_resp{
			width: 100%!important;
		}
		.box-news{
			margin-left: 20px;
		}
		.clearfix{
			margin-left: 0px;
			width: 100%;
		}
		.box_total {
		background-color: #fff;
		padding: 20px 10px;
		}
		.pd_rosa {
			margin-left: 10px;
		}
		.pd_az_ps{
			margin-left: 10px;
		}
		.pd_az_es{
			margin-left: 10px;
		}
		
	}
		
	@media only screen and (width: 320px){
			.col-xs-12{
				padding-right: 0px!important;
				padding-left: 0px!important;
				width: 98%;
			}
			.container {
				padding: 0 0px!important;
				width: 89%;
			}
				.alt_full {
				width: 40px;
			}
			.gallery .previews {
				width: 50px;
			}
			.gallery .full {
				width: 209px;
			}
			.alt_f{
			width: 100%;
			}
			.alt_f2{
				width: 100%;
			}
			.item_rep{
				width: 100%;
			}
			.box_resp {
				width: 100%!important;
			}
			.box-news{
				margin-left: 20px;
			}
			.box_total {
			background-color: #fff;
			padding: 20px 10px;
			}
			.clearfix{
				margin-left: 0px;
				width: 100%;
			}
			.pd_rosa {
				margin-left: 10px;
			}
			.pd_az_ps{
				margin-left: 10px;
			}
			.pd_az_es{
				margin-left: 10px;
			}
		}
	
	</style>

	<section class="slide-wrapper">
		<div class="banner">
			<div class="container"><strong></strong>
				<div class="row box_total">
					
					<div class="text-left">
						<a href="minhas-pecas.php"><div class="text-left alt_word">NOSSOS EDITORIAS</div></a>
						<p><?php $duaslinhas = $textos->rsDados(5);?>
							<?php echo substr($duaslinhas->textos, 0,144);?>
						</p>
					</div>
					
					<div class="col-sm-12 lib-item" data-category="view">
						<div class="row box-shadow">
							
							<div class="col-xs-12 col-sm-7 respon">
								<div class="container clearfix" style=" width: 100%;">
									<div class="gallery" id="wrapper">
										 
										<?php 
										if($i <> ''){
											echo 'selected';
										}
										?>
										<div class="previews">
											
											<?php $img_prim = "minhanossa/img_noticias/".cortaImagem($row_rs_pecas['foto'], 'minhanossa/img_noticias', '420', '550', 'img_prim', '#FFFFFF');?>
												<a href="javascript:;" onClick="AtualizaJanela('janela_img_grande.php?img_grande=<?php echo $row_rs_pecas['foto'];?>&img_pequena=<?php echo $img_prim;?>', 'imagem_grande');" class="<?php $i = 0; echo $i;?>" data-full="<?php echo $img_prim;?>">
													<img src="<?php echo $img_prim;?>" class="alt_full"/>
												</a>
											<?php if($totalRows_rs_fotos > 0){ $i= 0; do{ $i++; ?>
											
											<?php $img_thumb3 = "minhanossa/img_noticias/".cortaImagem($row_rs_fotos['foto'], 'minhanossa/img_noticias', '420', '550', 'img_thumbz', '#FFFFFF');?>

											<a href="javascript:;" onClick="AtualizaJanela('janela_img_grande.php?img_grande=<?php echo $row_rs_fotos['foto'];?>&img_pequena=<?php echo $img_thumb3;?>', 'imagem_grande');"  class="alt_f <?php $i = 0; echo $i; if($i > '0'){ echo 'selected';} ?> ">
												<img src="<?php echo $img_thumb3;?>" class="alt_f2"/>
											</a>
											
											<?php } while($row_rs_fotos = mysql_fetch_assoc($rs_fotos)); }?>
										
										</div>
										
										<div class="full">
											<div class="section" id="janela_imagem_grande">
											<!-- first image is viewable to start -->
												<?php include('janela_img_grande.php');?> 
											</div>
										</div>
									</div>
								</div>

							</div>
	
							<div class="container clearfix">
								<div class="col-xs-12 col-sm-5 box_border box_resp">
									
									<?php if($row_rs_pecas['tipo1'] <> '' and $row_rs_pecas['tamanho1'] <> '' and $row_rs_pecas['pontos1'] <> ''){ ?>
										<div class="pd_rosa">
											<h4><?php echo $row_rs_pecas['tipo1'];?></h4>
											<h4>Tamanhos: <?php echo $row_rs_pecas['tamanho1'];?></h4>
											<h4>Nas outras lojas você compra por: <?php echo number_format($row_rs_pecas['valor_loja'],2,',','.');?></h4>
											<h4>Aqui você usa por: <?php echo $row_rs_pecas['pontos1'];?> </h4>
										</div>
									<br>
									<?php } ?>
									<?php if($row_rs_pecas['tipo2'] <> '' and $row_rs_pecas['tamanho2'] <> '' and $row_rs_pecas['pontos2'] <> ''){ ?>
										<div class="pd_az_ps">
											<h4><?php echo $row_rs_pecas['tipo2'];?></h4>
											<h4>Tamanhos: <?php echo $row_rs_pecas['tamanho2'];?></h4>
											<h4>Nas outras lojas você compra por: <?php echo number_format($row_rs_pecas['valor_loja2'],2,',','.');?></h4>
											<h4>Aqui você usa por: <?php echo $row_rs_pecas['pontos2'];?> </h4>
										</div>
									<br>
									<?php } ?>
									<?php if($row_rs_pecas['tipo3'] <> '' and $row_rs_pecas['tamanho3'] <> '' and $row_rs_pecas['pontos3'] <> ''){ ?>
										<div class="pd_az_es">
											<h4><?php echo $row_rs_pecas['tipo3'];?></h4>
											<h4>Tamanhos: <?php echo $row_rs_pecas['tamanho3'];?></h4>
											<h4>Nas outras lojas você compra por: <?php echo number_format($row_rs_pecas['valor_loja3'],2,',','.');?></h4>
											<h4>Aqui você usa por: <?php echo $row_rs_pecas['pontos3'];?> </h4>
										</div>
								  	<br>
									<?php } ?>
									<?php if($row_rs_pecas['tipo4'] <> '' and $row_rs_pecas['tipo5'] == '' and $row_rs_pecas['tipo6'] == '' ){ ?>
									<style>
										@media screen and (min-width: 1200px){
											.pd_rosa {
												margin-top: 15px;
											}
											.pd_az_es {
												margin-bottom: 0px;
											}
										}
										@media only screen and (min-width: 1024px){
											.box_border {
												font-size: 0px;
												height: auto;
												padding-left: 20px;
												padding-top: 0px;
											}
											.pd_rosa {
												margin-top: 15px;
											}
										}
										@media only screen and (max-width: 480px) and (min-width: 321px){
											.pd_rosa {
												margin-left: 10px;
											}
											.pd_rosa {
												color: #f8abb2;
												margin-top: 0px;
											}	
										}
										@media only screen and (width: 320px){
											.pd_rosa {
												color: #f8abb2;
												margin-top: 0px;
											}
										}
									</style>
									
									<?php } ?>
									<?php if($row_rs_pecas['tipo4'] <> '' and $row_rs_pecas['tamanho4'] <> '' and $row_rs_pecas['pontos4'] <> ''){ ?>
										<div class="pd_rosa">
											<h4><?php echo $row_rs_pecas['tipo4'];?></h4>
											<h4>Tamanhos: <?php echo $row_rs_pecas['tamanho4'];?></h4>
											<h4>Nas outras lojas você compra por: <?php echo number_format($row_rs_pecas['valor_loja4'],2,',','.');?></h4>
											<h4>Aqui você usa por: <?php echo $row_rs_pecas['pontos4'];?> </h4>
										</div>
								  	<br>
									<?php } ?>
									<?php if($row_rs_pecas['tipo6'] == '' and $row_rs_pecas['tipo5'] <> '' and $row_rs_pecas['tipo4'] <> '' ){ ?>
									<style>
										@media screen and (min-width: 1200px){
											.pd_rosa {
												margin-top: 40px;
											}
											.pd_az_es {
												margin-bottom: 0px;
											}
										}
										@media only screen and (min-width: 1024px){
											.box_border {
												font-size: 0px;
												height: auto;
												padding-left: 20px;
											}
											.pd_rosa {
												margin-top: 30px;
											}
										}	
									</style>
									<?php } ?>
									
									<?php if($row_rs_pecas['tipo5'] <> '' and $row_rs_pecas['tamanho5'] <> '' and $row_rs_pecas['pontos5'] <> ''){ ?>
										<div class="pd_az_ps">
											<h4><?php echo $row_rs_pecas['tipo5'];?></h4>
											<h4>Tamanhos: <?php echo $row_rs_pecas['tamanho5'];?></h4>
											<h4>Nas outras lojas você compra por: <?php echo number_format($row_rs_pecas['valor_loja5'],2,',','.');?></h4>
											<h4>Aqui você usa por: <?php echo $row_rs_pecas['pontos5'];?></h4>
										</div>
								  	<br>
									<?php } ?>
									<?php if($row_rs_pecas['tipo6'] <> '' and $row_rs_pecas['tipo5'] <> '' and $row_rs_pecas['tipo4'] <> '' ){ ?>
									<style>
										@media screen and (min-width: 1200px){
											.pd_rosa {
												margin-top: 0px;
											}
											.pd_az_es {
												margin-bottom: 0px;
											}
										}
										@media only screen and (min-width: 1024px){
											.box_border {
												font-size: 0px;
												height: auto;
												padding-left: 20px;
											}
											.pd_rosa {
												margin-top: 0px;
											}
										}	
									</style>
									<?php } ?>
									<?php if($row_rs_pecas['tipo6'] <> '' and $row_rs_pecas['tamanho6'] <> '' and $row_rs_pecas['pontos6'] <> ''){ ?>
										<div class="pd_az_es">
											<h4><?php echo $row_rs_pecas['tipo6'];?></h4>
											<h4>Tamanhos: <?php echo $row_rs_pecas['tamanho6'];?></h4>
											<h4>Nas outras lojas você compra por: <?php echo number_format($row_rs_pecas['valor_loja6'],2,',','.');?></h4>
											<h4>Aqui você usa por: <?php echo $row_rs_pecas['pontos6'];?></h4>
										</div>
								  	<br>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>			
				</div>
	</section>
	<?php //print_r($row_rs_pecas);?>
	<div class="clearfix">&nbsp;</div>
	<div class="clearfix">&nbsp;</div>
	<div class="clearfix">&nbsp;</div>
	<div class="clearfix">&nbsp;</div>
	<div class="clearfix">&nbsp;</div>
	<div class="clearfix">&nbsp;</div>
	<div class="clearfix">&nbsp;</div>
	<div class="clearfix">&nbsp;</div>
	<div class="clearfix">&nbsp;</div>

	<!-- Footer -->
		<?php include('footer.php');?>
			<!-- Footer //-->
	
</body>
<!-- Body //-->

<!-- Latest compiled and minified JS -->
<script src="js/bootstrap.min.js"></script>
<script src="js/script.js"></script>
<script src="checkout/load.js"></script>
<!--Slider-vertical-->

<script src="fancybox/jquery.fancybox.js"></script>
<script>
	$( document ).ready( function () {
		$( 'a' ).click( function () {
			var largeImage = $( this ).attr( 'data-full' );
			$( '.selected' ).removeClass();
			$( this ).addClass( 'selected' );
			$( '.full img' ).hide();
			$( '.full img' ).attr( 'src', largeImage );
			$( '.full img' ).fadeIn();


		} );
		// closing the listening on a click
		$( '.full img' ).on( 'click', function () {
			var modalImage = $( this ).attr( 'src' );
			$.fancybox.open( modalImage );
		} );
	} ); //closing our doc ready
	
</script>

</html>