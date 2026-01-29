<?php 
if (!isset($_SESSION)) { session_start(); }

include('Connections/conexao.php'); 
include('funcoes.php');

include('../class/clientes.php');
$clientes = Clientes::getInstance(Conexao::getInstance());

if($_GET['volta'] == 'lista_desejos') {
	$volta = $_SESSION['volta_login'];
} elseif($_GET['volta'] <> '') {
	$volta = $_GET['volta'];
} else {
	$volta = 'area-cliente.php';
}
$clientes->login($_POST['email'], $_POST['senha'], $volta);

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
        <section class="collapse_area">
         <div class="container">
          <div class="row">
           <div class="col-md-12 col-sm-12">
            <div class="check">
             <h1>Identificação</h1>
            </div>
            <div class="faq-accordion">
             <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
              <div class="panel panel-default">
               <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne" aria-expanded="false" >
                <div class="row">
                 <div class="easy">
                   <div class="col-sm-6">
                    <div class="Register easy-res">
                     <h3>JÁ SOU CADASTRADO</h3>
                    </div>
                    <p class="log">Por favor faça o login:</p>
                     <form action="<?php echo $loginFormAction; ?>" method="POST" name="formLogin" id="formLogin">
                      <div class="input-one form-list">
                      <label class="required">
                       E-mail
                       <em>*</em>
                      </label>
                      <input class="email" name="email" type="text" required="">
                      </div>
                      <div class="input-one form-list">
                      <label class="required">
                       Senha
                       <em>*</em>
                      </label>
                      <input class="email" name="senha" type="password" required="">
                     </div>
                    <div class="block-button-right">
                     <a href="javascript:;" onClick="MM_openBrWindow('ferramentas/esqueci-minha-senha.php','esqueciSenha','status=yes,width=400,height=130')">Esqueceu a senha?</a>
                      <button class="button2 get" type="submit" title="">
                       <span>Continuar</span>
                      </button>
                     </div>
                     <input type="hidden" name="volta" value="<?=$_GET['volta'];?>">
                    </form>
                   </div>
                   <div class="col-sm-6">
                   <div class="Register">
                    <h3>NÃO TENHO CADASTRO</h3>
                   </div>
                   <p class="log">Registre-se para sua conveniência no futuro:</p>
                    <form action="cadastrar.php" method="POST" name="formCadastro" id="formCadastro">
					<div class="input-one form-list">
                      <label class="required">
                       E-mail
                       <em>*</em>
                      </label>
                      <input class="email" type="text" required="" name="email">
                    </div>
                    <div class="block-button-left">
                     <button class="button2 get" type="submit" title="">
                      <span>Criar cadastro</span>
                     </button>
                    </div>
                   </form>
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
