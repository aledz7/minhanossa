<?php
include('class/clientes.php');
$clientes = Clientes::getInstance(Conexao::getInstance());
$clientes->login($_POST['login'], $_POST['senha'], 'perfil-usuario.php');
include('class/fotos.php');
$fotos = Fotos::getInstance(Conexao::getInstance());
include('funcoes/cortar-imagem.php');
include('class/categorias.php');
$categorias = Categorias::getInstance(Conexao::getInstance());

mysql_select_db($database_conexao, $conexao);
$query_rs_fotos = "SELECT * FROM tbl_fotosfeed ORDER BY id ASC";
$rs_fotos = mysql_query($query_rs_fotos, $conexao) or die(mysql_error());
$row_rs_fotos = mysql_fetch_assoc($rs_fotos);
$totalRows_rs_fotos = mysql_num_rows($rs_fotos);
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
          <script src="https://apps.elfsight.com/p/platform.js" defer></script>
    </head>
    <body>
        
		<?php include('header.php');?>
		
<style>
      .centro {
        text-align: center !important;
      }
      .borda-contato1 {
    border: 2px solid #d76e79;
    padding: 188px 230px 156px;
    margin: 2px 0 0;
    position: absolute;
    z-index: 9;
}
.eapps-instagram-feed-container {
    padding-top: 32px !important;
}
.eapps-link {
  opacity: 0 !important;
}
</style>	
<section class="slide-wrapper">
    <div class="banner" style="padding: 48px 0 0">
        <div class="container">
            <div class="row row-centered" style="background-color: #fff; padding-top: 40px;" >
                <div class="col-sm-12 text-center">
                    <h1 class="text-center">LOJA</h1>
                </div>
                
                <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10 col-centered">
                    <div class="col-md-12 no-padding lib-item pull-right" data-category="view" >
                        <div class="lib-panel" >
                            <div class="row box-shadow">
                                    <div class="borda-contato1">
                                        &nbsp;
                                            <!-- <div class="botao-termos">
                                                <a href="">termos & condições de uso</a>
                                            </div> -->
                                    </div>
                                    <div class="col-md-6">                           
                                        <div class="lib-row lib-desc" style="padding: 17px 42px 0; font-size: 16px; font-weight: bold;">
                                                <div class="clearfix">&nbsp;</div>
                                                <i class="fa fa-map-marker" style="background-color: #71bbac;padding: 7px 11px 7px;border-radius: 51px;color: #fff;"></i>
                                                <div><?php echo utf8_decode($infoSite->logradouro);?></div>
                                                <div>CEP: <?php echo $infoSite->cep;?></div>
                                                <br>
                                                <i class="fa fa-comment-o" style="background-color: #71bbac;padding: 7px 8px 7px; border-radius: 30px;color: #fff;"></i>
                                                <br>
                                                <div><?php echo $infoSite->email;?></div>
                                                <div><?php echo $infoSite->telefone;?></div>
                                                <div><?php echo $infoSite->telefone2;?></div>
                                                <div class="clearfix">&nbsp;</div>     
                                        </div>
                                    </div>
                                <div class="col-md-6">
                                <?php
                                    if($totalRows_rs_fotos > 0){
                                    do{?>
                                    <div class="col-md-4" style="margin-top: 5px;" >
                                        <img src="minhanossa/img_noticias/<?php echo $row_rs_fotos['foto'];?>" alt="" width="80" height="180">
                                        </div>
                                    <?php }while($row_rs_fotos = mysql_fetch_assoc($rs_fotos));
			}
			?>
                                </div>
                            </div>
                        </div>
                    </div>   
                </div>
            </div> 
        </div>
    </div>
</section>
    <section>
          <br><br>
      <section class="col-md-12">
<!--          <h1 class="centro">siga a minha nossa! no instagram  </h1>               -->
            <div class="row">
              <br>
              <script>
                var links = document.getElementsByTagName("a");
                  for (var i = 0; i < links.length; ++i) {
                      if (links[i].href.toLowerCase().indexOf("https://elfsight.com/instagram-feed-instashow/?utm_source=websites&utm_medium=clients&utm_content=instagram-feed&utm_term=www.minhanossa.net.br&utm_campaign=free-widget") >= 0) {
                          links[i].parentNode.style.display = "none";
                          break;
                      }
                  }
              </script>

              <style>
                .eapps-remove-link {
                  opacity: 0 !important;
                }
                .eapps-link {
                  opacity: 0 !important;
                }
              </style>
                <div class="elfsight-app-b3d6a11b-dffc-4e8f-8491-515449adbc56 classe-inst"></div>
            </div>             
      </section>
            
            <div class="container">
                
                <div class="row row-centered">
                    <div class="col-xs-12 col-sm-11 col-md-offset-3 col-md-11 col-lg-11 col-centered">
                       <!-- <h1>siga a minha nossa! no instagram  </h1>
                       <br>-->
            	        </div>
                            <div class="col-xs-12 col-md-offset-3 col-sm-6 col-md-6 col-lg-6">
								<div class="clearfix"></div>
                                <div style="margin-top: 50px;">
									<!-- InstaWidget -->




									<!--<a href="https://instawidget.net/v/user/querominhanossa" id="link-71c603dc666a8a7d4d1be7e73fde9a643e0c9d565edbe279b52c621a6698ae6a">@querominhanossa</a>
									<script src="https://instawidget.net/js/instawidget.js?u=71c603dc666a8a7d4d1be7e73fde9a643e0c9d565edbe279b52c621a6698ae6a&width=500px"></script>-->



                                </div>
                            </div>



                            <?php /*?> <div class="col-xs-12 col-md-offset-2 col-sm-4 col-md-6 col-lg-4">
                                 <div>
                                     <img src="images/facebookminhanossa.png" alt="" width="317">
                                  </div>
                                  <div class="thumbnail" style="">
                    
                   					 <div class="caption text-center" style="color: #f05b66">
                        <h4>Já tem sua conta?</h4>
                        
                        <form method="post" class="login" name="formLogin" id="formLogin" class="form-inline" role="form">
                        
                            <div class="form-group text-center">
                                <label for="" style="color: #c6d5ed;font-weight: 100;">Login</label>
                                <input type="text" style="text-align: center; border: none" class="form-control" name="login">
                            </div>
                            <hr>
                            <div class="form-group text-center">
                                <label for="" style="color: #c6d5ed;font-weight: 100;">Senha</label>
                                <input type="senha" style="text-align: center; border: none" class="form-control" name="senha">
                            </div>
                            <hr>
                            
                            
                            
                            <span class="input-group-btn btn-lg text-center">
                                <button type="submit" style="    border-color: #d76e79; color: #d76e79; border-radius: 0;
    padding: 15px 45px 15px;" class="btn btn-default">Entrar</button>
                                
                            </span>
                           <span class="text-center" style="color: #c6d5ed;font-weight: 100; font-size: 11px;"><a href="esqueci-minha-senha.php"> ESQUECI MINHA SENHA</a></span>
                            

                            <span class="input-group-btn btn-lg text-center">
                                <a href="index.php" class="btn btn-default" style="background-color: #d76e79;
    color: #fff;
    border: none;
    padding: 20px 51px 17px;
    margin-left: -10px;
    border-radius: 0;">Criar minha conta!</a>
                                
                            </span>
                            
                        </form>
                        
                            
                        
                    </div>
               					 </div>
                            </div><?php */?>
                        
                    </div>
             </div>
            
        </section>



         
<!--
         <div class="clearfix">&nbsp;</div>
         <div class="clearfix">&nbsp;</div>
         <div class="clearfix">&nbsp;</div>
         <div class="clearfix">&nbsp;</div>
         <div class="clearfix">&nbsp;</div>
         <div class="clearfix">&nbsp;</div>
         <div class="clearfix">&nbsp;</div>
         <div class="clearfix">&nbsp;</div>
         <div class="clearfix">&nbsp;</div>
-->
		
     <?php include('footer.php');?>


    </body>
    <!-- Latest compiled and minified JS -->
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/script.js"></script>
</html>