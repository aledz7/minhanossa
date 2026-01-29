<?php

include('class/textos.php');
$textos = Textos::getInstance( Conexao::getInstance() );

include('class/marcas.php');
$marcas = Marcas::getInstance( Conexao::getInstance() );
$pegamarcas = $marcas->rsDados();

include('class/fotos.php');
$fotos = Fotos::getInstance( Conexao::getInstance() );

include('funcoes/cortar-imagem.php');

include('class/estados.php');
$estados = Estados::getInstance(Conexao::getInstance());

include('class/textos.php');
$textos = Textos::getInstance(Conexao::getInstance());

include('class/conteudos.php');
$conteudos = Conteudos::getInstance(Conexao::getInstance());

include('class/clientes.php');
$clientes = Clientes::getInstance(Conexao::getInstance());
$clientes->add('index.php');

include('class/planos.php');
$planos = Planos::getInstance(Conexao::getInstance());
$plano = $planos->rsDados('', 'S');

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
	<link rel="shortcut icon" href="images/fav.png" type="image/x-icon"/>
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
    async defer>
</script>

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
		
		.foto {
			margin-bottom: 20px;
		}
		
		.img_mod {
			width: 100%;
		}
		
		.mg-lft-15p {
			margin-left: 10px;
		}
		
		.icom {
			color: #d76e79;
		}
		
		.icom:hover {
			color: #21294d;
		}
		
		.traco {
			margin-top: -12px!important;
			margin-bottom: 28px;
		}
	</style>

</head>

<body>
	<?php include('header.php');?>
	<section class="slide-wrapper">
		<div class="banner" style="padding: 48px 0 0">
			<div class="container">
				<div class="row row-centered" style="background-color: #fff; padding-top: 40px;">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-centered">
						<div class="col-sm-12 foto">
							<!--<div class="thumbnail" style=" padding-bottom: 184px;">-->
							<div class="thumbnail">
								<div class="caption text-center" style="color: #f05b66">
									<h4>DADOS CADASTRAIS</h4>
                                    <p>Ei, se você já fez o cadastro na loja física, não precisa fazer de novo. <br> 
                                    A senha é o número de assinante escrito no seu cartão</p>
									<form method="post" action="" id="formCadastro">
										
										<div class="col-sm-6">
										<div class="form-group text-center">
											<label for="" style="color: #3a3d42;font-weight: 100;">Nome</label>
											<input type="text" style="text-align: center; border: none" class="form-control" id="nome" name="nome">
										</div>
										<hr class="traco">

										<div class="form-group text-center">
											<label for="" style="color: #3a3d42;font-weight: 100;">Data de Nascimento</label>
											<!--<input type="password" style="text-align: center; border: none" class="form-control" id="" name="senha">-->
											<input class="form-control" name="aniversario" type="date" style="text-align: center; border: none" required="">
										</div>
										
										<hr class="traco">
										</div>	
																					
										<div class="col-sm-6">
										<div class="form-group text-center">
											<label for="" style="color: #3a3d42;font-weight: 100;">CPF</label>
											<input type="text" style="text-align: center; border: none" class="form-control" id="" name="cpf">
										</div>
										
										<hr class="traco">

										<div class="form-group text-center">
											<label for="" style="color: #3a3d42;font-weight: 100;">Celular</label>
											<input type="text" style="text-align: center; border: none" class="form-control" id="" name="telefone">
										</div>
										<hr class="traco">
										</div>
										
										<div class="col-sm-6">
										

										<div class="form-group text-center">
											<label style="color: #3a3d42;font-weight: 100;">Endereço</label>
											<input type="text" style="text-align: center; border: none" class="form-control"  name="endereco">
										</div>
											
										<hr class="traco">
										</div>	

										<div class="col-sm-6">
										

										<div class="form-group text-center">
											<label for="" style="color: #3a3d42;font-weight: 100;">CEP</label>
											<input type="text" style="text-align: center; border: none" class="form-control" name="cep">
										</div>
										<hr class="traco">
										</div>		

										<div class="col-sm-6">
											<div class="form-group text-center">
												<label for="" style="color: #3a3d42;font-weight: 100;">Bairro</label>
												<input type="text" style="text-align: center; border: none" class="form-control" name="bairro">
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
												<input type="text" style="text-align: center; border: none" class="form-control" name="complemento">
											</div>
											<hr class="traco">
										</div>	
                                        <div class="col-sm-6">
										<div class="form-group text-center">
											<label style="color: #3a3d42;font-weight: 100;">E-mail</label>
											<input type="email" style="text-align: center; border: none" class="form-control" name="email">
										</div>
										<hr class="traco">
										<div class="form-group text-center">
											<label for="" style="color: #3a3d42;font-weight: 100;">Plano</label>
											<select name="id_plano" class="form-control" style="text-align: center; border: none">
												<option value=""></option>
												<?php foreach($plano as $item_plano){?>
													<option value="<?php echo $item_plano->id; ?>" <?php if($item_plano->id == $usuario->id_plano){ echo "selected";} ?>><?php echo $item_plano->nome; ?></option>
												<?php } ?>
											</select>
										</div>
										<hr class="traco">
										</div>	
                                        <div class="col-sm-6">
										<div class="form-group text-center">
											<label for="" style="color: #3a3d42;font-weight: 100;">Senha</label>
											<input type="password" style="text-align: center; border: none" class="form-control" name="senha">
										</div>	
										
										<hr class="traco">

										<div class="form-group text-center">
<!--
											<label for="" style="color: #3a3d42;font-weight: 100;">Tipo de Plano</label>
											<select name="plano_tipo" class="form-control" style="text-align: center; border: none">
												<option value=""></option>
												<option value="M" <?php if($usuario->plano_tipo == 'M'){ echo "selected";}?>>MENSAL</option>
												<option value="T" <?php if($usuario->plano_tipo == 'T'){ echo "selected";}?>>TRIMESTRAL</option>
												<option value="S" <?php if($usuario->plano_tipo == 'S'){ echo "selected";}?>>SEMESTRAL</option>
											</select>
-->
                                            &nbsp;<br><br><br><br><br>
										</div>
<!--										<hr class="traco">-->
										</div>	
										
										<div class="g-recaptcha" data-sitekey="6LcYpz4nAAAAAJNOKvejR3JPw_a9w_WMr8w1jqTA"></div>
										
										<span class="input-group-btn btn-lg text-center"></span>
									
										<span class="text-center" style="color: #c6d5ed;font-weight: 100; font-size: 11px;">
					
									<button type="submit" style="border-color: #d76e79; color: #d76e79; border-radius: 0; padding: 15px 45px 15px;" class="btn btn-default" onClick="return valida()">Criar Cadastro</button>
										<input type="hidden" name="tipo" value="clientes" />
                                        <input type="hidden" name="ativo" value="S" />
                                        <input type="hidden" name="acao" value="addClientes" />
                                        <input type="hidden" name="site" value="S" />
									</form>
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
<script src="load.js"></script>
<script>
	function bt_add() {
		var proxima_pagina = parseInt( document.getElementById( 'n_pagina_atual' ).value ) + 1;
		var url = 'mais-pecas.php?pagina=' + proxima_pagina;
		//alert(url);
		AtualizaJanela( url, 'pagina' + document.getElementById( 'n_pagina_atual' ).value );
		document.getElementById( 'n_pagina_atual' ).value = proxima_pagina;
	}
</script>
<script type="text/javascript">
    function valida() {
		if(grecaptcha.getResponse() == "") { 
		alert("captcha errado. Favor tente de novo!");
			return false;
		}
	}
</script>
</html>