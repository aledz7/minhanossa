<?php
include('class/blog.php');
$blog = Blogs::getInstance(Conexao::getInstance());
$item_blog = $blog->rsDados($_GET['id']);
?>

<!DOCTYPE html>
<html lang="pt_br">
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
           
            <div class="col-md-12 no-padding lib-item " data-category="view" >
                <div class="lib-panel" >
                    <div class="row box-shadow">
						<div class="lib-row lib-header">
							<h1 class="text-left" style="color: #c25868; text-shadow: #000 0px 1px 4px; margin-bottom: 20px;">BLOG</h1>
						</div>
						<div class="row">
							<div class="container" style="margin: 20px;">					
							<?php foreach($item_blog as $i_blog) : ?>
							<div class="parapending col-xs-12 col-sm-8 col-md-8 col-lg-8" style="margin-bottom: 20px;">
								<div>
									<a href="desc-blog.php?id=<?php echo $i_blog->id;?>">
									<h1 class="text-left txtcenter" style="font-size: 18px;"><span style="color: #f1c93b;"><?php echo utf8_decode($i_blog->titulo);?></span><br><span style="color: #c25868;"><?php echo utf8_decode($i_blog->breve);?></span></h1>
									<div class="lib-header-seperator"></div>
									</a>
								</div>
								<div class="paraimg col-xs-12 col-sm-4 col-md-4 col-lg-4" style="padding-left: 0px!important; padding-right: 0px!important;">
									<img src="img_noticias/<?php echo $i_blog->foto;?>" style="max-width: 200px;">
								</div>
								<div class="paratxt col-xs-12 col-sm-7 col-md-7 col-lg-7" style="margin-left: 20px;padding: 30px;">
									<p><?php echo utf8_decode($i_blog->resumo);?></p>
								</div>
							</div>
							<?php endforeach;?>
							<aside class="col-xs-12 col-sm-4 col-md-3 col-lg-3" style=""> 
								<h4>Veja outros</h4>
								<ul>
									<?php $outro1 = $blog->rsDados();
									foreach($outro1 as $item_outros):?>
									<li><a href="desc-blog.php?id=<?php echo $item_outros->id;?>" style="color: #c25868;"><?php echo utf8_decode($item_outros->titulo);?> <br>
									<?php echo utf8_decode($item_outros->breve);?></a></li>
									<?php endforeach;?>
								</ul>
							</aside>
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