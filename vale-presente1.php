<?php
include('class/textos.php');
$textos = Textos::getInstance(Conexao::getInstance());

include('class/conteudos.php');
$conteudos = Conteudos::getInstance(Conexao::getInstance());
$plano1 = $conteudos->rsDados('', $usuario->id_plano);

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
        <meta name="description" content="Minha Nossa para arrazar no look consumindo consciente">
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
		
<section>
   <div class="container">
       <div class="row row-centered">
                    
                    <form method="post" action="" id="formCadastro">
                    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7 col-centered ">
                           <div class="row">
                               
                               <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >
                                   
                                   <p style="text-align: justify">Como seu plano é para outra pessoa, precisamos dos dados dela. Pode incluir tudo o que você souber. A senha de acesso e o restante das informações ela pode preencher quando receber o presente.</p>
                                   
                                   
                               </div>
                               
                               
                            <div class="col-sm-6 form-group">
                               
                                <label for="">nome completo</label>
                                <input type="text" class="form-control" id="" name="nome">
                            </div>
                            
                            <div class="col-sm-6 form-group">
                                <label for="">CPF</label>
                                <input type="text" class="form-control" id="" name="cpf">
                            </div>
                            <div class="col-sm-6 form-group">
                                <label for="">endereço</label>
                                <input type="text" class="form-control" id="" name="endereco">
                            </div>
                            <div class="col-sm-6 form-group">
                                <label for="">e-mail</label>
                                <input type="text" class="form-control" id=""  name="email" >
                            </div>
                            <div class="col-sm-6 form-group">
                                <label for="">CEP</label>
                                <input type="text" class="form-control" id="" name="cep">
                            </div>
                            <div class="col-sm-6 form-group">
                                <label for="">telefone</label>
                                <input type="text" class="form-control" id="" name="telefone">
                            </div>
                        </div>
                        
                        
                    </div>
                   <?php /*?> <?php $planos1 = $conteudos->rsDados(34);?><?php */?>
                    <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-centered">
                                <div class="thumbnail text-center" style="background-color:#ffca05">
                                       <span class="numeral" style="background-color: #12234b; color: #fff;">
                                        3
                                        </span>
                                        <div class="caption">
                                            <h3><?php echo $planos1->titulo;?></h3>
                                            <p style="text-align: justify"> 
                                               <?php echo $planos1->noticia;?>
                                            </p>
                                            <h3>R$<?=number_format($planos1->por,2,',','.');?>/MÊS</h3>
                                            <p>
                                                <a href="javascript:formCadastro.submit()" class="btn btn-primary" style="background-color:#12234b;border-radius: 0;
    border: none;
    padding: 5px 40px 5px; ">Presentei!</a>
                                                
                                            </p>
                                            <input type="checkbox" name="termo" id="termo" required value="">Li e aceito os <a href="termos.php">termos de uso</a>
                                        </div>
                                    </div>
                            </div>
								<input type="hidden" name="acao" value="addClientes">
								<input type="hidden" name="ativo" value="S">
                               </form>
                                <h1 class="text-left">selecione o prazo de assinatura do presente</h1>
                <div class="clearfix">
                  &nbsp;
                  </div>
					<style>
						.mensal{
						  padding: 7px 38px 7px;
                          font-size: 20px;
						  border-radius: 0;	
						}
					</style>
                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-32">
                    <button class="add-to-cart btn btn-default mensal" type="hidden">1 mês</button>
                </div>
<!--
                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                    <button class="add-to-cart btn btn-default mensal" type="hidden">3 meses</button>
                </div>
-->
<!--
                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                    <button class="add-to-cart btn btn-default mensal" type="hidden">6 meses</button>
                </div>
-->
<!--
                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                    <button class="add-to-cart btn btn-default mensal" type="hidden">12 meses</button>
                </div>
-->
                 
                  
                  <div class="clearfix">
                  &nbsp;
                  </div>
                <div class="clearfix">
                  &nbsp;
                  </div>
                <div class="clearfix">
                  &nbsp;
                  </div>
                </div>
       <div class="col-sm-6 text-left">
                       <h3 class="text-left">
                       <i class="fa fa-chevron-left" aria-hidden="true"></i>
                      <a href="index.php"> entender melhor como funciona </a></h3>
                        
                    </div>
       <div class="col-sm-6 text-right">
                        <button class="add-to-cart btn btn-default mensal " type="button"><a href="termos.php">prosseguir para termos e condições</a></button>
                       
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