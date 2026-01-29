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
          <link rel="stylesheet" href="dist/css/lightbox.css">
          <link rel="shortcut icon" href="images/fav.png" type="image/x-icon" />
          <style>
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
</style>
          </head>
          <body>
          <?php include('header.php');?>
          <section class="slide-wrapper">
            <div class="banner" style="padding: 48px 0 0">
              <div class="container">
                <div class="row row-centered" style="background-color: #fff; padding-top: 40px;" >
                  <div class="col-sm-6 text-left">
                    <h1 class="text-center">marcas minha nossa!</h1>
                  </div>
                  <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10 col-centered">
                    <div class="col-sm-12 lib-item" data-category="view">
                      <div class="row box-shadow" id="div_pecas">
                        <?php include('mais-pecas.php');?>
                      </div>
                      <div class="text-center">
                        <input type="dd" name="n_pagina_atual" id="n_pagina_atual" value="0">
                        <script>
                                function bt_add() {
									var proxima_pagina = parseInt(document.getElementById('n_pagina_atual').value)+1;
									var url = 'mais-pecas.php?pagina='+proxima_pagina;
									//alert(url);
									AtualizaJanela(url, 'pagina'+document.getElementById('n_pagina_atual').value);
									document.getElementById('n_pagina_atual').value = proxima_pagina;
									
								}
                                </script> 
                        <a href="javascript:;" onClick="bt_add();">
                        <button class="btn-default more_add">Carregar mais Produtos <i class="fa fa-plus-circle plus_edit"></i></button>
                        </a> </div>
                      <!-- Lado esquerdo //--> 
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
          <?php include('footer.php');?>
</body>
          <!-- Latest compiled and minified JS -->
          <script src="js/jquery-3.2.1.min.js"></script>
          <script src="js/bootstrap.min.js"></script>
          <script src="js/script.js"></script>
          <script src="dist/js/lightbox-plus-jquery.min.js"></script>
          <script src="load.js"></script>
</html>