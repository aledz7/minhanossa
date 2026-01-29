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
$query_rs_blog = "SELECT * FROM tbl_noticias WHERE idMenu = 26 ORDER BY id DESC";
$rs_blog = mysql_query($query_rs_blog, $conexao) or die(mysql_error());
$row_rs_blog = mysql_fetch_assoc($rs_blog);
$totalRows_rs_blog = mysql_num_rows($rs_blog);

mysql_select_db($database_conexao, $conexao);
$query_rs_blog_antigo = "SELECT * FROM tbl_noticias WHERE idMenu = 26 ORDER BY id ASC LIMIT 0,9";
$rs_blog_antigo = mysql_query($query_rs_blog_antigo, $conexao) or die(mysql_error());
$row_rs_blog_antigo = mysql_fetch_assoc($rs_blog_antigo);
$totalRows_rs_blog_antigo = mysql_num_rows($rs_blog_antigo);
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
        <div class="main_contact_area">
            <div class="breadcrumbs">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="container-inner">
                                <ul>
                                    <li class="home">
                                        <a href=".">Home</a>
                                        <span>
                                            <i class="fa fa-angle-right"></i>
                                        </span>
                                    </li>
                                    <li class="category3">
                                        <strong>Blog</strong>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
        
        <section class="main-blog-area">
            <div class="container">
                <div class="row">
                  <div class="col-md-9 col-sm-9 col-xs-12">
                   <? do { ?>
                    <div class="single-bolg">
                     <div class="post-format-area">
                      <div class="b-slide-all">
                       <img src="img_noticias/<?php echo $row_rs_blog['foto'] ?>" alt="" style="width: 100% !important;">
                      </div>
                     </div>
                    <div class="entry-header-area">
                        <div class="post-types">
                            <i class="fa fa-picture-o"></i>
                        </div>
                        <div class="info-blog">
                            <div class="single-b-info category-name">
                                <i class="fa fa-folder-open-o"></i>
                                <a href="#">
                                    <span>Blog</span>
                                </a>
                            </div>
                            <div class="single-b-info createdby">
                                <i class="fa fa-user"></i>
                                <span>Bio Orgânica Equilibrios</span>
                            </div>
                            <h2 class="name">
                                <a href="desc-blog.php?id-blog=<?php echo $row_rs_blog['id'] ?>">
                                 <?php echo $row_rs_blog['titulo'] ?>
                                </a>
                            </h2>
                        </div>
                    </div>
                    <p><?php echo $row_rs_blog['breve'] ?></p>
                    <div class="blog-comments-links">
                        <a class="readmore-link" href="desc-blog.php?id-blog=<?php echo $row_rs_blog['id'] ?>" title="Images">
                         Leia Mais
                        </a>
                    </div>
                </div>
               <? } while($row_rs_blog = mysql_fetch_assoc($rs_blog)); ?>
              </div>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <div class="blog-right-sidebar">
                            <div>
                                <h3 class="sp-module-title">
                                    <span>Últimos Post's</span>
                                </h3>
                                <? do { ?>
                                <div class="single-l-post">
                                    <a href="desc-blog.php?id-blog=<?php echo $row_rs_blog_antigo['id'] ?>">
									 <?php echo $row_rs_blog_antigo['titulo'] ?>
                                    </a>
                                    <p><?php echo date('d/m/Y', strtotime($row_rs_blog_antigo['data'])); ?></p>
                                </div>
                                <? } while($row_rs_blog_antigo = mysql_fetch_assoc($rs_blog_antigo)); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
		<!-- end shop_area
		============================================ -->
        <!-- start tweets_area
		============================================ -->
         <? include('footer.php'); ?>
        <!-- end tweets_area
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
mysql_free_result($rs_blog);
?>
