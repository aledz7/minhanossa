<?php 
/*echo "	<script>
		window.location='../';
		</script>";
		exit;*/
///////////////////// SE NÃO TIVER PÁGINA DE LOJA CONTINUAR ABAIXO /////////

require_once('Connections/conexao.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

mysql_select_db($database_conexao, $conexao);
$query_rs_fornecedores = "SELECT * FROM tbl_fornecedores WHERE foto IS NOT NULL";
$rs_fornecedores = mysql_query($query_rs_fornecedores, $conexao) or die(mysql_error());
$row_rs_fornecedores = mysql_fetch_assoc($rs_fornecedores);
$totalRows_rs_fornecedores = mysql_num_rows($rs_fornecedores);

mysql_select_db($database_conexao, $conexao);
$query_rs_novidades = "
SELECT 
  tbl_produtos.*
  
 FROM 
  tbl_produtos

 WHERE tbl_produtos.foto IS NOT NULL  
 GROUP BY tbl_produtos.id LIMIT 0,12";
$rs_novidades = mysql_query($query_rs_novidades, $conexao) or die(mysql_error());
$row_rs_novidades = mysql_fetch_assoc($rs_novidades);
$totalRows_rs_novidades = mysql_num_rows($rs_novidades);


mysql_select_db($database_conexao, $conexao);
$query_rs_mais_vendido = "
SELECT 
  tbl_produtos.*,
  tbl_fornecedores.nome AS nomeFornecedor,
  tbl_produto.id_produto,
  tbl_produto.id_categoria,
  tbl_categorias.name
 FROM 
  tbl_produtos
 LEFT JOIN
  tbl_rel_cat_produtos AS tbl_produto ON tbl_produtos.id = tbl_produto.id_produto
 LEFT JOIN
  tbl_categorias ON tbl_produto.id_categoria = tbl_categorias.id
 LEFT JOIN
  tbl_fornecedores ON tbl_produtos.fornecedor = tbl_fornecedores.id
 WHERE tbl_produtos.foto IS NOT NULL
 GROUP BY tbl_produtos.id ORDER BY rand() limit 0,4";
$rs_mais_vendido = mysql_query($query_rs_mais_vendido, $conexao) or die(mysql_error());
$row_rs_mais_vendido = mysql_fetch_assoc($rs_mais_vendido);
$totalRows_rs_mais_vendido = mysql_num_rows($rs_mais_vendido);


include('../class/conteudos.php');
$conteudos = Conteudos::getInstance(Conexao::getInstance());


?>
<!doctype html>
<html class="no-js" lang="pt-BR">
    <?php include('head.php'); ?>
<body>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <!-- Add your site or application content here -->
        <!-- start header_area
		============================================ -->
        <?php include('header.php'); ?>
        <!-- end header_area
		============================================ -->
        <!-- main slider -->

        <div class="slider-area">
			<div class="bend niceties preview-2">
				<div id="ensign-nivoslider" class="slides">	
					<img src="../images/opala.jpg" alt="" title="#slider-direction-1"  />
					<img src="../images/press.jpg" alt="" title="#slider-direction-2"  />
				</div>
				<!-- direction 1 -->
				<div id="slider-direction-1" class="t-cn slider-direction">
					<div class="slider-progress"></div>
					<div class="slider-content t-lfl s-tb slider-1">
						
				  </div>
			  </div>	
		  </div>
				<!-- direction 2 -->
				<div id="slider-direction-2" class="slider-direction">
					<div class="slider-progress"></div>
					
		  </div>	
</div>
			</div>
		</div>

        <section class="slider_area">
            <div class="container">
                <div class="row">
                <!-- SLIDE DE MARCAS -->
                <div class="row">          
                    <?php /*?><div class="item_all indicator-style">
                     <?php
			  $parceiros = $conteudos->rsDados(29); 
			  foreach($parceiros as $item) {
			  ?>
                        <div class="col-md-12">
                        
                            <img class="primary-img" src="../img_noticias/<?php echo $item->foto ?>" alt="" />
                       
                        </div>
                     <?php } ; ?>
                    </div>
                    <!-- SLIDE DE MARCAS --><?php */?>

                    <div class="col-md-12"><br></div>
                    <div class="col-md-12">
                        <div class="features-tab indicator-style">
                          <!-- Nav tabs -->
                          <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active">
                                 <a href="#home" aria-controls="home" role="tab" data-toggle="tab">
                                  NOVIDADES
                                 </a>
                                </li>
                          </ul>

                            <div class="col-md-12 col-sm-12 col-xs-12">
                             <div class="features-tab">
                              <div class="tab-content">
                               <div role="tabpanel" class="tab-pane active" id="home">
                                <div class="row">
                                 <div class="shop-tab">
                                 
                                  <?php do { ?>
                                  <div class=" col-md-3">
                                   <div class="single-product">
                                    <div class="product-img">
                                     <a href="desc-produtos.php?id-produto=<?php echo $row_rs_novidades['id'] ?>">
                                      <img class="primary-image" src="../img_noticias/<?php echo $row_rs_novidades['foto'] ?>" />
                                     </a>                            
                                    </div>
                                    <div class="product-content">
                                     <p class="product-name" style="text-transform: uppercase;">
                                      <a href="desc-produtos.php?id-produto=<?php echo $row_rs_novidades['id'] ?>">
                                       <?php echo $row_rs_novidades['nome']?> - 
                                       <?php echo $row_rs_novidades['nomeFornecedor'] ?>
                                      </a>
                                     </p>
                                     <div class="product-name">
                                      <p>
                                       <span class="add-color-price">
                                        Por R$ <?php echo number_format($row_rs_novidades['preco_por'], 2, ',', '.') ?>
                                       </span> 
                                       <br> 
                                       <span class="add-color-size">
                                       <?php 
									        $parcelado = $row_rs_novidades['preco_por']/2;
									    ?>
                                        Ou 2x de R$ <?php echo number_format($parcelado, 2, ',', '.') ?>
                                       </span>
                                      </p>
                                     </div>    
                                     <div class="product-icon">
                                     <form action="carrinho.php" method="POST" name="carrinhoForm<?php echo $row_rs_novidades['id'] ?>" id="carrinhoForm<?php echo $row_rs_novidades['id'] ?>">
             						  <a href="javascript:;" onClick="document.getElementById('carrinhoForm<?php echo $row_rs_novidades['id'] ?>').submit();" class="add-text-cart">
              						   <i class="fa fa-shopping-cart"></i> 
               							Adicionar ao Carrinho
             						  </a>
              						  <input name="acao" type="hidden" id="acao" value="comprar" />
              						  <input name="id" type="hidden" id="id" value="<?php echo $row_rs_novidades['id']; ?>" />
  							          </form>
                                     </div>
                                    </div>
                                   </div>
                                  </div>
                                  <?php } while($row_rs_novidades = mysql_fetch_assoc($rs_novidades)); ?>
                            </div>
                        </div>				
                    </div>
			    </div>
            </div>
        </section>
       
        <section class="shop_area" style="margin-bottom:30px;">
         <div class="container">
            

      <!-- MAIS VENDIDOS -->
      <div class="row">
       <div class="col-md-12">
        <div class="title ma-title lab">
         <h2>
          PRODUTOS MAIS VENDIDOS
         </h2>
        </div>
       </div>
      </div>

    <?php do { ?>
      <div class=" col-md-3">
       <div class="single-product">
        <div class="product-img">
         <a href="desc-produtos.php?id-produto=<?php echo $row_rs_mais_vendido['id'] ?>">
          <img class="primary-image" src="../img_noticias/<?php echo $row_rs_mais_vendido['foto']?>" alt="" />
         </a>                            
        </div>
        <div class="product-content">
         <p class="product-name">
          <a href="desc-produtos.php?id-produto=<?php echo $row_rs_mais_vendido['id'] ?>">
           <?php echo $row_rs_mais_vendido['nome'] ?> - 
           <?php echo $row_rs_mais_vendido['nomeFornecedor'] ?>
          </a>
         </p>
         <div class="product-name">
          <p>
           <span class="add-color-price">
            Por R$ <?php echo $row_rs_mais_vendido['preco_por'] ?>
           </span> 
           <br> 
           <span class="add-color-size">
            <?php 
			 $parcela_mais_vendido = $row_rs_mais_vendido['preco_por']/2;
			?>
            Ou 2x de R$ <?php echo number_format($parcela_mais_vendido, 2, ',', '.') ?>
           </span>
          </p>
         </div>  
         <div class="product-icon">
          <form action="carrinho.php" method="POST" name="carrinhoForm<?php echo $row_rs_mais_vendido['id'] ?>" id="carrinhoForm<?php echo $row_rs_mais_vendido['id'] ?>">
             <a href="javascript:;" onClick="document.getElementById('carrinhoForm<?php echo $row_rs_mais_vendido['id'] ?>').submit();" class="add-text-cart">
              <i class="fa fa-shopping-cart"></i> 
               Adicionar ao Carrinho
             </a>
              <input name="acao" type="hidden" id="acao" value="comprar" />
              <input name="id" type="hidden" id="id" value="<?php echo $row_rs_mais_vendido['id']; ?>" />
            </form>
         </div>
        </div>
       </div>
      </div>        
    <?php } while($row_rs_mais_vendido = mysql_fetch_assoc($rs_mais_vendido)); ?>
                                        

                                            <!-- ADS -->
                          </div>
                          </section>
                                      

        <!-- start ma-footer-stati
		============================================ -->
        <!-- end footer-address
		============================================ -->
        <?php include('footer.php'); ?>
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
mysql_free_result($rs_fornecedores);
?>
