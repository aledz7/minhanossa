<?php
include('class/clientes.php');
$clientes = Clientes::getInstance(Conexao::getInstance());
$clientes->restrito();
$clientes->logout();
$clientes->editar("Alterações realizadas com sucesso!", "lista-de-desejos.php");
$usuario = $clientes->rsDados($_SESSION['dadosLogadoCLiente']->id);

include('class/planos.php');
$planos = Planos::getInstance(Conexao::getInstance());
$plano = $planos->rsDados('', 'S');
$plano_usuario = $planos->rsDados($usuario->id_plano);

include('class/estados.php');
$estados = Estados::getInstance(Conexao::getInstance());

include('class/itens.php');
$itens = Itens::getInstance(Conexao::getInstance());

include('class/produtos.php');
$produtos = Produtos::getInstance(Conexao::getInstance());
$produtos->excluir_item_desejo();

include('funcoes/cortar-imagem.php');

?>

<!DOCTYPE html>
<html lang="pt_BR">
    <head>
        <title>Multimarcas de Empréstimos de Roupas em Brasília DF</title>
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
    
                <div class="row row-centered" style="background-color: #fff; padding-top: 40px;">
                    <div class="col-sm-6 text-left">
                       <h1 class="text-left">Olá <?php echo strstr($_SESSION['dadosLogadoCLiente']->nome, ' ', true); ?>!</h1>
                       
                    </div>
                                       
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <div role="tabpanel">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation">
                                <a href="#minha-whishlist" aria-controls="tab" role="tab" data-toggle="tab">LISTA DE DESEJOS</a>
                            </li>
                           <?php /*?> <li role="presentation">
                                <a href="#reservadas" aria-controls="tab" role="tab" data-toggle="tab">RESERVADAS</a>
                            </li><?php */?>
                            <?php /*?><li role="presentation">
                                <a href="#ja-usei" aria-controls="tab" role="tab" data-toggle="tab">JÁ USEI</a>
                            </li><?php */?>
                            <li role="presentation">
                                <a href="#meus-dados" aria-controls="tab" role="tab" data-toggle="tab">MEUS DADOS</a>
                            </li>
                            <li role="presentation">
                                <a href="perfil-usuario.php?acao=sair" style="color: #BF0003; font-weight: 800">SAIR</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-xs-12 col-md-offset-1 col-sm-9 col-md-9 col-lg-9">
                  <div role="tabpanel">
                        <!-- Tab panes -->
                        <div class="tab-content">
                           <div role="tabpanel" class="tab-pane active" id="minha-whishlist">
                                 <div class="clearfix">&nbsp;</div>
                                 <div class="clearfix">&nbsp;</div>
                                <?php 
                                    $produtos->add_filtro('lista_desejos');
                                    $preferidos = $produtos->rsDados('', $_GET['ordem'], '', $_GET['id-cat']);
                                    //print_r($preferidos);
                                    foreach($preferidos as $itemPreferidos) { 
                                    //$categoria = $conteudos->rsDados('', $novidade->id_categoria);
                                ?>
                                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 mb-30">
                                        <div class="thumbnail mb-10">
                                            <img src="sistema/img_noticias/<?php echo $itemPreferidos->foto;?>" alt="">
                                        </div>
                                        <div>
                                            <a href="lista-de-desejos.php?id_produto=<?php echo $itemPreferidos->id; ?>&id_cliente=<?php echo $usuario->id;?>&acao=excluirItemDesejo">
                                                <i class="fa fa-trash" aria-hidden="true"></i> Excluir item
                                            </a>
                                        </div>
                                    </div>
                                <?php }?>
                            </div>
                           <?php /*?> <div role="tabpanel" class="tab-pane" id="reservadas">
                                <div class="clearfix">&nbsp;</div>
                                 <div class="clearfix">&nbsp;</div>
                                <?php $reserva = $produtos->rsDados();
								foreach($reserva as $reservadas) { 
								$categoria = $conteudos->rsDados('', $novidade->id_categoria);
								?>
                                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                        <div class="thumbnail">
                                            <img src="img_noticias/<?php echo $reservadas->foto;?>" alt="">
                                            <div class="caption deg-produto-rosa text-left caption-color" style="padding: 53px 10px 0px;">
                                                <small><?php echo $categoria->titulo;?></small>
                                                <h4><?php echo $reservadas->nome;?></h4>
                                                <div class="clearfix">&nbsp;</div>
                                                <div class="estrela">
                                                    <i class="fa fa-star"></i>
                                                </div>
                                                
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <?php }?>
                            </div><?php */?>
                            
                            <?php /*?><div role="tabpanel" class="tab-pane active" id="ja-usei">
                                <div class="clearfix">&nbsp;</div>
                                 <div class="clearfix">&nbsp;</div>
                                <?php $jausei = $itens->rsDados('', $_SESSION['dadosLogadoCLiente']->id);
								if(count($jausei) > 0){
								foreach($jausei as $usadas) { 
									$nomeProduto = $produtos->rsDados($usadas->nome_produto);
								?>
                                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" style="height: 405px;">
                                        <div class="thumbnail">
                                           <?php if($nomeProduto->foto <> ''){
											$img = "sistema/sistema/imgs-sis/".cortaImagem($nomeProduto->foto, 'sistema/sistema/imgs-sis', '242', '352', 'img_jausei', '#FFFFFF');
											?>
                                            <img src="sistema/sistema/imgs-sis/<?php echo $nomeProduto->foto;?>" alt="" style="min-height: 352px; max-height: 352px; min-width: 242px; max-width: 242px; ">
                                           <?php }else{?>
                                           	<img src="images/sem-foto.jpg" alt="">
                                           <?php }?>
                                            <div class="caption deg-produto-azul text-left caption-color" style="padding: 53px 10px 0px; height: 112px;">
                                                <small><?php echo utf8_decode($nomeProduto->nomeCategoria);?></small>
                                                <h5><?php echo utf8_decode($nomeProduto->nome);?></h5>
                                                <div class="clearfix"><?php echo $nomeProduto->pontuacao;?> pontos</div>
                                                <div class="estrela">
                                                    <i class="fa fa-star"></i>
                                                </div>
                                                
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <?php }?>
                                    <?php }?>     	
                                </div><?php */?>  
							
                            <div role="tabpanel" class="tab-pane" id="meus-dados">
                                <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
                                    <div class="clearfix">&nbsp;</div>
                                    <div class="clearfix">&nbsp;</div>
                                    <form method="post" action="">
                                            <div class="col-sm-6">
                                                <div class="form-group text-center">
                                                    <label for="" style="color: #3a3d42;font-weight: 100;">Nome</label>
                                                    <input type="text" style="text-align: center; border: none" class="form-control" id="nome" name="nome" value="<?php echo $usuario->nome;?>">
                                                </div>
                                                <hr class="traco">
                                                <div class="form-group text-center">
                                                    <label for="" style="color: #3a3d42;font-weight: 100;">Data de Nascimento</label>
                                                    <!--<input type="password" style="text-align: center; border: none" class="form-control" id="" name="senha">-->
                                                    <input class="form-control" name="aniversario" type="date" style="text-align: center; border: none" required="" value="<?php echo $usuario->aniversario;?>">
                                                </div>
                                                <hr class="traco">
                                            </div>											
                                            <div class="col-sm-6">
                                                <div class="form-group text-center">
                                                    <label for="" style="color: #3a3d42;font-weight: 100;">CPF</label>
                                                    <input type="text" style="text-align: center; border: none" class="form-control" id="" name="cpf" value="<?php echo $usuario->cpf;?>">
                                                </div>    
                                                <hr class="traco">
                                                <div class="form-group text-center">
                                                    <label for="" style="color: #3a3d42;font-weight: 100;">Celular</label>
                                                    <input type="text" style="text-align: center; border: none" class="form-control" id="" name="telefone1" value="<?php echo $usuario->telefone1;?>">
                                                </div>
                                                <hr class="traco">
                                            </div>	
                                            <div class="col-sm-6">
                                                <div class="form-group text-center">
                                                    <label style="color: #3a3d42;font-weight: 100;">Endereço</label>
                                                    <input type="text" style="text-align: center; border: none" class="form-control"  name="endereco" value="<?php echo $usuario->endereco;?>">
                                                </div>											
                                                <hr class="traco">
                                            </div>	
                                            <div class="col-sm-6">
                                                <div class="form-group text-center">
                                                    <label for="" style="color: #3a3d42;font-weight: 100;">CEP</label>
                                                    <input type="text" style="text-align: center; border: none" class="form-control" name="cep" value="<?php echo $usuario->cep;?>">
                                                </div>
                                                <hr class="traco">
                                            </div>		
                                            <div class="col-sm-6">
                                                <div class="form-group text-center">
                                                    <label for="" style="color: #3a3d42;font-weight: 100;">Bairro</label>
                                                    <input type="text" style="text-align: center; border: none" class="form-control" name="bairro" value="<?php echo $usuario->bairro;?>">
                                                </div>
                                                <hr class="traco">
                                                <div class="form-group text-center">
                                                    <label for="" style="color: #3a3d42;font-weight: 100;">Cidade</label>
                                                    <div id="janela_Cidades">
                                                        <?php 
                                                            if($usuario->estado == '' or $usuario->cidade == '') { ?>
                                                            <select name="" id="" class="form-control" style="text-align: center; border: none;">
                                                                <option value="">Primeiro - Selecione um Estado</option>
                                                            </select>
                                                            <?php 
                                                            } else { 
                                                                $_GET['id_estado'] = $usuario->estado;
                                                                $_GET['id_cidade'] = $usuario->cidade;
                                                                include('cidades.php');
                                                            }
                                                        ?>
                                                    </div>
                                                </div>
                                                <hr class="traco">
                                            </div>	
                                            <div class="col-sm-6">
                                                <div class="form-group text-center">
                                                    <label for="" style="color: #3a3d42;font-weight: 100;">Estado</label>
                                                    <?php echo $estados->selectEstados('id_estado', 'text-align: center; border: none;', $usuario->estado, 'nome', 'S');?>
                                                </div>
                                                <hr class="traco">

                                                <div class="form-group text-center">
                                                    <label for="" style="color: #3a3d42;font-weight: 100;">Complemento</label>
                                                    <input type="text" style="text-align: center; border: none" class="form-control" name="complemento" value="<?php echo $usuario->complemento;?>">
                                                </div>
                                                <hr class="traco">
                                            </div>	
                                            <div class="col-sm-6">
                                                <div class="form-group text-center">
                                                    <label style="color: #3a3d42;font-weight: 100;">E-mail</label>
                                                    <input type="email" style="text-align: center; border: none" class="form-control" name="email" value="<?php echo $usuario->email;?>" readonly>
                                                </div>
                                                <hr class="traco">
                                                <div class="form-group text-center" id="planos_a">
                                                    <label for="" style="color: #3a3d42;font-weight: 100;">Plano</label>
                                                    <select name="id_plano" class="form-control" style="text-align: center; border: none">
                                                        <option value=""></option>
                                                        <?php foreach($plano as $item_plano){?>
                                                            <option value="<?php echo $item_plano->id; ?>" <?php if($item_plano->id == $usuario->id_plano){ echo "selected";} ?>><?php echo $item_plano->nome; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group text-center">
                                                    <label for="" style="color: #3a3d42;font-weight: 100;">Senha</label>
                                                    <input type="password" style="text-align: center; border: none" class="form-control" name="senha" value="<?php echo $usuario->senha;?>"> 
                                                </div>
                                                <hr class="traco">
                                                <div class="form-group text-center">
                                                    <label for="" style="color: #3a3d42;font-weight: 100;">Tipo de Plano</label>
                                                    <select name="plano_tipo" class="form-control" style="text-align: center; border: none">
                                                        <option value=""></option>
                                                        <option value="M" <?php if($usuario->plano_tipo == 'M'){ echo "selected";}?>>MENSAL</option>
                                                        <option value="T" <?php if($usuario->plano_tipo == 'T'){ echo "selected";}?>>TRIMESTRAL</option>
                                                        <option value="S" <?php if($usuario->plano_tipo == 'S'){ echo "selected";}?>>SEMESTRAL</option>
                                                    </select>
                                                </div>

                                            </div>		
                                            <span class="input-group-btn btn-lg text-center"></span>
                                            <span class="text-center" style="color: #c6d5ed;font-weight: 100; font-size: 11px;">
                                            <button type="submit"  class="btn btn-default btn-atualizar">atualizar</button>
                                            <input type="hidden" name="pontos" value="<?php echo $usuario->pontos;?>">
                                            <input type="hidden" name="ativo" value="S">
                                            <input type="hidden" name="id" value="<?php echo $_SESSION['dadosLogadoCLiente']->id;?>">
                                            <input type="hidden" name="acao" value="editarClientes">
                                        </form>
                                </div>
                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                    <div class="thumbnail text-center" style="background-color:#ffffff">
                                        <div class="caption">
                                            <h3>MEU PLANO</h3>
                                            <h4><?php echo utf8_decode($plano_usuario->nome);?></h4>
                                            <p style="text-align: justify; font-size: 18px"> 
                                                <?php echo utf8_decode($plano_usuario->descricao);?>
                                            </p>
                                            <h3 style="color:#d76e79;font-weight: bold;">R$<?=number_format($plano_usuario->valor,2,',','.');?>/MÊS</h3>
                                            <p>
                                                <a href="#planos_a" class="add-to-cart btn btn-default" style="border: 1px solid #d76e79; background-color: #fff; color:#d76e79;padding: 6px 35px 6px;margin-top: 20px; border-radius: 0">
                                                    trocar plano
                                                </a>
                                            </p>
                                        </div>
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
    <script src="load.js"></script>
</html>
