<?php 
session_start();

include('Connections/conexao.php');
include('funcoes.php');
include('config.php');

include('../class/produtos.php');
$produtos = Produtos::getInstance(Conexao::getInstance());
$produtos->excluir_lista_desejos();

include('../class/clientes.php');
$clientes = Clientes::getInstance(Conexao::getInstance());
$clientes->restrito();

?>

<!doctype html>
<html class="no-js" lang="">
  <? include('head.php') ?>
<body>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <!-- Add your site or application content here -->
        <!-- start header_area
		============================================ -->
         <? include('header.php'); ?>
        <!-- end header_area
		============================================ -->
        <!-- start main_shop_area
		============================================ -->
        <section class="main_shop_area">
         <div class="breadcrumbs">
          <div class="container">
           <div class="container-inner">
            <ul class="tasnimm">
             <li class="home">
              <a href="..\index.php">Home</a>
              <span>
               <i class="fa fa-angle-right"></i>
              </span>
             </li>
             <li class="category3">
              <strong>Sua Lista de Desejos</strong>
             </li>
            </ul>
           </div>
          </div>
         </div>

         <div class="main_shop_all">
          <div class="container">
           <div class="row">
            <? //include('inc-coluna.php'); ?>
           
          <div class="col-md-12 col-sm-12 col-xs-12">
           <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
             <div class="features-tab">
              <div class="tab-content">
               <div role="tabpanel" class="tab-pane active" id="home">
                <div class="row">
                 <div class="shop-tab">
              <? 
			   $produtos->add_filtro('lista_desejos');
				$rsProdutos = $produtos->rsDados('', $_GET['ordem'], '', $_GET['id-cat']);
				 if(count($rsProdutos) > 0) { ?>
                  <? foreach($rsProdutos as $item) { ?>
                  <div class="col-md-3 col-sm-6" >
                   <div class="single-product">
                    <? if($item->promocao == 'S') { ?>
                     <span class="sale-text">Oferta!</span>
                    <? } ?>
                     <div class="product-img" style="text-align:center;">
                      <!--<a href="<?php/* echo str_replace(array('[id]', '[nome]'),array($item->id, $item->nome),$pagProdutos);?>">
                       <img class="primary-image" src="../img_noticias/<?php echo $item->foto */?>" alt=""  />
                      </a>-->
					  <a href="../desc-minhas-pecas.php?id=<?php echo $item->id;?>">
                       <img class="primary-image" src="../sistema/img_noticias/<?php echo $item->foto;?>" alt=""  />
                      </a>	
                     </div>
                     <div class="product-content">
					<?/*	 
                      <div class="price-box">
						<?php $pontos1 = $item->pontos1; $pontos2 = $item->pontos2; $pontos3 = $item->pontos3; 
						  	  $somapontos = $pontos1+$pontos2+$pontos3;
						  ?>
						 
						   <span class="special-price">
							  Pontos totais <?php echo $somapontos;?>
						   </span>
						   <? if($item->promocao == 'S') { ?>
						   <span class="old-price">
							   Pontos totais <?php echo $somapontos;?>
						   </span>
                      	<? } ?>
                      </div>
					*/?>
                      <h2 class="product-name">
                       <a href="../desc-minhas-pecas.php?id=<?php echo $item->id;?>">
                       		<?php echo substr($item->nome, 0, 30) ?>
                       </a>
                      </h2>
					
					  <?php// print_r($item);?>
						 
                      <!--<div class="product-icon">
                       <a href="<?php// echo str_replace(array('[id]', '[nome]'),array($item->id, $item->nome),$pagProdutos);?>" class="add-text-cart">
                        <i class="fa fa-shopping-cart"></i> 
                         Comprar
                       </a>
                      </div>-->
						 <div class="product-icon">
                       <a href="?acao=excluir_itemlista&id=<?php echo $item->id;?>" class="add-text-cart">
                        <i class="fa fa-star"></i> 
                         Excluir
                       </a>
                      </div>
					
                     </div>
                    </div>
                   </div>
                  <? } ?>
                  <? } else { ?>
                   Não foi possível retornar um resultado.
                  <? } ?>
                  </div>
                 </div>
                </div>
               </div>
              </div>
             </div>
            </div>
           </div>
          </div>
         </div>
        </div>
        </section>

	<? include('footer.php'); ?>

	<div id="toTop">
		<i class="fa fa-chevron-up"></i>
	</div>
	<!-- end scrollUp
	============================================ -->
	<!-- jquery
	============================================ -->		
	<script src="js/vendor/jquery-1.11.3.min.js"></script>
	<script src="js/jquery-ui.js"></script>
	<!-- bootstrap JS
	============================================ -->		
	<script src="js/bootstrap.min.js"></script>
	<!-- wow JS
	============================================ -->		
	<script src="js/wow.min.js"></script>
	<!-- price-slider JS
	============================================ -->		
	<script src="js/jquery-price-slider.js"></script>
	<!-- Img Zoom js -->
	<script src="js/img-zoom/jquery.simpleLens.min.js"></script>
	<!-- meanmenu JS
	============================================ -->		
	<script src="js/jquery.meanmenu.js"></script>
	<!-- owl.carousel JS
	============================================ -->		
	<script src="js/owl.carousel.min.js"></script>
	<!-- jquery.ui js -->
	<script src="js/jquery-ui.min.js"></script>
	<!-- scrollUp JS
	============================================ -->		
	<script src="js/jquery.scrollUp.min.js"></script>
	<!-- Nivo slider js
	============================================ --> 		
	<script src="lib/js/jquery.nivo.slider.js" type="text/javascript"></script>
	<script src="lib/home.js" type="text/javascript"></script>
	<!-- plugins JS
	============================================ -->		
	<script src="js/plugins.js"></script>
	<!-- main JS
	============================================ -->		
	<script src="js/main.js"></script>
  </body>
</html>
<?php
//mysql_free_result($rs_categoria_produtos);
?>
