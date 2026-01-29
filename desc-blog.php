<?php
include('class/blog.php');
$blog = Blogs::getInstance(Conexao::getInstance());
$desc_blog = $blog->rsDados($_GET['id']);
?>

<!DOCTYPE html>
<html lang="pt_BR">
    <head>
        <title>Minha Nossa! - Multimarcas de Empréstimos de Roupas em Brasília DF</title>
        <meta charset="utf-8">
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
        
        <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10 col-centered">
           
            <div class="col-md-12 no-padding lib-item pull-right" data-category="view" >
                <div class="lib-panel" >
                    <div class="row box-shadow">
<!--
                        <div class="borda-sobre">
                       	 &nbsp;
                        	 <div class="botao-termos">
                        	 	<a href="termos.php">termos & condições de uso</a>
                        	 </div>
                        </div>
-->
<!--
                        <div class="col-md-6"> 
                            
                        </div>
-->
                        <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
                            <div class="lib-row lib-header">
								<!--style="background-image: url(../../img_noticias/<?php echo $desc_blog->foto;?>); background-size: cover; background-repeat: no-repeat; background-position-x: -44px; background-position-y: -327px;"-->
                                <h1 class="text-left" style="color: white; text-shadow: #000 -3px 1px 4px;"><span style="color: #f1c93b; text-shadow: #000 -0px 1px 4px;"><?php echo utf8_decode($desc_blog->titulo);?></span><br><span style="color: #c25868;"><?php echo utf8_decode($desc_blog->breve);?></span></h1>
                                <!--<div class="lib-header-seperator"></div>-->
                            </div>
                            <div class="lib-row">
                                <?php echo utf8_decode($desc_blog->descricao);?>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3"> 
                            <h4>Veja outros</h4>
                            <ul>
                            <?php $outro1 = $blog->rsDados();
								foreach($outro1 as $item_outros):?>
                            	<li><a href="desc-blog.php?id=<?php echo $item_outros->id;?>" style="color: #c25868;"><?php echo utf8_decode($item_outros->titulo);?> <br>
                            	<?php echo utf8_decode($item_outros->breve);?></a></li>
                            	<?php endforeach;?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            
        </div>
</div>
            
            
        </div>
        
    </div>
    


            

            
            
       
    </section>
    <br>
    <br>
    <br>

         
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