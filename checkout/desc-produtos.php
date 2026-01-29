<?php 
include('Connections/conexao.php'); 
include('funcoes.php');

include('../class/produtos.php');
$produtos = Produtos::getInstance(Conexao::getInstance());


mysql_select_db($database_conexao, $conexao);
$query_rs_desc_produtos = "
SELECT 
  tbl_produtos.*,
  tbl_fornecedores.nome AS nomeFornecedor,
  tbl_produto.id_produto,
  tbl_produtos.id_categoria,
  tbl_categorias.name
 FROM 
  tbl_produtos
 LEFT JOIN
  tbl_rel_cat_produtos AS tbl_produto ON tbl_produtos.id = tbl_produto.id_produto
 LEFT JOIN
  tbl_categorias ON tbl_produto.id_categoria = tbl_categorias.id
 LEFT JOIN
  tbl_fornecedores ON tbl_produtos.fornecedor = tbl_fornecedores.id
 WHERE tbl_produtos.foto IS NOT NULL  AND tbl_produtos.id = '".intval($_GET['id-produto'])."'
 GROUP BY tbl_produtos.id LIMIT 0,8";
$rs_desc_produtos = mysql_query($query_rs_desc_produtos, $conexao) or die(mysql_error());
$row_rs_desc_produtos = mysql_fetch_assoc($rs_desc_produtos);
$totalRows_rs_desc_produtos = mysql_num_rows($rs_desc_produtos);

mysql_select_db($database_conexao, $conexao);
$query_rs_produtos_relacionados = "
SELECT 
  tbl_produtos.*
 FROM 
  tbl_produtos
 WHERE tbl_produtos.foto IS NOT NULL  AND tbl_produtos.id_categoria = '".$row_rs_desc_produtos['id_categoria']."'
 GROUP BY tbl_produtos.id LIMIT 0,6";
$rs_produtos_relacionados = mysql_query($query_rs_produtos_relacionados, $conexao) or die(mysql_error());
$row_rs_produtos_relacionados = mysql_fetch_assoc($rs_produtos_relacionados);
$totalRows_rs_produtos_relacionados = mysql_num_rows($rs_produtos_relacionados);

mysql_select_db($database_conexao, $conexao);
$query_rs_outros_produtos = "
SELECT 
  *
 FROM 
  tbl_produtos
 WHERE 
  foto IS NOT NULL 
 ORDER BY rand() LIMIT 0,15";
$rs_outros_produtos = mysql_query($query_rs_outros_produtos, $conexao) or die(mysql_error());
$row_rs_outros_produtos = mysql_fetch_assoc($rs_outros_produtos);
$totalRows_rs_outros_produtos = mysql_num_rows($rs_outros_produtos);


mysql_select_db($database_conexao, $conexao);
$query_rs_fotos = "select * from tbl_fotos where tipo = 'Produtos".intval($_GET['id-produto'])."'";
$rs_fotos = mysql_query($query_rs_fotos, $conexao) or die(mysql_error());
$row_rs_fotos = mysql_fetch_assoc($rs_fotos);
$totalRows_rs_fotos = mysql_num_rows($rs_fotos);

?>
<!doctype html>
<html class="no-js" lang="">
  <? include('head.php'); ?>
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
        <!-- start main_slider_area
		============================================ -->
        <section class="shop-details-area">
         <div class="breadcrumbs">
          <div class="container">
           <div class="container-inner">
            <ul>
             <li class="home">
              <a href="../index.php">Home</a>
               <span>
                <i class="fa fa-angle-right"></i>
               </span>
              </li>
              <li class="home-two">
               <a href="../produtos.php">Produtos</a>
                <span>
                 <i class="fa fa-angle-right"></i>
                </span>
              </li>
               <li class="category3">
                <strong><?php echo $row_rs_desc_produtos['nome'] ?></strong>
               </li>
             </ul>
            </div>
           </div>
          </div>
          <div class="shop-details">
           <div class="container">
            <div class="row">
             <div class="col-md-4 col-sm-6 hidden-xs">
              <div class="s_big">
               <div>
                <div class="tab-content">
                <? if($row_rs_desc_produtos['foto'] <> '' ) { ?>
                 <div id="image1" class="tab-pane fade in active">
                  <div class="simpleLens-big-image-container">
                   <a class="simpleLens-lens-image" data-lens-image="../img_noticias/<?php echo $row_rs_desc_produtos['foto'] ?>">
                    <img alt="" src="../img_noticias/<?php echo $row_rs_desc_produtos['foto'] ?>" class="simpleLens-big-image">
                   </a>
                  </div>
                 </div>
                <? } ?>
                 <?php do { ?>
                 <div id="image2" class="tab-pane fade">
                  <div class="simpleLens-big-image-container">
                   <a class="simpleLens-lens-image" data-lens-image="../img_noticias/<?php echo $row_rs_fotos['foto'] ?>">
                    <img alt="" src="../img_noticias/<?php echo $row_rs_fotos['foto'] ?>" class="simpleLens-big-image">
                   </a>
                  </div>
                 </div>
                <? } while($row_rs_fotos = mysql_fetch_assoc($rs_fotos));
				
				mysql_select_db($database_conexao, $conexao);
$query_rs_fotos = "select * from tbl_fotos where tipo = 'Produtos{$_GET['id-produto']}'";
$rs_fotos = mysql_query($query_rs_fotos, $conexao) or die(mysql_error());
$row_rs_fotos = mysql_fetch_assoc($rs_fotos);
$totalRows_rs_fotos = mysql_num_rows($rs_fotos);
				?>
               
               
                </div>
                <div class="thumnail-image fix">
                 <ul class="tab-menu">
                  <?php  if($totalRows_rs_fotos > 0) { ?>
                  <li class="active">
                   <a data-toggle="tab" href="#image1">
                    <img alt="" src="../img_noticias/<?php echo $row_rs_desc_produtos['foto'] ?>">
                   </a>
                  </li>
                  
				  <?php 
				 
				  do { ?>
                  <li>
                   <a data-toggle="tab" href="#image2">
                    <img alt="" src="../img_noticias/<?php echo $row_rs_fotos['foto'] ?>" >
                   </a>
                  </li>
                  <? 
				  } while($row_rs_fotos = mysql_fetch_assoc($rs_fotos));
				  }?>
               
                 </ul>
                </div>
               </div>
              </div>
             </div>
            <form action="carrinho.php" method="post" name="carrinhoForm" id="carrinhoForm">
             <div class="col-md-5 col-sm-6 col-xs-12">
              <div class="cras">
               <div class="product-name" style="border-bottom:hsla(0,0%,85%,1.00) solid 1px; padding-bottom:10px;">
                <h1><?php echo $row_rs_desc_produtos['nome'] ?></h1>
               </div>
               <?php /*?><div class="pro-rating">
                <p class="rating-links">
                 Fornecedor:
                <span style="color:#00a9e0;">
				 <?php echo $row_rs_desc_produtos['nomeFornecedor'] ?> | 
                </span>
                 Qtd. Estoque: 
				<span style="color:#00a9e0;">
				 <?php echo $row_rs_desc_produtos['estoque'] ?>
                </span>
               </p>
              </div><?php */?>
              <div class="short-description">
               <p><?php echo utf8_encode($row_rs_desc_produtos['detalhes']) ?></p>
              </div>
              <div class="pre-box">
               <span class="special-price">
                R$ <?php echo number_format($row_rs_desc_produtos['preco_por'], 2, ',', '.') ?>
               </span>
               <?php
			   $produtos->selectVariacoes($_GET["id-produto"]);
			   ?>
              </div>
              <div class="add-to-box1">
               <div class="add-to-box add-to-box2">
                <div class="add-to-cart">
                 <div class="input-content">
                  <label for="qty">Quantidade:</label>
                   <input id="qtd" class="input-text qty" type="text" title="Qtd" value="1" maxlength="12" name="qtd">
                  </div>
                  <button class="button2 btn-cart" title="" type="submit">
                   <span>Add ao Carrinho</span>
                  </button>
                 </div>
                </div>
               </div>
              </div>
             </div>
             <input name="acao" type="hidden" id="acao" value="comprar" />
             <input name="qtdEstoque" type="hidden" id="qtdEstoque" value="<?php echo $row_rs_desc_produtos['estoque'];?>" />
             <input name="id" type="hidden" id="id" value="<?php echo $row_rs_desc_produtos['id']; ?>" />
             </form>
             <div class="col-md-3 col-sm-12 col-xs-12">
              <div class="ma-title">
               <h2>Produtos Relacionados</h2>
              </div>
              <div class="all">
               <p>Veja outros produtos da mesma categoria</p>
                <div class=" content_top content_all indicator-style">
                 <div class="ma-box-content-all">
                 <? do { ?>
                  <div class="ma-box-content"  style="margin-bottom:10px; border-bottom:hsla(0,0%,82%,1.00) dashed 1px; float:left;">
                   <div class="product-img-right" style="margin-left:5px; margin-right:12px; width:90px;">
                     <a href="desc-produtos.php?id-produto=<?php echo $row_rs_produtos_relacionados['id'] ?>">
                      <img class="primary-image" alt="" src="../img_noticias/<?php echo $row_rs_produtos_relacionados['foto']?>">
                     </a>
                    </div>
                    <div class="product-content" style="min-width: 250px;">
                     <h2 class="product-name" style="font-size:15px;">
                      <a href="desc-produtos.php?id-produto=<?php echo $row_rs_produtos_relacionados['id'] ?>">
					   <?php echo $row_rs_produtos_relacionados['nome'] ?>
                      </a>
                     </h2>
                     
                     <div class="price-box">
                      <span class="special">
                       R$<?php echo number_format($row_rs_produtos_relacionados['preco_por'], 2, ',', '.') ?>
                      </span>
                     </div>
                    </div>
                   </div>
                 <? } while($row_rs_produtos_relacionados = mysql_fetch_assoc($rs_produtos_relacionados)); ?>
                 </div>
                </div>
               </div>
              </div>
             </div>
            </div>
           </div>
        </section>


        
        <section class="product_area">
         <div class="container">
          <div class="row">
           <div class="col-md-12">
            <div class="ma-title">
             <h2>
              Outros Produtos
             </h2>
            </div>
            <div class="row">
             <div class="UpSell indicator-style">
             
			 <? do { ?>
              <div class=" col-md-3">
               <div class="single-product">
                <? if($row_rs_outros_produtos['promocao'] == 'S') { ?>
                <span class="sale-text">Oferta!</span>
                <? } ?>
                 <div class="product-img">
                  <a href="desc-produtos.php?id-produto=<?php echo $row_rs_outros_produtos['id'] ?>">
                   <img class="primary-image" src="../img_noticias/<?php echo $row_rs_outros_produtos['foto'] ?>" alt="" />
                  </a>							
                 </div>
                 <div class="product-content">
                  <div class="price-box">
                   <span class="special-price">
                    R$<?php echo number_format($row_rs_outros_produtos['preco_por'], 2, ',','.') ?>
                   </span>
                   <? if($row_rs_outros_produtos['promocao'] == 'S') { ?>
                   <span class="old-price">
                    R$<?php echo number_format($row_rs_outros_produtos['preco_de'], 2, ',', '.') ?> 
                   </span>
                   <? } ?>
                  </div>
                  <h2 class="product-name">
                   <a href="desc-produtos.php?id-produto=<?php echo $row_rs_outros_produtos['id'] ?>">
                    <?php echo substr($row_rs_outros_produtos['nome'], 0, 20) ?>...
                   </a>
                  </h2>
                 <div class="product-icon">
                  <a href="carrinho.php">
                   <i class="fa fa-shopping-cart"> </i>
                  </a>
                 </div>
                </div>
               </div>
              </div>
             <? } while($row_rs_outros_produtos = mysql_fetch_assoc($rs_outros_produtos)); ?>
            </div>
           </div>
          </div>
         </div>
        </div>
       </section>
       
	   <? include('footer.php'); ?>

        <!-- end footer-address
		============================================ -->
        <!-- start scrollUp
		============================================ -->
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
mysql_free_result($rs_desc_produtos);
?>
