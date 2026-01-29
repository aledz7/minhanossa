<?php 
include('class/marcas.php');
$marcas = Marcas::getInstance(Conexao::getInstance());
$pegamarcas = $marcas->rsDados('', 'titulo ASC');

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
</head>
<body>
<style>
         .centro {
          text-align: center !important;
         }
       </style>
<?php include('header.php');?>
<section class="slide-wrapper">
  <div class="banner" style="padding: 48px 0 0">
    <div class="container">
      <div class="row row-centered" style="background-color: #fff; padding-top: 40px;" >
        <div class="col-sm-12">
          <h1 class="text-center centro">MARCAS</h1>
        </div>
        <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10 col-centered">
          <div class="col-md-12 no-padding lib-item pull-right" data-category="view" >
            <div class="lib-panel" id="box" >
              <div class="row box-shadow A" id="filter">
                <?php foreach($pegamarcas as $marca) {  ?>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <h3><?php echo $marca->nome;?> <span style="font-size: 12px;"> <i class="fa fa-instagram"></i> <?php echo $marca->instagram;?> </span></h3>
                  <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                    <?php $imgMarca = "minhanossa/img_noticias/".cortaImagem($marca->foto, 'minhanossa/img_noticias', '225', '227', 'imgMarca', '#FFFFFF')?>
                    <?php if($marca->link <> ''){?>
                    <a href="<?php echo $marca->link;?>" target="_blank"> <img src="<?php echo $imgMarca;?>" class="img-responsive" alt="Image"> </a>
                    <?php }else{?>
                    <img src="<?php echo $imgMarca;?>" class="img-responsive" alt="Image">
                    <?php }?>
                  </div>
                  <?php $addFotos = $fotos->rsFotos($marca->id, 'Marcas');?>
                  <?php foreach($addFotos as $foto) {
                            // print_r($foto);?>
                  <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                    <?php $imgMarcas2 = "minhanossa/img_noticias/".cortaImagem($foto->foto, 'minhanossa/img_noticias', '225', '227', 'imgMarcas2', '#FFFFFF')?>
                    <a class="example-image-link" href="minhanossa/img_noticias/<?php echo $foto->foto;?>" data-lightbox="example-1"> <img src="<?php echo $imgMarcas2;?>" class="img-responsive" alt="Image"> </a> </div>
                  <?php } ?>
                </div>
                <?php }?>
              </div>
              <div class="clearfix"> &nbsp; </div>
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
</html>