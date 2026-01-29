<?php require_once('Connections/conexao.php'); ?>
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
$query_rs_resultado = "
SELECT 
  tbl_produtos.*,
  tbl_fornecedores.nome AS nomeFornecedor 
FROM 
  tbl_produtos 
LEFT JOIN
  tbl_fornecedores ON tbl_produtos.fornecedor = tbl_fornecedores.id  
WHERE tbl_produtos.nome LIKE '%".$_GET['txtProduto']."%'";
$rs_resultado = mysql_query($query_rs_resultado, $conexao) or die(mysql_error());
$row_rs_resultado = mysql_fetch_assoc($rs_resultado);
$totalRows_rs_resultado = mysql_num_rows($rs_resultado);
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
        <!-- start main_shop_area
		============================================ -->
        <section class="main_shop_area">
            <div class="breadcrumbs">
                <div class="container">
                    <div class="container-inner">
                        <ul class="tasnimm">
                            <li class="home">
                                <a href=".">Home</a>
                                <span>
                                    <i class="fa fa-angle-right"></i>
                                </span>
                            </li>
                            <li class="category3">
                                <strong>Resultado Busca</strong>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="main_shop_all">
                <div class="container">
                    <div class="row">
                        <? include('inc-coluna.php'); ?>
                        
                        <div class="col-md-9 col-sm-9 col-xs-12">
                         <div class="row">
                          <div class="col-md-12 col-sm-12 col-xs-12">
                           <div class="features-tab">
                            <div class="tab-content">
                             <div role="tabpanel" class="tab-pane active" id="profile">
                              <div class="row">
                              <? if($totalRows_rs_resultado > 0){ ?>
                               <? do { ?>
                               <div class="li-item">
                                <div class="col-md-4 col-sm-4">
                                 <div class="single-product">
                                 <? if($row_rs_resultado['promocao'] == 'S') { ?>
                                   <span class="sale-text">Oferta!</span>
                                 <? } ?>
                                   <div class="product-img">
                                    <a href="desc-produtos.php?id-produto=<?php echo $row_rs_resultado['id'] ?>">
                                     <img class="primary-image" alt="" src="imagens/<?php echo $row_rs_resultado['foto'] ?>">
                                    </a>							
                                   </div>
                                  </div>
                                 </div>
                                 <div class="col-md-8 col-sm-8">
                                  <div class="f-fix">
                                   <h2 class="product-name">
                                    <a href="desc-produtos.php?id-produto=<?php echo $row_rs_resultado['id'] ?>">
                                     <?php echo $row_rs_resultado['nome'] ?>
                                    </a>
                                   </h2>
                                   <div class="pro-rating">
                                    <p class="rating-links" style="margin-left:0px;">
                                     <a href="produtos.php?id-for=<?php echo $row_rs_resultado['fornecedor'] ?>">
                                      Fornecedor: 
                                      <span style="color:#00a9e0;">
									   <?php echo $row_rs_resultado['nomeFornecedor'] ?>
                                      </span>
                                     </a>
                                     <span class="separator">|</span>
                                     <a href="desc-produtos.php?id-produto=<?php echo $row_rs_resultado['id'] ?>">
                                      Qtd. Estoque: <?php echo $row_rs_resultado['estoque'] ?>
                                     </a>
                                   </p>
                                  </div>
                                  <p class="desc">
                                   <?php echo $row_rs_resultado['detalhes'] ?>
                                  </p>
                                  <div class="p-box">
                                   <span class="special-price">
                                    R$<?php echo $row_rs_resultado['preco_por'] ?>
                                   </span>
                                  </div>
                                  <div class="product-icon">
                                   <a href="carrinho.php" class="add-text-cart">
                                    <i class="fa fa-shopping-cart"></i> 
                                     Adicionar ao Carrinho
                                   </a>
                                  </div>
                                 </div>
                                </div>
                               </div>
                               <? } while($row_rs_resultado = mysql_fetch_assoc($rs_resultado)); ?>
                               <? } else { ?>
                                Não foi possível retornar um produto para a palavra-chave usada "<?php echo $_GET['txtProduto']?>".
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
        </section>

		<? include('footer.php') ?>
        	        
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
mysql_free_result($rs_resultado);
?>
