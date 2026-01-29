<?php
include('class/textos.php');
$textos = Textos::getInstance(Conexao::getInstance());

include('class/planos.php');
$planos = Planos::getInstance(Conexao::getInstance());
$plano = $planos->rsDados(intval($_GET['plano']));

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
          
          <?php
	 if($_GET['plano'] == 2){
	 $corpo = "background-color: #ffffff;";
	 $numero = "background-color: #f3ca31;";
	 $numeracao = "1";
	 $descricao = "color: #000000;";
	 $valor = "color: #f3ca31;";
	 $botao = "background-color: #f3ca31; border: none; border-radius: none !important;";
	 $botaoPresente = "background-color: #12234b;";
	 }
	 if($_GET['plano'] == 3){
	 $corpo = "background-color: #2abaab;";
     $numero = "background-color: #d76e79; color: #FFFFFF;";
	 $numeracao = "2";
	 $descricao = "color: #000000;";
	 $valor = "color: #d76e79;";
	 $botao = "background-color:#d76e79;";
	 $botaoPresente = "background-color: #f3ca31; border: none; border-radius: none !important;";
	 }									
	 if($_GET['plano'] == 4){
	 $corpo = "background-color: #12234b;";
	 $numero = "background-color: #2abaab;";
	 $numeracao = "3";
	 $descricao = "color: #FFFFFF;";
	 $valor = "color: #2abaab;";
	 $botao = "background-color: #2abaab;";
	 $botaoPresente = "background-color:#d76e79;";
	 }
	 /*if($i == 4){
	 $corpo = "background-color: #fdc80b;";
	 $numero = "background-color: #12234b;color: #FFFFFF;";
	 $descricao = "color: #000000;";
	 $valor = "color: #000000;";
	 $botaoPresente = "background-color: #12234b;";
	 }*/
	?>
    </head>
    <body>
        
		<?php include('header.php');?>
	<br><br>	
<section>
   <div class="container">
       <div class="row row-centered">
                    
                    <form method="post" action="" id="formCadastro">
<!--                          <h1 class="text-left">selecione a duração da sua assinatura</h1>-->
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
<!--
                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                    <button class="add-to-cart btn btn-default mensal" onClick="document.getElementById('pontos').value='<?php echo $plano->pontuacao_mensal;?>'; document.getElementById('plano_tipo').value='M';document.getElementById('token_plano').value='<?php echo $plano->token_plano_mensal;?>';document.getElementById('textoPlanos').innerHTML='(Mensal - <?php echo $plano->pontuacao_mensal;?> pontos para usar no mês)';" type="button">&nbsp;&nbsp;Mensal <strong>(<?php echo $plano->pontuacao_mensal;?> pontos)&nbsp;&nbsp;</strong></button>
                </div>
-->
<!--
                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                    <button class="add-to-cart btn btn-default mensal" onClick="document.getElementById('pontos').value='<?php echo $plano->pontuacao_trimestral;?>';document.getElementById('plano_tipo').value='T';document.getElementById('token_plano').value='<?php echo $plano->token_plano_trimestral;?>';document.getElementById('textoPlanos').innerHTML='(Trimestral - <?php echo $plano->pontuacao_trimestral;?> pontos para usar no mês)';" type="button" >Trimestral <strong>(<?php echo $plano->pontuacao_trimestral;?> pontos)</strong></button>
                </div>
-->
<!--
                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                    <button class="add-to-cart btn btn-default mensal" onClick="document.getElementById('pontos').value='<?php echo $plano->pontuacao_semestral;?>';document.getElementById('plano_tipo').value='S';document.getElementById('token_plano').value='<?php echo $plano->token_plano_semestral;?>';document.getElementById('textoPlanos').innerHTML='(Semestral - <?php echo $plano->pontuacao_semestral;?> pontos para usar no mês)';" type="button" >Semestral <strong>(<?php echo $plano->pontuacao_semestral;?> pontos)</strong></button>
                </div>
-->
<!--
                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                    <button class="add-to-cart btn btn-default mensal" onClick="document.getElementById('pontos').value='<?php echo $plano->pontuacao_anual;?>'; document.getElementById('plano_tipo').value='A';document.getElementById('token_plano').value='<?php echo $plano->token_plano_anual;?>'; document.getElementById('textoPlanos').innerHTML='(Anual - <?php echo $plano->pontuacao_anual;?> pontos para usar no mês)';" type="button" >&nbsp;&nbsp;Anual <strong>(<?php echo $plano->pontuacao_anual;?> pontos)&nbsp;&nbsp;&nbsp;</strong></button>
                </div>
-->
                 
                  
                  <div class="clearfix">
                  &nbsp;
                  </div>
                <div class="clearfix">
                  &nbsp;
                  </div>
                <div class="clearfix">
                  <input type="hidden" name="token_plano" id="token_plano" value="<?php echo $plano->token_plano_mensal;?>">
                  <input type="hidden" name="plano_tipo" id="plano_tipo" value="M">
                  <input type="hidden" name="pontos" id="pontos" value="<?php echo $plano->pontuacao_mensal;?>">
<!--                  <h2 id="textoPlanos">(Mensal - <?php echo $plano->pontuacao_mensal;?> pontos para usar no mês)</h2>-->
                  </div>
                    
                    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7 col-centered ">
                           <div class="row">
                               
                               <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >
                                   <p style="text-align: justify; margin: 0 -17px 0;">Eba! Esse presente vai ser um sucesso. Vamos mandar um e-mail pra moça de sorte explicando tudinho sobre o nosso funcionamento. E psiu, ajuda a lembrá-la que ela tem até 15 dias pra confirmar o cadastro na loja física com a gente.</p>
                               </div>
                               
                               <div class="row">
                            <div class="col-sm-6 form-group">
                               
                                <label for="">Nome da presenteada</label>
                                <input type="text" class="form-control" name="nome" id="nome" required>
                            </div>
                            <div class="col-sm-6 form-group">
                                <label for="">E-mail da presenteada</label>
                                <input type="email" class="form-control" name="email" id="email" required>
                            </div>
                            </div>
                            <div class="row">
                            <div class="col-sm-6 form-group">
                                <label for="">Telefone da presenteada</label>
                                <input type="text" class="form-control" name="telefone" required>
                            </div>
                            <div class="col-sm-6 form-group">
                                <?php /*?><label for="">Crie uma senha para o Presenteado</label>
                                <input type="password" class="form-control" name="senha" required><?php */?>
                            </div>
                            </div>
                            <div class="row">
                           <div class="col-sm-6 form-group">
                                <label for="">Seu Nome</label>
                                <input type="text" class="form-control" name="nome_comprador" required>
                            </div>
                            <div class="col-sm-6 form-group">
                                <label for="">Seu E-mail</label>
                                <input type="email" class="form-control" name="email_comprador" required>
                            </div>
                            </div>
                        </div>
                         <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        
                    </div>
                   <?php /*?> <?php $planos1 = $conteudos->rsDados(34);?><?php */?>
                    <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-centered">
                               
                               
                               
                                <div class="thumbnail text-center" style="<?php echo $corpo;?>">
                                       <span class="numeral" style="<?php echo $numero;?>">
                                        <?php echo $numeracao;?>
                                        </span>
                                        <div class="caption" style="<?php echo $descricao;?>">
                                            <h3><?php echo utf8_decode($plano->nome);?></h3>
                                            <p style="text-align: justify"> 
                                               <?php echo $plano->descricao;?>
                                            </p>
                                            <h3>R$<?=number_format($plano->valor,2,',','.');?>/MÊS</h3>
                                            
                                            <input type="checkbox" name="termo" id="termo" required>Li e aceito os <a href="termos.php">termos de uso</a>
                                            
                                            <p>
                                               
                                                <button type="submit" class="btn btn-primary" style="<?php echo $botao;?>">Presentear!</button>
                                                
                                            </p>
                                        </div>
                                    </div>
                            </div>
                            
                        
                            
								<input type="hidden" name="acao" value="addClientes">
								<input type="hidden" name="condicao" value="presente">
								<input type="hidden" name="senha" value="minhanossa123">
								<input type="hidden" name="ativo" value="N">
								<input type="hidden" name="id_plano" value="<?php echo $_GET['plano'];?>">
                               </form>
                              
                </div>
       <div class="col-sm-6 text-left">
                       <h3 class="text-left">
                       <i class="fa fa-chevron-left" aria-hidden="true"></i>
                      <a href="index.php"> entender melhor como funciona </a></h3>
                        
                    </div>
       <div class="col-sm-6 text-right">
                       <?php /*?> <button class="add-to-cart btn btn-default mensal " type="button"><a href="termos.php">prosseguir para termos e condições</a></button><?php */?>
                       
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