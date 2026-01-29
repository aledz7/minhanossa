<?php 
include('../class/info-site.php');
$infoSite = InfoSite::getInstance(Conexao::getInstance())->rsDados();

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
        <?php include('header.php') ?>
        <!-- end header_area
		============================================ -->
        <!-- start main_shop_area
		============================================ -->
        <section class="main_contact_area">
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
                                        <strong>Contato</strong>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
 
                    <div class="row contact-map">
                        <h3>Nossa Localização</h3>
                        <div id="hastech"></div>
                    </div>
                    <div class="contact-from-atea">
                     <div class="form-and-info">
                      <div class="col-sm-5 col-md-4 npl">
                       <div class="contactDetails contactHead">
                        <h3>Informações de Contato</h3>
                        <p>
                         <span class="iconContact">
                          <i class="fa fa-map-marker"></i>
                         </span>
                          <?php echo $infoSite->endereco ?>
                        
                        </p>
                        <p>
                         <span class="iconContact">
                          <i class="fa fa-phone"></i>
                         </span>
                          Telefone: <?php echo substr($infoSite->telefone, 0, 15) ?>
                          <br>
                          Celular: <?php echo substr($infoSite->celular, 0, 16) ?>
                        </p>
                        <p>
                                        <span class="iconContact">
                                            <i class="fa fa-envelope-o"></i>
                                        </span>
                                        E-mail: <?php echo $infoSite->email ?>
                                        <br>
                                        Loja Virtual:
                                        <a href="<?=$_SERVER['HTTP_HOST'];?>">
                                         <?=$_SERVER['HTTP_HOST'];?>
                                        </a>
                                    </p>
                                </div>
                                <div class="social-area contactHead">
                                    <h3>Nossas Redes Sociais</h3>
                                    <ul class="socila-icon">
                                        <li>
                                            <a href="<?php echo $infoSite->facebook ?>">
                                                <i class="fa fa-facebook"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo $infoSite->twitter ?>">
                                                <i class="fa fa-twitter"></i>
                                            </a>
                                        </li>
                                      
                                        <li>
                                            <a href="<?php echo $infoSite->gplus ?>">
                                                <i class="fa fa-google-plus"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            
                            <div class="col-sm-7 col-md-8 npr">
                             <div class="contactfrom">
                              <h1>Mensagem</h1>
                               <form class="" action="envia.php" method="post" name="formContato" id="formContato">
                                <div class="col-md-6 npl">
                                 <input name="nome" class="form-control" type="text" placeholder="Seu nome" required="">
                                </div>
                                <div class="col-md-6 contactemail npr">
                                 <input name="email" class="form-control" type="email" placeholder="Seu email" required="">
                                </div>
                                <div class="col-md-12 np">
                                 <textarea name="msg" class="form-control" rows="13" placeholder="Mensagem" required></textarea>
                                </div>
                                 <button class="btn btnContact" type="submit">Envie sua mensagem</button>
                                 <input type="hidden" name="acao" id="acao" value="contato" />
                               </form>
                              </div>
                             </div>
                             
                        </div>
                    </div>
                </div>
            </div>
        </section>

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
        <!-- google map api
		============================================ -->
        <script src="http://maps.googleapis.com/maps/api/js"></script>
         <script>
            var myCenter=new google.maps.LatLng(-12.74990, -48.23010);
            function initialize()
            {
            var mapProp = {
              center:myCenter,
              scrollwheel: false,
              zoom:17,
              mapTypeId:google.maps.MapTypeId.ROADMAP
              };
            var map=new google.maps.Map(document.getElementById("hastech"),mapProp);
            var marker=new google.maps.Marker({
              position:myCenter,
                animation:google.maps.Animation.BOUNCE,
              icon:'img/map-marker.png',
                map: map,
              });

            marker.setMap(map);
            }
            google.maps.event.addDomListener(window, 'load', initialize);
        </script>  
		<!-- main JS
		============================================ -->		
        <script src="js/main.js"></script>
    </body>
</html>