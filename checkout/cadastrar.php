<?php
include('../class/estados.php');
$estados = Estados::getInstance(Conexao::getInstance());
?>
<!doctype html>
<html class="no-js" lang="">
<?php include('head.php'); ?>
<body>
<!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]--> 
<!-- Add your site or application content here --> 
<!-- start header_area
		============================================ -->
<?php include('header.php') ?>
<!-- end header_area
		============================================ -->
<section class="collapse_area">
  <div class="container">
    <div class="row">
      <div class="col-md-12 col-sm-12">
        <div class="check">
          <h1>Dados Cadastrais</h1>
        </div>
        <div class="faq-accordion">
          <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
            <div class="panel panel-default">
              <div id="collapseTwo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo" aria-expanded="true">
                <div class="row">
                  <form action="add-cliente.php" method="POST" name="formCliente" id="formCliente">
                    <div class="easy">
                      <div class="billing-info">
                        <div class="input-one form-list col-sm-4">
                          <label class="required"> Seu nome <em>*</em> </label>
                          <input class="email" type="text" name="nome" required="">
                        </div>
                        <div class="input-one form-list col-sm-4">
                          <label class="required">Sexo<em>*</em></label>
                          <select class="email s-email" name="sexo">
                            <option value="F">Feminino</option>
                            <option value="M">Masculino</option>
                          </select>
                        </div>
                        <div class="input-one form-list col-sm-4">
                          <label class="required"> CPF <em>*</em> </label>
                          <input class="email" type="text" required="" name="cpf" id="cpf" onKeyPress="return txtBoxFormat(this.name, '999.999.999-99', event);" onkeyup="javascript:JumpField(this);" maxlength="14">
                        </div>
                        <div class="input-one form-list col-sm-6">
                          <label class="required"> Data de Nascimento <em>*</em> </label>
                          <input class="email" type="text" name="data_nascimento" id="data_nascimento" required="" maxlength="10">
                        </div>
                        <div class="input-one form-list col-sm-6">
                          <label class="required"> Telefone(celular) <em>*</em> </label>
                          <input class="email" type="text" name="telefone" id="telefone" required="" onKeyPress="return txtBoxFormat(this.name, '(99) 9999-9999', event);" maxlength="14" />
                        </div>
                        <div class="input-one form-list col-sm-6">
                          <label class="required"> E-mail <em>*</em> </label>
                          <input class="email" type="text"  name="email" id="email" value="<?php echo $_POST['email']?>" required="">
                        </div>
                        <div class="input-one form-list col-sm-6">
                          <label class="required"> Senha <em>*</em> </label>
                          <input class="email" type="password" required="" name="senha">
                        </div>
                        <div class="input-one form-list col-sm-12">
                          <label class="required"> Endereço <em>*</em> </label>
                          <input class="email" type="text" required="" name="endereco">
                        </div>
                        <div class="input-one form-list col-sm-6">
                          <label class="required"> CEP <em>*</em> </label>
                          <input class="email" type="text" required="" name="cep" id="cep" onkeyup="javascript:JumpField(this);" onKeyPress="return txtBoxFormat(this.name, '99.999-999', event);" maxlength="10">
                        </div>
                        <div class="input-one form-list col-sm-6">
                          <label class="required"> Bairro <em>*</em> </label>
                          <input class="email" type="text" required="" name="bairro">
                        </div>
                        <div class="input-one form-listcol col-sm-6">
                          <div class="country-select">
                            <label class="required"> Estado <em>*</em> </label>
                            <?php
					 $estados->selectEstados('id_estado', '', '', 'nome', 'S');
					 ?>
                          </div>
                        </div>
                        <div class="input-one form-list col-sm-6">
                          <label class="required"> Cidade <em>*</em> </label>
                          <div id="janela_Cidades">
                            <select name="" id="" class="form-control">
                              <option value="">Primeiro - Selecione um Estado</option>
                            </select>
                          </div>
                        </div>
                        <div class="input-one form-list col-sm-12">
                          <label class="required"> Complemento <em>*</em> </label>
                          <input class="email" type="text" required="" name="complemento">
                        </div>
                        <br/>
                        <br/>
                        <br/>
                        <div class="block-button-left">
                          <button class="button2 get" type="submit" title="" style="margin-top:30px;"> <span>Criar cadastro</span> </button>
                        </div>
                        <input type="hidden" name="tipo" value="clientes" />
                        <input type="hidden" name="ativo" value="S" />
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php include('footer.php'); ?>

<!-- end footer-address
		============================================ --> 
<!-- start scrollUp
		============================================ -->
<div id="toTop"> <i class="fa fa-chevron-up"></i> </div>
<!-- end scrollUp
		============================================ --> 
<!-- jquery
		============================================ --> 
<script src="js/vendor/jquery-1.11.3.min.js"></script>~ 
<script src="js/jquery-ui.js"></script> 
<script src="outras-funcoes.js" type="text/javascript"></script> 
<script src="ajax_framework.js" type="text/javascript"></script> 
<!-- bootstrap JS
		============================================ --> 
<script src="js/bootstrap.min.js"></script> 
<!-- wow JS
		============================================ --> 
<script src="js/wow.min.js"></script> 
<!-- price-slider JS
		============================================ --> 
<script src="js/jquery-price-slider.js"></script> 
<!-- Img Zoom js --> 
<script src="js/img-zoom/jquery.simpleLens.min.js"></script> 
<!-- meanmenu JS
		============================================ --> 
<script src="js/jquery.meanmenu.js"></script> 
<!-- owl.carousel JS
		============================================ --> 
<script src="js/owl.carousel.min.js"></script> 
<!-- scrollUp JS
		============================================ --> 
<script src="js/jquery.scrollUp.min.js"></script> 
<!-- Nivo slider js
		============================================ --> 
<script src="lib/js/jquery.nivo.slider.js" type="text/javascript"></script> 
<script src="lib/home.js" type="text/javascript"></script> 
<!-- plugins JS
		============================================ --> 
<script src="js/plugins.js"></script> 
<!-- main JS
		============================================ --> 
<script src="js/main.js"></script> 
<script src="load.js"></script> 

<!-- VERIFICA SE USUÁRIO JÁ EXISTE --> 
<script type="text/javascript">
		 $(function(){
		  $("input[name='email']").on('blur', function(){
             var email = $(this).val();
            $.get('verifica-usuario.php?email=' + email, 
			function(data){
            //$('#resultado').html(data);
			$("input[name='email']").val(data);
			//$("input[name='nomeUsuario']").css('border-color', 'red');
           });
         });
		});// fim do jquery

       </script>
</body>
</html>
