<?php
include('class/textos.php');
$textos = Textos::getInstance(Conexao::getInstance());

include('class/conteudos.php');
$conteudos = Conteudos::getInstance(Conexao::getInstance());

include('class/clientes.php');
$clientes = Clientes::getInstance(Conexao::getInstance());
$clientes->add('index.php');

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
        		<div class="col-xs-12 col-sm-10 col-md-10 col-lg-10 col-centered">
                   <div class="col-md-12 no-padding lib-item pull-right" data-category="view" >
                	   <div class="lib-panel" >
                    <div class="row box-shadow">
                       <form method="post" action="" id="formCadastro">
                        
                        <h1>criar sua conta</h1>

                         <div class="row">
                           <div class="clearfix">&nbsp;</div>
                           <div class="clearfix">&nbsp;</div>
                           <div class="clearfix">&nbsp;</div>
                            <div class="col-sm-4 form-group">
                                <label for="">nome completo</label>
                                <input type="text" class="form-control" name="nome" id="nome">
                            </div>
                            <div class="col-sm-4 form-group">
                                <label for="">crie uma senha</label>
                                <input type="password" class="form-control" name="senha" id="senha">
                            </div>
                            <div class="col-sm-4 form-group">
                                <label for="">confime sua senha</label>
                                <input type="password" class="form-control" name="senha" id="senha">
                            </div>
                            <div class="col-sm-4 form-group">
                                <label for="">CPF</label>
                                <input type="text" class="form-control" name="cpf" id="cpf">
                            </div>
                            <div class="col-sm-8 form-group">
                                <label for="">endereço</label>
                                <input type="text" class="form-control" name="endereco" id="endereco" >
                            </div>
                            <div class="col-sm-4 form-group">
                                <label for="">e-mail</label>
                                <input type="text" class="form-control" name="email" id="email" >
                            </div>
                            <div class="col-sm-4 form-group">
                                <label for="">CEP</label>
                                <input type="text" class="form-control" name="cep" id="cep">
                            </div>
                            <div class="col-sm-4 form-group">
                                <label for="">telefone</label>
                                <input type="text" class="form-control" name="telefone" id="telefone">
                            </div>
                        </div>
						
                    </div>
                </div>
                   </div>
                   <div>
                       <div class="row row-centered">
               				<h1 class="text-left">selecione seu plano</h1>
               				
               				 <?php $planos = $conteudos->rsDados(34);
									$i = 0;
									foreach($planos as $plano) { 
									$i++; ?>
               				 <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-centered">
                                
                                
                                   <div class="thumbnail text-center" style=" <?php if($i == 1){echo "background-color: #ffffff;";}if($i == 2){echo "background-color:#2abaab;";}if($i == 3){echo "background-color:#12234b;";}if($i == 4){echo "background-color:#fdc80b;";}?>">
                                        <span class="numeral" style="<?php if($i == 1){echo "background-color: #f3ca31;";}if($i == 2){echo "background-color: #d76e79; color: #fff";}if($i == 3){echo "background-color: #2abaab;";}if($i == 4){echo "background-color: #12234b;color: #fff;";}?>">
                                        <?php echo $i;?>
                                        </span>
                                        <div class="caption" style="<?php if($i == 1){echo "color: #000;";}if($i == 2){echo "color: #000;";}if($i == 3){echo "color: #fff;";}if($i == 4){echo "color: #000;";}?>">
                                            <h4><?php echo $plano->titulo;?></h4>
                                            <p style="text-align: justify"> 
                                               <?php echo $plano->noticia;?>
                                            </p>
                                            <h3 style="<?php if($i == 1){echo "color: #f3ca31;";}if($i == 2){echo "color:#d76e79;";}if($i == 3){echo "color:#2abaab;";}if($i == 4){echo "color:#000000;";}?>"><strong>R$<?=number_format($plano->por,2,',','.');?>/MÊS</strong></h3>
                                            <p>
                                                <a href="<?php if($i == 1){echo "javascript:;";}if($i == 2){echo "javascript:;";}if($i == 3){echo "javascript:;";}if($i == 4){echo "vale-presente.php";}?>" onClick="document.getElementById('id_plano').value=<?php echo $plano->id;?>;javascript:formCadastro.submit()" class="btn btn-primary" style="<?php if($i == 1){echo "background-color: #f3ca31; border: none; border-radius: none !important;";}if($i == 2){echo "background-color:#d76e79;";}if($i == 3){echo "background-color: #2abaab;";}if($i == 4){echo "background-color: #12234b;";}?>">assinar!</a>
                                                
                                            </p>
                                            <input type="checkbox" name="termo" id="termo" required value="">Li e aceito os <a href="termos.php">termos de uso</a>
                                        </div>
                                    </div>
                            	</div>
                            	 <?php }?>
                            	
                            	<input type="hidden" name="id_plano" id="id_plano">
                            	<input type="hidden" name="acao" value="addClientes">
								<input type="hidden" name="ativo" value="S">
								<input type="hidden" name="tipo" value="clientes">
                       		 </form>
                           
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
    

         
		<?php include('footer1.php')?>
    

    </body>
    <!-- Latest compiled and minified JS -->
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/script.js"></script>
    <script>
	
	$(document).ready(function() {
  var contentLastMarginLeft = 0;
  $(".wrap").click(function() {
    var box = $(".content");
    var newValue = contentLastMarginLeft;
    contentLastMarginLeft = box.css("margin-left");
    box.animate({
      "margin-left": newValue
    }, 500);
  });
});
	</script>
</html>