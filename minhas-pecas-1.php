<?php

include('class/textos.php');
$textos = Textos::getInstance(Conexao::getInstance());
include('class/marcas.php');
$marcas = Marcas::getInstance(Conexao::getInstance());
$pegamarcas = $marcas->rsDados();
include('class/fotos.php');
$fotos = Fotos::getInstance(Conexao::getInstance());
include('funcoes/cortar-imagem.php');


mysql_select_db($database_conexao, $conexao);
$query_rs_cats = "SELECT * FROM tbl_cats ORDER BY ID ASC";
$rs_cats = mysql_query($query_rs_cats, $conexao) or die(mysql_error());
$row_rs_cats = mysql_fetch_assoc($rs_cats);
$totalRows_rs_cats = mysql_num_rows($rs_cats);


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
    <link rel="stylesheet" href="dist/css/lightbox.css">
    <link rel="shortcut icon" href="images/fav.png" type="image/x-icon" />
    <style>

      .centro {
        text-align: center !important;
      }

      .more_add {
        background-color: #fff;
        font-weight: 700;
        color: #d76e79;
        border: 2px solid #d76e79;
        padding: 7px 30px 14px;
        margin-left: 0px;
        margin-top: 25px;
        margin-bottom: 25px;
      }
      .foto{
        margin-bottom: 20px;
      }
      .img_mod{
        width: 100%;
      }

      .caixa {
        text-transform: uppercase;
      }

      .mg-lft-15p{
        margin-left: 10px;
      }
      .icom{
        color: #d76e79;
      }
      .icom:hover{
        color: #21294d;
      }
      .traco{
          margin-top: -12px!important;
            margin-bottom: 28px;
      }
    </style>




    <script type="text/javascript" src="http://codysherman.com/tools/infinite-scrolling/code"></script>












     </head>
        <body>
          <?php include('header.php');?>
          <section class="slide-wrapper">
            <div class="banner" style="padding: 48px 0 0">
              <div class="container">
        
                    <div class="col-sm-12">
            <h1 class="centro">MINHAS (NOSSAS!) PEÇAS</h1>
                <?php $duaslinhas = $textos->rsDados(4);?>
              <?php echo substr($duaslinhas->textos, 0,144);?>
                    </div>
                    <div class="col-sm-12">
                       <div class="eco_filter">
                                <ul class="eco_filter_title">
                                        <li>
                                          <a data-filter="todos" href="#" class="filter-item active trigger">
                                            todas
                                          </a>
                                        </li>

                                      <?php do{?>
                                        <li>  
                                          <a data-filter=".<?php echo $row_rs_cats['id'];?>" href="javascript;:" onClick="window.location='minhas-pecas-1.php?id_cat=<?php echo $row_rs_cats['id'];?>'" class="filter-item trigger">
                                            <?php echo $row_rs_cats['categoria'];?>
                                            </a>
                                        </li>
                                        <?php }while($row_rs_cats = mysql_fetch_assoc($rs_cats));
                                        ?>
                                </ul>
                        </div>
                    </div>   
            




                <div class="row row-centered" style="background-color: #fff; padding-top: 40px;" >

                  <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10 col-centered">
                    <div class="col-sm-12 lib-item" data-category="view">
                      <div class="row box-shadow" id="div_pecas">
                        <div class="row box-shadow" id="div_pecas">
                          <?php include('mais-pecas-1.php');?>
                        </div>
                      </div>
                      <!-- <a href="checkout/lista-de-desejos.php"></a> -->
                      <div class="text-center">
                          <input type="hidden" name="n_pagina_atual" id="n_pagina_atual" value="0">
                            <a href="javascript:;" onClick="bt_add();">
                              <button class="btn-default more_add">Carregar mais Produtos <i class="fa fa-plus-circle plus_edit"></i></button>
                            </a> 
              </div>
                      <!-- Lado esquerdo //--> 
                    </div>
                  </div>
                </div>



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
          <script src="dist/js/lightbox-plus-jquery.min.js"></script>
          <script src="load.js"></script>



<script>
    
$('.trigger').click(function (e) {

    e.preventDefault();

    var filtro = $(e.target).data('filter');
    console.log(filtro);

    switch (filtro) {

        case "Roupas":           
            $('.Roupas').show();
            $('.Bijux').hide();
            $('.Bolsas').hide();
            $('.Cintos').hide();
            $('.Lenços').hide();
            break;

        case "Bijux":           
            $('.Roupas').hide();
            $('.Bijux').show();
            $('.Bolsas').hide();
            $('.Cintos').hide();
            $('.Lenços').hide();
            break;

        case "Bolsas":      
            $('.Roupas').hide();
            $('.Bijux').hide();
            $('.Bolsas').show();
            $('.Cintos').hide();
            $('.Lenços').hide();           
            break;

        case "Cintos":        
            $('.Roupas').hide();
            $('.Bijux').hide();
            $('.Bolsas').hide();
            $('.Cintos').show();
            $('.Lenços').hide();           
            break;

        case "Lenços":        
            $('.Roupas').hide();
            $('.Bijux').hide();
            $('.Bolsas').hide();
            $('.Cintos').hide();
            $('.Lenços').show();           
            break;

          case "todos":
            $('.Roupas').show();
            $('.Bijux').show();
            $('.Bolsas').show();
            $('.Cintos').show();
            $('.Lenços').show();  
            break;

          case "todas":
            $('.').show();
            $('.').show();
            $('.').show();
            $('.').show();
            $('.').show();  
            break;





        default: 
            $('.Roupas').show();
            $('.Bijux').show();
            $('.Bolsas').show();
            $('.Cintos').show();
            $('.Lenços').show();          

    }

});


</script>




          <script>
              function bt_add() {
                var proxima_pagina = parseInt(document.getElementById('n_pagina_atual').value)+1;
                var url = 'mais-pecas.php?pagina='+proxima_pagina;
                //alert(url);
                AtualizaJanela(url, 'pagina'+document.getElementById('n_pagina_atual').value);
                document.getElementById('n_pagina_atual').value = proxima_pagina;
              }
            </script> 



</html>