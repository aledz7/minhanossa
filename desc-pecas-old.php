<?php
include('class/clientes.php');
$clientes = Clientes::getInstance(Conexao::getInstance());
$clientes->login($_POST['login'], $_POST['senha'], 'perfil-usuario.php');
?>
<!DOCTYPE html>
<html lang="pt_BR">
	
<!-- Head -->
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
<!-- Head //-->
	
<!-- Body -->	
<body>

<!-- Header -->
<?php include('header.php');?>
<!-- Header -->
	
<style>
.borda-contato1 {
border: 2px solid #d76e79;
padding: 328px 329px 148px;
margin: 0px 316px 0;
position: absolute;
z-index: 9;
top: 5px;
}
	
 
.foto img { 
width:300px;
height: 500px;
float: none;
margin: 5px;
text-align: center;

} 

</style>
		
  <section class="slide-wrapper">
     <div class="banner" style="padding: 48px 0 0">
       <div class="container">
         <div class="row row-centered" style="background-color: #fff; padding-top: 40px;" >
           <div class="col-sm-6 text-left">
             <h1 style="margin-left: 75px;">Minhas peças</h1>
           </div>
              <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10 col-centered">
                <div class="col-md-12 no-padding lib-item pull-right" data-category="view" >
                  <div class="lib-panel" >
                    <div class="row box-shadow">
						  <div class="borda-contato1">
                       	 &nbsp;
<!--
                        	 <div class="botao-termos">
                        	 	<a href="">termos & condições de uso</a>
                        	 </div>
-->
                        </div>
						
						
						<!-- Lado esquerdo -->
                        <div class="col-xs-12 col-md-4 col-sm-4">
						  <div class="foto" style="margin-left: -30px;">
                            <img src="images/teste1.png" alt="">
						  </div>
                        </div>
						<!-- Lado esquerdo //-->
						
						<!-- Meio -->
						 <div class="col-xs-12 col-md-4 col-sm-4"><br>
                            <h4 style="color: #f8abb2">Camisa Branca</h4>
                            <h4 style="color: #f8abb2">Tamanhos: 38, 42, 44</h4>
                            <h4 style="color: #f8abb2">Aqui você usa por 46 pontos.</h4><br>
							
							<h4 style="color: #99d2d2">Camisa Branca</h4>
                            <h4 style="color: #99d2d2">Tamanhos: 38, 42, 44</h4>
							<h4 style="color: #99d2d2">Aqui você usa por 46 pontos.</h4><br>
							 
							<h4 >Camisa Branca</h4>
                            <h4 >Tamanhos: 38, 42, 44</h4>
                            <h4 >Aqui você usa por 46 pontos.</h4><br>
							
							<h4 style="color: #f8abb2">Camisa Branca</h4>
                            <h4 style="color: #f8abb2">Tamanhos: 38, 42, 44</h4>
							<h4 style="color: #f8abb2">Aqui você usa por 46 pontos.</h4>
                        </div>
						<!-- Meio //-->
						
						<!-- Lado direito -->
						 <div class="col-xs-12 col-md-4 col-sm-4"><br>
                            <h4 style="color: #f8abb2">Camisa Branca</h4>
                            <h4 style="color: #f8abb2">Tamanhos: 38, 42, 44</h4>
                            <h4 style="color: #f8abb2">Aqui você usa por 46 pontos.</h4><br>
							
							<h4 style="color: #99d2d2">Camisa Branca</h4>
                            <h4 style="color: #99d2d2">Tamanhos: 38, 42, 44</h4>
							<h4 style="color: #99d2d2">Aqui você usa por 46 pontos.</h4><br>
							 
							<h4 >Camisa Branca</h4>
                            <h4 >Tamanhos: 38, 42, 44</h4>
                            <h4 >Aqui você usa por 46 pontos.</h4><br>
							
							<h4 style="color: #f8abb2">Camisa Branca</h4>
                            <h4 style="color: #f8abb2">Tamanhos: 38, 42, 44</h4>
							<h4 style="color: #f8abb2">Aqui você usa por 46 pontos.</h4>
                        </div>
						<!-- Lado direito //-->
						
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
		
<!-- Footer -->	
<?php include('footer.php');?>
<!-- Footer //-->	

</body>
<!-- Body //-->
	
<!-- Latest compiled and minified JS -->
<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/script.js"></script>
</html>