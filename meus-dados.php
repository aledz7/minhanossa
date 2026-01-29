<?php
include('class/clientes.php');
$clientes = Clientes::getInstance(Conexao::getInstance());
$clientes->restrito();
$clientes->logout();
$clientes->editar('Atualização efetuada com sucesso!', 'perfil-usuario.php');
$usuario = $clientes->rsDados($_SESSION['dadosLogadoCLiente']->id);

include('class/planos.php');
$planos = Planos::getInstance(Conexao::getInstance());
$plano = $planos->rsDados($usuario->id_plano);

include('class/itens.php');
$itens = Itens::getInstance(Conexao::getInstance());

include('class/produtos.php');
$produtos = Produtos::getInstance(Conexao::getInstance());

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
          <link rel="shortcut icon" href="images/fav.png" type="image/x-icon" />
    </head>
    <body>
        
		<?php include('header.php'); ?>
		
<section class="slide-wrapper">
        <div class="banner" style="padding: 48px 0 0">

            <div class="container">
    
                <div class="row row-centered" style="background-color: #fff; padding-top: 40px;">
                    <div class="col-sm-6 text-left">
                       <h1 class="text-left">Olá <?php echo $_SESSION['dadosLogadoCLiente']->nome;?></h1>
                       
                    </div>
                    <div class="col-sm-6 text-right">
                        <div>
                           <h3 style="background-color: #ffca05;padding: 0px 8px 0px;float: left;"><i class="fa fa-lightbulb-o" aria-hidden="true" style="background-color: white;padding: 2px 8px 3px;float: left;border: 1px solid #ffca05; border-radius: 20px;margin-left: -26px;"></i>Você tem <span><?php echo $usuario->pontos;?> pontos</span> para usar. Arrase!</h3>
                        </div>
                    </div>   
                
                
                <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
                  <div role="tabpanel">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <?php /*?><li role="presentation" class="active">
                                <a href="#minha-whishlist" aria-controls="home" role="tab" data-toggle="tab">MINHA WISHLIST</a>
                            </li>
                            <li role="presentation">
                                <a href="#reservadas" aria-controls="tab" role="tab" data-toggle="tab">RESERVADAS</a>
                            </li><?php */?>
                            <li role="presentation">
                                <a href="perfil-usuario.php">JÁ USEI</a>
                            </li>
                            <li role="presentation">
                                <a>MEUS DADOS</a>
                            </li>
                            <li role="presentation">
                                <a href="meus-dados.php?acao=sair" style="color: #BF0003; font-weight: 800">SAIR</a>
                            </li>

                        </ul>
                    
                        <!-- Tab panes -->
                        <div class="tab-content">
                      
                            
                           
                            <div role="tabpanel" class="tab-pane active" id="meus-dados">
                            <div class="clearfix">&nbsp;</div>
                            <div class="clearfix">&nbsp;</div>
                            <form action="" method="post" name="formAtualizar" id="formAtualizar">
                            	<div class="row">
                            		<div class="col-sm-8 form-group">
										<label for="">e-mail</label>
										<input type="text" class="form-control" id="" value="<?php echo $usuario->email;?>" readonly>
									</div>
                            	</div>
							   <div class="row">
									<div class="col-sm-4 form-group">
										<label for="">nome completo</label>
										<input type="text" name="nome" class="form-control" id="" value="<?php echo $usuario->nome;?>">
									</div>
									
									<div class="col-sm-4 form-group">
										<label for="">CPF</label>
										<input type="text" name="cpf" class="form-control" id="" value="<?php echo $usuario->cpf;?>">
									</div>
									<div class="col-sm-4 form-group">
									    <label for="">telefone</label>
									    <input type="text" name="telefone1" class="form-control" id="" value="<?php echo $usuario->telefone1;?>">
								    </div>
									<div class="col-sm-8 form-group">
										<label for="">endereço</label>
										<input type="text" name="endereco" class="form-control" id="" value="<?php echo $usuario->endereco;?>">
									</div>
                            
									<div class="col-sm-4 form-group">
										<label for="">CEP</label>
										<input type="text" class="form-control" name="cep" value="<?php echo $usuario->cep;?>">
									</div>
									
                                
                                 </div>
                                 <div class="row">
                                 	<div class="col-sm-6 form-group">
									    <label for="">Senha</label>
									    <input type="password" name="senha" class="form-control" id="" value="<?php echo $usuario->senha;?>">
								    </div>
                                 </div>
                                 <input type="hidden" name="email" value="<?php echo $usuario->email;?>">
                                 <input type="hidden" name="id_plano" value="<?php echo $usuario->id_plano;?>">
                                 <input type="hidden" name="plano_tipo" value="<?php echo $usuario->plano_tipo;?>">
                                 <input type="hidden" name="pontos" value="<?php echo $usuario->pontos;?>">
                                 <input type="hidden" name="id" value="<?php echo $_SESSION['dadosLogadoCLiente']->id;?>">
                                 <input type="hidden" name="acao" value="editarClientes">
                                 <button type="submit" style="    border-color: #d76e79; color: #d76e79; border-radius: 0;
    padding: 15px 45px 15px;" class="btn btn-default" onClick="document.getElementById('formAtualizar').submit()">atualizar</button>
                           </form>
                            </div>
                        </div>
                    </div>  
                </div>
                
                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                    <div class="thumbnail text-center" style="background-color:#ffffff">
                       
                        <div class="caption">
                            <h3>MEU PLANO</h3>
<!--                             <span class="numeral" style="background-color: #d76e79; color: #FFFFFF;"> 2 </span>-->
                             <h4><?php echo utf8_decode($plano->nome);?></h4>
                            <p style="text-align: justify; font-size: 18px"> 
                                <?php echo utf8_decode($plano->descricao);?>
                            </p>
                            <h3 style="color:#d76e79;font-weight: bold;">R$<?=number_format($plano->valor,2,',','.');?>/MÊS</h3>
                            <p>
                                <?php /*?><a href="termos.php" class="add-to-cart btn btn-default" style="padding: 5px 11px 5px; border-radius: 0; background-color: #31bbac;">termos & condições</a>
                                <a href="#" class="add-to-cart btn btn-default" style="border: 1px solid #d76e79; background-color: #fff; color:#d76e79;padding: 6px 35px 6px;margin-top: 20px; border-radius: 0">trocar plano</a><?php */?>
                                
                            </p>
                        </div>
                    </div>
                </div>
                
                
                    
                    
                      
               </div>
        
        </div>
        
    </div>
    

</section>
       
        <!-- <ul >
            <li>One</li>
            <li>Two</li>
            <li>Three</li>
            <li>Four</li>
            <li>Five</li>
            <li>Six</li>
            <li>Seven</li>
            <li>Eight</li>
            <li>Nine</li>
            <li>Ten</li>
            <li>Eleven</li>
            <li>Twelve</li>
            <li>Thirteen</li>
            <li>Fourteen</li>
            <li>Fifteen</li>
            <li>Sixteen</li>
            <li>Seventeen</li>
            <li>Eighteen</li>
            <li>Nineteen</li>
            <li>Twenty one</li>
            <li>Twenty two</li>
            <li>Twenty three</li>
            <li>Twenty four</li>
            <li>Twenty five</li>
        </ul>
        <div id="loadMore">Load more</div>
        <div id="showLess">Show less</div> -->


         
 <div class="clearfix">
    &nbsp;
    </div>
    
    <div class="clearfix">
    &nbsp;
    </div>
    
    <div class="clearfix">
    &nbsp;
    </div>
    

         
		<?php include('footer1.php');?>


    </body>
    <!-- Latest compiled and minified JS -->
    
    <!-- Latest compiled and minified JS -->
<!--
    <script src="//code.jquery.com/jquery.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
-->
    
     <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script> 
    <script src="js/script.js"></script>
</html>
