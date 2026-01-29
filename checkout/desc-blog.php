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
$query_rs_desc_blog = "SELECT * FROM tbl_noticias WHERE id = '".$_GET['id-blog']."' AND idMenu = 26";
$rs_desc_blog = mysql_query($query_rs_desc_blog, $conexao) or die(mysql_error());
$row_rs_desc_blog = mysql_fetch_assoc($rs_desc_blog);
$totalRows_rs_desc_blog = mysql_num_rows($rs_desc_blog);
?>
<!doctype html>
<html class="no-js" lang="">
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
                                    <li class="home-two">
                                        <a href="blog.php">Blog</a>
                                        <span>
                                            <i class="fa fa-angle-right"></i>
                                        </span>
                                    </li>
                                    <li class="category3">
                                        <strong><?php echo $row_rs_desc_blog['titulo'] ?></strong>
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
                    <div class="col-md-12 col-sm-12">
                        <div class="single-bolg s-post blog">
                            <div class="post-format-area">
                                <div class="b-slide-all">
                                    <img src="img_noticias/<?php echo $row_rs_desc_blog['foto'] ?>" alt="" style="width:100% !important;">
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
                                        <span>Bio Orgânica Equilíbrios</span>
                                    </div>
                                    <h2 class="name">
                                        <?php echo $row_rs_desc_blog['titulo'] ?>
                                    </h2>
                                </div>
                            </div>
                            <p>
                             <?php echo $row_rs_desc_blog['noticia'] ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
		<!-- end shop_area
		============================================ -->
        <!-- start tweets_area
		============================================ -->
         <?php include('footer.php'); ?>
        <!-- end tweets_area
		============================================ -->
        <!-- start ma-footer-stati
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
mysql_free_result($rs_desc_blog);
?>
