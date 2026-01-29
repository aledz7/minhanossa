<?php
include('class/produtos.php');
$produtos = Produtos::getInstance(Conexao::getInstance());

include('class/conteudos.php');
$conteudos = Conteudos::getInstance(Conexao::getInstance());

include('class/clientes.php');
$clientes = Clientes::getInstance(Conexao::getInstance());
$clientes->login($_POST['login'], $_POST['senha'], 'perfil-usuario.php');
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
          <link href="css/teste.css" rel="stylesheet">
          <link rel="shortcut icon" href="images/fav.png" type="image/x-icon" />


<style>
    
    .centros {
        text-align: center!important;
        padding-bottom: 100px;
        padding-top: 90px;
    }

</style>



<script>
    
$('.trigger').click(function (e) {

    e.preventDefault();

    var filtro = $(e.target).data('filter');
    console.log(filtro);

    switch (filtro) {

        case "teste":
            $('.logons').show();
            $('.teste').show();
            $('.advertise').hide();
            $('.print').hide();
            break;

        case "advertise":
            $('.logons').show();
            $('.advertise').show();
            $('.teste').hide();
            $('.print').hide();
            break;

        case "print":
            $('.advertise').hide();
            $('.teste').hide();
            $('.print').show();
            $('.logons').show();
            break;

        case "all":
            $('.advertise').show();
            $('.teste').show();
            $('.print').show();
            $('.logons').show();
            break;

        default:
            $('.teste').show();
            $('.advertise').show();
            $('.print').show();
            $('.logons').show();

    }


});


</script>







    </head>
    <body>
        
        <?php include('header.php');?>
        
<section class="slide-wrapper">
        <div class="banner" style="padding: 48px 0 0">

            <div class="container">
    
                <div class="row row-centered" style="background-color: #fff; padding-top: 40px;">
                    <div class="col-sm-6 text-left">
                       <h1 class="text-left">produtos</h1>
                       <p class="text-left" style="-9px 0 10px;">265 produtos disponíveis agora</p> 
                    </div>
                    <div class="col-sm-6 text-right">
                       <div class="eco_filter">
                                                    <ul class="eco_filter_title">
                                                            <li><a data-filter="all" href="#" class="filter-item active trigger">todas</a>
                                                            </li>
                                                            <li><a data-filter="teste" href="#" class="filter-item trigger">roupas</a>
                                                            </li>
                                                            <li><a data-filter="advertise" href="#" class="filter-item trigger">acessórios</a>
                                                            </li>
                                                            <li><a data-filter="print" href="#" class="filter-item trigger">bolsas e cintos</a>
                                                            </li>
                                                    </ul>
                                            </div>
                    </div>   
                    
                      <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10 col-centered" >

        
    <div class="eco_inner_page_container">
        
            
            <div class="eco_mix_grid" id="grid">


                            <?php
                            if($novidades = $produtos->rsDados =='')
                                {

                                    echo "<h3 class='centros'>Não há produtos disponíveis<br/></h3>";
                                }

                            else {
                            $novidades = $produtos->rsDados();
                                    foreach($novidades as $novidade) { 
                                $categoria = $conteudos->rsDados('', $novidade->id_categoria);
                                }

                            ?> 


                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 padder_bottom_30 eco_show_overlay photography mix">
                     <div>
                                <div class="thumbnail">
                                    <a href="detalhes.php?id=<?php echo $novidade->id;?>"><img src="img_noticias/<?php echo $novidade->foto;?>" alt=""></a>
                                    <div class="caption deg-produto-rosa text-left caption-color" style="padding: 53px 10px 0px;">
                                        <small><?php echo $categoria->titulo;?></small>
                                        <h4><?php echo $novidade->nome;?></h4>
                                        <div class="clearfix">&nbsp;</div>
                                        <div class="estrela">
                                            <i class="fa fa-star"></i>
                                        </div>
                                        
                                        
                                    </div>
                                </div>
                            </div>
                </div>
                <?php } ?>





<!-- ITEMS -->


                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 padder_bottom_30 eco_show_overlay photography mix teste">
                     <div>
                                <div class="thumbnail">
                                    <a href="detalhes.php?id=<?php echo $novidade->id;?>"><img src="https://www.minhanossa.net.br/sistema/img_noticias/img_reduz_peca_157684428049_foto_N.jpg" alt=""></a>
                                    <div class="caption deg-produto-rosa text-left caption-color" style="padding: 53px 10px 0px;">
                                        <small>TESTE 1</small>
                                        <h4>TESTE 1</h4>
                                        <div class="clearfix">&nbsp;</div>
                                        <div class="estrela">
                                            <i class="fa fa-star"></i>
                                        </div>
                                        
                                        
                                    </div>
                                </div>
                            </div>
                </div>


                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 padder_bottom_30 eco_show_overlay photography mix teste">
                     <div>
                                <div class="thumbnail">
                                    <a href="detalhes.php?id=<?php echo $novidade->id;?>"><img src="https://www.minhanossa.net.br/sistema/img_noticias/img_reduz_peca_157684428049_foto_N.jpg" alt=""></a>
                                    <div class="caption deg-produto-rosa text-left caption-color" style="padding: 53px 10px 0px;">
                                        <small>TESTE 2</small>
                                        <h4>TESTE 2</h4>
                                        <div class="clearfix">&nbsp;</div>
                                        <div class="estrela">
                                            <i class="fa fa-star"></i>
                                        </div>
                                        
                                        
                                    </div>
                                </div>
                            </div>
                </div>



                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 padder_bottom_30 eco_show_overlay photography mix advertise">
                     <div>
                                <div class="thumbnail">
                                    <a href="detalhes.php?id=<?php echo $novidade->id;?>"><img src="https://www.minhanossa.net.br/sistema/img_noticias/img_reduz_peca_157684428049_foto_N.jpg" alt=""></a>
                                    <div class="caption deg-produto-rosa text-left caption-color" style="padding: 53px 10px 0px;">
                                        <small>TESTE 3</small>
                                        <h4>TESTE 3</h4>
                                        <div class="clearfix">&nbsp;</div>
                                        <div class="estrela">
                                            <i class="fa fa-star"></i>
                                        </div>
                                        
                                        
                                    </div>
                                </div>
                            </div>
                </div>


                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 padder_bottom_30 eco_show_overlay photography mix advertise">
                     <div>
                                <div class="thumbnail">
                                    <a href="detalhes.php?id=<?php echo $novidade->id;?>"><img src="https://www.minhanossa.net.br/sistema/img_noticias/img_reduz_peca_157684428049_foto_N.jpg" alt=""></a>
                                    <div class="caption deg-produto-rosa text-left caption-color" style="padding: 53px 10px 0px;">
                                        <small>TESTE 4</small>
                                        <h4>TESTE 4</h4>
                                        <div class="clearfix">&nbsp;</div>
                                        <div class="estrela">
                                            <i class="fa fa-star"></i>
                                        </div>
                                        
                                        
                                    </div>
                                </div>
                            </div>
                </div>






                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 padder_bottom_30 eco_show_overlay photography mix print">
                     <div>
                                <div class="thumbnail">
                                    <a href="detalhes.php?id=<?php echo $novidade->id;?>"><img src="https://www.minhanossa.net.br/sistema/img_noticias/img_reduz_peca_157684428049_foto_N.jpg" alt=""></a>
                                    <div class="caption deg-produto-rosa text-left caption-color" style="padding: 53px 10px 0px;">
                                        <small>TESTE 5</small>
                                        <h4>TESTE 5</h4>
                                        <div class="clearfix">&nbsp;</div>
                                        <div class="estrela">
                                            <i class="fa fa-star"></i>
                                        </div>
                                        
                                        
                                    </div>
                                </div>
                            </div>
                </div>


                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 padder_bottom_30 eco_show_overlay photography mix print">
                     <div>
                                <div class="thumbnail">
                                    <a href="detalhes.php?id=<?php echo $novidade->id;?>"><img src="https://www.minhanossa.net.br/sistema/img_noticias/img_reduz_peca_157684428049_foto_N.jpg" alt=""></a>
                                    <div class="caption deg-produto-rosa text-left caption-color" style="padding: 53px 10px 0px;">
                                        <small>TESTE 6</small>
                                        <h4>TESTE 6</h4>
                                        <div class="clearfix">&nbsp;</div>
                                        <div class="estrela">
                                            <i class="fa fa-star"></i>
                                        </div>
                                        
                                        
                                    </div>
                                </div>
                            </div>
                </div>







<!-- ITEMS -->




<!--
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 padder_bottom_30 eco_show_overlay audio mix">
                                <div class="thumbnail">
                                    <img src="images/produto2.png" alt="">
                                    <div class="caption deg-produto-verde text-left caption-color" style="padding: 53px 10px 0px;">
                                        <small>BOLSAS E CINTOS</small>
                                        <h4>Ecobag estampada silk alça couro</h4>
                                        <div class="clearfix">&nbsp;</div>
                                        <div class="estrela">
                                            <i class="fa fa-star"></i>
                                        </div>
                                        
                                        
                                    </div>
                                </div>
                            
                </div>
               <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 padder_bottom_30 eco_show_overlay videos mix">
                     
                                <div class="thumbnail">
                                    <img src="images/produto3.png" alt="">
                                    <div class="caption deg-produto-azul text-left caption-color" style="padding: 53px 10px 0px;">
                                        <small>BOLSAS E CINTOS</small>
                                        <h4>Ecobag estampada silk alça couro</h4>
                                        <div class="clearfix">&nbsp;</div>
                                        <div class="estrela">
                                            <i class="fa fa-star"></i>
                                        </div>
                                    </div>
                                </div>
                            
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 padder_bottom_30 eco_show_overlay photography mix">
                     <div>
                                <div class="thumbnail">
                                    <img src="images/produto1.png" alt="">
                                    <div class="caption deg-produto-rosa text-left caption-color" style="padding: 53px 10px 0px;">
                                        <small>BOLSAS E CINTOS</small>
                                        <h4>Ecobag estampada silk alça couro</h4>
                                        <div class="clearfix">&nbsp;</div>
                                        <div class="estrela">
                                            <i class="fa fa-star"></i>
                                        </div>
                                        
                                        
                                    </div>
                                </div>
                            </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 padder_bottom_30 eco_show_overlay audio mix">
                                <div class="thumbnail">
                                    <img src="images/produto2.png" alt="">
                                    <div class="caption deg-produto-verde text-left caption-color" style="padding: 53px 10px 0px;">
                                        <small>BOLSAS E CINTOS</small>
                                        <h4>Ecobag estampada silk alça couro</h4>
                                        <div class="clearfix">&nbsp;</div>
                                        <div class="estrela">
                                            <i class="fa fa-star"></i>
                                        </div>
                                        
                                        
                                    </div>
                                </div>
                            
                </div>
-->
                
                            <br><br>
                

                
<!--
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 padder_bottom_30 eco_show_overlay audio mix">
                                <div class="thumbnail">
                                    <img src="images/produto2.png" alt="">
                                    <div class="caption deg-produto-verde text-left caption-color" style="padding: 53px 10px 0px;">
                                        <small>BOLSAS E CINTOS</small>
                                        <h4>Ecobag estampada silk alça couro</h4>
                                        <div class="clearfix">&nbsp;</div>
                                        <div class="estrela">
                                            <i class="fa fa-star"></i>
                                        </div>
                                        
                                        
                                    </div>
                                </div>
                            
                </div>
                
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 padder_bottom_30 eco_show_overlay audio mix">
                                <div class="thumbnail">
                                    <img src="images/produto2.png" alt="">
                                    <div class="caption deg-produto-verde text-left caption-color" style="padding: 53px 10px 0px;">
                                        <small>BOLSAS E CINTOS</small>
                                        <h4>Ecobag estampada silk alça couro</h4>
                                        <div class="clearfix">&nbsp;</div>
                                        <div class="estrela">
                                            <i class="fa fa-star"></i>
                                        </div>
                                        
                                        
                                    </div>
                                </div>
                            
                </div>
                
                
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 padder_bottom_30 eco_show_overlay videos mix">
                     
                                <div class="thumbnail">
                                    <img src="images/produto3.png" alt="">
                                    <div class="caption deg-produto-azul text-left caption-color" style="padding: 53px 10px 0px;">
                                        <small>BOLSAS E CINTOS</small>
                                        <h4>Ecobag estampada silk alça couro</h4>
                                        <div class="clearfix">&nbsp;</div>
                                        <div class="estrela">
                                            <i class="fa fa-star"></i>
                                        </div>
                                    </div>
                                </div>
                            
                </div>                          
-->
                
                
                <div class="clearfix"></div>

                <div class="col-md-12">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 padder_bottom_30">
                                <div class="thumbnail" style=" padding-bottom: 184px;">
                    
                    <div class="caption text-center" style="color: #f05b66">
                        <h4>Já tem sua conta?</h4>
                        
                        <form method="post" class="login" name="formLogin" id="formLogin" class="form-inline" role="form">
                        
                            <div class="form-group text-center">
                                <label for="" style="color: #c6d5ed;font-weight: 100;">Login</label>
                                <input type="text" style="text-align: center; border: none" class="form-control" id="" name="login">
                            </div>
                            <hr>
                            <div class="form-group text-center">
                                <label for="" style="color: #c6d5ed;font-weight: 100;">Senha</label>
                                <input type="password" style="text-align: center; border: none" class="form-control" id="" name="senha">
                            </div>
                            <hr>
                            
                            
                            
                            <span class="input-group-btn btn-lg text-center">
                                <button type="button" style="    border-color: #d76e79; color: #d76e79; border-radius: 0;
    padding: 15px 45px 15px;" class="btn btn-default" onClick="document.getElementById('formLogin').submit()">Entrar</button>
                                
                            </span>
                           <span class="text-center" style="color: #c6d5ed;font-weight: 100; font-size: 11px;"><a href="esqueci-minha-senha.php">ESQUECI MINHA SENHA</a></span>
                            
                            
                            <span class="input-group-btn btn-lg text-center">
                                <a href="formulario.php" class="btn btn-default" style="background-color: #d76e79;
    color: #fff;
    border: none;
    padding: 20px 51px 17px;
    margin-left: -10px;
    border-radius: 0;">Criar minha conta!</a>
                                
                            </span>
                            <input type="hidden" name="acao" value="perfil-usuario.php">
                        </form>
                        
                            
                        
                    </div>
                </div>
                            
                </div>


                </div>



            </div>
            <!--pagination-->
            
            <!--pagination-->
       
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
         <div class="clearfix">&nbsp;</div>
        
      <?php include('footer.php');?>
          
    <!--container-->
    <!--go to top Start-->
    
    <!--go to top End-->
    <!--Footer Section Start-->
    
    <!--Footer Section End-->
    <!--Script Start-->
    
    <!-- Latest compiled and minified CSS & JS -->

    <script src="//code.jquery.com/jquery.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    
    <!-- <script src="js/jquery-1.11.1.min.js" type="text/javascript"></script> -->
    <!-- <script src="js/bootstrap.js" type="text/javascript"></script> -->
    <script src="js/jquery.bxslider.min.js"></script>
    <!-- <script src="js/plugins/prettyphoto/jquery.prettyPhoto.js" type="text/javascript"></script> -->
    <!-- <script src="js/plugins/rainyday/rainyday.js" type="text/javascript"></script> -->
    <script src="js/jquery.mixitup.js" type="text/javascript"></script>
    <!-- <script src="js/scrollReveal.js" type="text/javascript"></script> -->
    <!-- <script src="js/circles.js" type="text/javascript"></script> -->
    <!-- <script src="js/plugins/countto/jquery.countTo.js" type="text/javascript"></script> -->
    <!-- <script src="js/plugins/countto/jquery.appear.js" type="text/javascript"></script> -->
    <!-- <script src="js/plugins/parallax/jquery.parallax-1.1.3.js" type="text/javascript"></script> -->
    <!-- <script src="js/plugins/revolution/js/jquery.themepunch.revolution.min.js" type="text/javascript"></script> -->
    <!-- <script src="js/plugins/revolution/js/jquery.themepunch.tools.min.js" type="text/javascript"></script>
    <script src="js/plugins/jquery-ui/jquery-ui.js" type="text/javascript"></script>
    <script src="js/plugins/smoothscroll/smoothScroll.js" type="text/javascript"></script> -->
    <script src="js/custom.js" type="text/javascript"></script>
    <!-- <script src="http://maps.googleapis.com/maps/api/js?key=&amp;sensor=false"></script> -->
    <!--Script End-->
    <!--Body End-->
</body>

</html>