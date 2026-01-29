<?php
include('class/produtos.php');
$produtos = Produtos::getInstance(Conexao::getInstance());

include('class/conteudos.php');
$conteudos = Conteudos::getInstance(Conexao::getInstance());

include('class/clientes.php');
$clientes = Clientes::getInstance(Conexao::getInstance());
$clientes->login($_POST['login'], $_POST['senha'], 'perfil-usuario.php');

include('verifica-retorno-produto.php');

include('class/html.php');
$html = new HTML;

if($_SERVER['HTTPS'] != 'on' and $_SERVER['HTTP_HOST'] <> '127.0.0.1'){
	echo "	<script>
			window.location='https://$_SERVER[HTTP_HOST]?$_SERVER[QUERY_STRING]';
			</script>"; 
}
?>
<!DOCTYPE html>
<html lang="pt_BR">
    <head>
        
        <?php
		$html->seo_metas_tag('Aluguel de Roupas em Brasília DF', 'Transformando seu guarda-roupa feminino em um universo de possibilidades. Alugue roupas sofisticas com ótimos preços em Brasília DF. Encontre aqui as melhores marcas.');
		?>
        
        <meta charset="UTF-8">
       
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
        <!-- Ultima versão compactada BOOTSTRAP.CSS -->
        <link rel="stylesheet" href="css/bootstrap.min.css">
         <link rel="stylesheet" href="css/font-awesome.min.css">
          <link rel="stylesheet" href="css/animate.css">
          <link href="css/style.css" rel="stylesheet">
    </head>
    <body>
       
        <?php include('header.php');?>
        
<section class="slide-wrapper">
        <div class="banner">

<div class="container">
    
    <div class="row row-centered">
        
        <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 col-centered">
            <img src="images/transparente.png" class="img-responsive" alt="Image" width="33%">
            <div class="quadrado hidden-xs">
                
            </div>
            <div class="look hidden-xs">
               <span>transformando </span>
                <div>o guarda-roupa feminino em um </div> 
                <div class="consciente"><h5>universo de possibilidades</h5></div>
               <small class="header-span"><a href="index.php" ><strong>entenda como funciona</strong></a> 
               <i class="fa fa-angle-right"></i>
               </small>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 pull-right margin">
                <div class="thumbnail">
                    
                    <div class="caption text-center" style="color: #f05b66">
                        <h4>Já tem sua conta?</h4>
                        
                        <form method="post" class="login" name="formLogin" id="formLogin" class="form-inline" role="form">
                        
                            <div class="form-group text-center">
                                <label for="" style="color: #c6d5ed;font-weight: 100;">Username</label>
                                <input type="text" style="text-align: center; border: none" class="form-control" id="" name="login">
                            </div>
                            <hr>
                            <div class="form-group text-center">
                                <label for="" style="color: #c6d5ed;font-weight: 100;">Password</label>
                                <input type="password" style="text-align: center; border: none" class="form-control" id="" name="senha">
                            </div>
                            <hr>
                            
                            
                            
                            <span class="input-group-btn btn-lg text-center">
                                <button type="submit" style="    border-color: #d76e79; color: #d76e79; border-radius: 0;
    padding: 15px 45px 15px;" class="btn btn-default" onClick="document.getElementById('formLogin').submit()">Entrar</button>
                                
                            </span>
                            
                            </form>
                           <span class="text-center" style="color: #c6d5ed;font-weight: 100; font-size: 11px;"><a href="esqueci-minha-senha.php">ESQUECI MINHA SENHA</a></span>
                            
                            
                           <?php /*?> <span class="input-group-btn btn-lg text-center">
                                <a href="formulario.php" class="btn btn-default" style="background-color: #d76e79;
    color: #fff;
    border: none;
    padding: 20px 51px 17px;
    margin-left: -10px;
    border-radius: 0;">Criar minha conta!</a>
                                
                            </span><?php */?>
                        
                        
                            
                        
                    </div>
                </div>
            </div>
            
        </div>
        
    </div>
    
</div>

            

            
            
        </div>
    </section>
    
    <div class="clearfix">
    &nbsp;
    </div>
    
    <div class="clearfix">
    &nbsp;
    </div>
    
    <div class="clearfix">
    &nbsp;
    </div>
    
    <section>
            
            <div class="container">
                
                <div class="row row-centered">
                    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 col-centered">
                        
                        
                            
                            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                <div class="thumbnail">
                                    <img src="images/minha-nossa.png" alt="">
                                    <div class="caption text-center">
                                        <h4>mas como funciona?</h4>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                <div class="thumbnail">
                                    <img src="images/icone-camisa.png" alt="">
                                    <div class="caption text-center">
                                        <h4>escolha uma peça limpinha</h4>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                <div class="thumbnail">
                                    <img src="images/icone-girl.png" alt="">
                                    <div class="caption text-center">
                                        <h4>arrase no look</h4>
                                        <div class="clearfix">&nbsp;</div>
                                    </div>
                                </div>
                                <i class="fa fa-angle-double-right seta-span hidden-xs"></i>
                                <i class="fa fa-angle-double-down seta-span-down hidden-sm hidden-md hidden-lg"></i>
                            </div>
                            
                                                                                 
                            
                            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                <div class="thumbnail">
                                    <img src="images/icone-maquina.png" alt="">
                                    <div class="caption text-center">
                                        <h4>devolva sem precisar lavar</h4>
                                        
                                    </div>
                                </div>
                                <i class="fa fa-angle-double-right seta-span hidden-xs"></i>
                                <i class="fa fa-angle-double-down seta-span-down hidden-sm hidden-md hidden-lg"></i>
                            </div>
                        
                        
                    </div>
                </div>
                
            </div>
            
        </section>
    
    
    
    <div class="clearfix">
    &nbsp;
    </div>
    
    <div class="clearfix">
    &nbsp;
    </div>
    
    <div class="clearfix">
    &nbsp;
    </div>
    
  <?php /*?>  <section class="produtos-background">
            
            <div class="container">
                
                <div class="row row-centered">
                    <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 col-centered">
                        <h3 style="color: #fff">NOVIDADES</h3>
                        
                            
                            <?php $novidades = $produtos->rsDados();
									foreach($novidades as $novidade) { 
								$categoria = $conteudos->rsDados('', $novidade->id_categoria);
						?>
                           <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                <div class="thumbnail hvr-bounce-to-right">
                                    <a href="detalhes.php?id=<?php echo $novidade->id;?>"><img src="img_noticias/<?php echo $novidade->foto;?>" alt=""></a>
                                    <div class="caption <?php if($novidade->id_categoria == 1){ echo "deg-produto-verde";}if($novidade->id_categoria == 6){ echo "deg-produto-rosa";}if($novidade->id_categoria == 27){ echo "deg-produto-azul";}?>  text-left caption-color" style="padding: 53px 10px 0px; height: 151px;">
                                        <small><?php echo $categoria->titulo;?></small>
                                        <h4><?php echo $novidade->nome;?></h4>
                                        <div class="clearfix">&nbsp;</div>
                                        <div class="estrela">
                                            <i class="fa fa-star"></i>
                                        </div>
                                        
                                        
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
<!--
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                <div class="thumbnail">
                                    <a href="DOCUMENTACAO/detalhes.html"><img src="images/produto2.png" alt=""></a>
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
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                <div class="thumbnail">
                                    <a href="DOCUMENTACAO/detalhes.html"><img src="images/produto3.png" alt=""></a>
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
                        </div>
                    </div>
                </div>
        </section><?php */?>
         
       <?php /*?>  <div class="clearfix">&nbsp;</div>
         <div class="clearfix">&nbsp;</div>
         <div class="clearfix">&nbsp;</div>
         <div class="clearfix">&nbsp;</div><?php */?>
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