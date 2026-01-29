<?php
include('class/produtos.php');
$produtos = Produtos::getInstance(Conexao::getInstance());
$descricao = $produtos->rsDados($_GET['id']);

include('class/conteudos.php');
$conteudos = Conteudos::getInstance(Conexao::getInstance());
$categoria = $conteudos->rsDados($_GET['id'], $novidade->id_categoria);
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
          <link rel="shortcut icon" href="images/fav.png" type="image/x-icon" />
    </head>
    <body>
        
        <?php include('header.php');?>
        
<section class="slide-wrapper">
        <div class="banner" style="padding: 48px 0 0">

            <div class="container">
    
                <div class="row row-centered" style="background-color: #fff; padding-top: 40px;">
                      <div class="col-sm-6 text-left">
                       <h3 class="text-left">produtos</h3>
                       <span class="text-left"><?php echo $categoria->titulo;?></span> 
                    </div>          
                    
                      <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10 col-centered" >
                            
                            	<div class="wrapper row">
					<div class="preview col-md-6">
						
						<div id='carousel-custom' class='carousel slide' data-ride='carousel'>
                            <div class='carousel-outer' style="margin-left: 54px;">
                                <!-- me art lab slider -->
                                <div class='carousel-inner '>
                                    <?php $descricao = $produtos->rsDados();
									foreach($descricao as $fotos) { ?>
                                    <div <?php if($i = 1){echo "class='item active'";}?>class='item active'>
                                        <img src='img_noticias/<?php echo $fotos->foto;?>' alt=''id="zoom_05"  data-zoom-image="img_noticias/<?php echo $fotos->foto;?>"/>
                                    </div>
                                    <?php }?>
                                    <script>
                                    $("#zoom_05").elevateZoom({ zoomType    : "inner", cursor: "crosshair" });
                                    </script>
                                </div>
            
        <!-- sag sol -->
        <a class='left carousel-control' href='#carousel-custom' data-slide='prev'>
            <span class='glyphicon glyphicon-chevron-left'></span>
        </a>
        <a class='right carousel-control' href='#carousel-custom' data-slide='next'>
            <span class='glyphicon glyphicon-chevron-right'></span>
        </a>
    </div>
    
    <!-- thumb -->
    <!-- <ol class='carousel-indicators mCustomScrollbar meartlab'>
        <li data-target='#carousel-custom' data-slide-to='0' class='active'><img src='http://images.asos-media.com/inv/media/8/2/3/3/5313328/print/image1xxl.jpg' alt='' /></li>
        <li data-target='#carousel-custom' data-slide-to='1'><img src='http://images.asos-media.com/inv/media/8/2/3/3/5313328/image2xxl.jpg' alt='' /></li>
        <li data-target='#carousel-custom' data-slide-to='2'><img src='http://images.asos-media.com/inv/media/8/2/3/3/5313328/image3xxl.jpg' alt='' /></li>
        <li data-target='#carousel-custom' data-slide-to='3'><img src='http://images.asos-media.com/inv/media/3/6/7/0/4850763/multi/image1xxl.jpg' alt='' /></li>
        <li data-target='#carousel-custom' data-slide-to='4'><img src='http://images.asos-media.com/inv/media/5/2/1/3/4603125/gold/image1xxl.jpg' alt='' /></li>
        <li data-target='#carousel-custom' data-slide-to='5'><img src='http://images.asos-media.com/inv/media/5/3/6/8/4948635/mink/image1xxl.jpg' alt='' /></li>
        <li data-target='#carousel-custom' data-slide-to='6'><img src='http://images.asos-media.com/inv/media/1/3/0/8/5268031/image2xxl.jpg' alt='' /></li>

    </ol> -->
</div>

<script type="text/javascript">

$(document).ready(function() {
    $(".mCustomScrollbar").mCustomScrollbar({axis:"x"});
});
</script>
						
					</div>
					<div class="details col-md-6">
                        <div style="border: 2px solid #ea4857;padding: 13px 21px 0;"> 
                        <div style="border-radius: 30px; border: 2px solid;background-color: #fff;width: 46px; font-size: 26px;padding: 5px 10px 0px; color: #ea4857; position: absolute; margin-top: -43px;">
                            <i class="fa fa-star"></i>
                        </div>
                        
                            <span class="product-title">bolsas e cintos</span>
						<div class="rating">
                           <?php $desc = $produtos->rsDados($_GET['id']); ?>
                            <h5 class="review-no" style="color: #d76e79"><?php echo $desc->nome;?></h5>
                        </div>
                        </div>
                        <p class="product-description" style="border-bottom: 2px solid #ea4857; padding: 17px 0 21px;"><?php echo $desc->detalhes;?></p>
                        
<!-- 
						 <h4 class="price">current price: <span>$180</span></h4>
						<p class="vote"><strong>91%</strong> of buyers enjoyed this product! <strong>(87 votes)</strong></p> -->
						
						
                        
                        <h4>SELECIONE O TAMNHO</h4>
                        <div class="row" style="border-bottom: 2px solid #ea4857">
                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                <span class="abc" style="font-size: 20px; font-weight: bold">UNICO</span>
                            </div>
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                                <span class="abc" style="font-size: 20px; font-weight: bold">P</span>
                            </div>
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                                <span class="abc" style="font-size: 20px; font-weight: bold">M</span>
                            </div>
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                                <span class="abc" style="font-size: 20px; font-weight: bold">G</span>
                            </div>
                            <div class="clearfix">&nbsp;</div>
                            <div class="clearfix">&nbsp;</div>
                        </div>
                        
                        
                        
                        
                        
                        
                        
						<div class="action">
                            <div class="clearfix">&nbsp;</div>
                            <div class="clearfix">&nbsp;</div>
                             <h4>DISPONÍVEL PARA</h4>
							<button class="add-to-cart btn btn-default" type="button" style="background-color: #d4d4d4; color: #000000; border-radius: 0">plano basico</button>
							<button class="add-to-cart btn btn-default" type="button" style="background-color: #31bbac; color: #FFFFFF; border-radius: 0">plano intermediario</button>
                        </div>

                        <div class="action text-center">
                            <div class="clearfix">&nbsp;</div>
                            <div class="clearfix">&nbsp;</div>
                            
							<button class="add-to-cart btn btn-default " type="button" style="padding: 18px 153px 18px;font-size: 33px; border-radius: 0"><a href="checkout/carrinho.php?id-produto=<?php echo $produtos->id;?>"> eu quero!</a></button>
							
                        </div>
                        
					</div>
				</div>
                            
                      </div>
               </div>
        
        </div>
        
    </div>
    

</section>
       
        


         <div class="clearfix">&nbsp;</div>
         <div class="clearfix">&nbsp;</div>
         <div class="clearfix">&nbsp;</div>
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
    
    <!-- Latest compiled and minified JS -->
    <script src="//code.jquery.com/jquery.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <script src="js/product-slide.js"></script>
    <!-- <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script> -->
    <script src="js/script.js"></script>
</html>
