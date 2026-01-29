<?php 
include('class/marcas.php');
$marcas = Marcas::getInstance(Conexao::getInstance());
$pegamarcas = $marcas->rsDados();

include('class/fotos.php');
$fotos = Fotos::getInstance(Conexao::getInstance());

include('funcoes/cortar-imagem.php');

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
    
    <div class="row row-centered" style="background-color: #fff; padding-top: 40px;" >
        <div class="col-sm-6 text-left">
           <h1 class="text-left">Esqueci minha senha!</h1>
        </div>
        <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10 col-centered">
       
            <div class="col-md-12 no-padding lib-item pull-right" data-category="view" >
                <div class="lib-panel" id="box" >
                    <div class="row box-shadow A" id="filter">
                        <div class="col-md-offset-3 col-md-6">
                     <form method="post" class="login" name="formLogin" id="formLogin" class="form-inline" action="envia.php">
                        
                            <div class="form-group text-center">
                                <label for="" style="color: #6A2C2D;font-weight: 700;">Seu E-mail</label>
                                <input type="email" class="form-control" name="email">
                            </div>
                          
                            <input name="acao" type="hidden" id="acao" value="senha" />
                            <span class="input-group-btn btn-lg text-center">
                                <button type="submit" style="border-color: #d76e79; color: #d76e79; border-radius: 0; padding: 12px 45px 11px;" class="btn btn-default">Enviar</button>
                                
                           
                            
                          <?php /*?>  <span class="input-group-btn btn-lg text-center">
                                <a href="criar-conta.php" class="btn btn-default" style="background-color: #d76e79;
    color: #fff;
    border: none;
    padding: 9px 51px 11px;
    margin-left: -10px;
    border-radius: 0;">Criar minha conta!</a>
                                
                            </span><?php */?>
                            
                            
                        </form>
                       </div>                         
                    </div>
                    
                    <div class="clearfix">
                    &nbsp;
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
    

<script>
    $("#filters a").click(function(e){ 
    
    e.preventDefault();  
    
    var filter = $(this).attr("id"); 
    
    if (filter == "sort") {
        
        $("#box ul li").sort(asc_sort).appendTo("#filter");
    }
    else {
        
        $("#box ul li").show();  
        $("#box ul li:not(." + filter + ")").hide(); 
    }
}); 

function asc_sort(a, b) { 
    return ($(b).text()) < ($(a).text());
}
</script>

         
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
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/script.js"></script>
</html>