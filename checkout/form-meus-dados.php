<?php
include('../class/clientes.php');
$clientes = Clientes::getInstance(Conexao::getInstance());

$descDados = $clientes->rsDados('', '', '', $_SESSION['MM_Username']);
?>
<style>
	.form-list{
		height: 70px;
	}  
</style>
<form name="formAtualizaCliente" id="formAtualizaCliente" action="add-cliente.php" method="POST">
  <div class="billing-info">
    <div class="input-one form-list col-sm-12">
      <label class="required"> Tipo de Cadastro <em>*</em> </label>
      <br>
      <br>
      <input name="tipo_pessoa" type="radio" id="tipo_pessoaF" onClick="AtualizaJanela('tipo-cliente.php?tipo=fisica&id=<?=$row_rs_dados_cliente['id'];?>', 'tipoPessoa')" value="F" <?php if($row_rs_dados_cliente['tipo_pessoa'] == 'F') { echo 'checked="checked"'; } ?>>
      <label style="padding-top:8px; margin-bottom:0px;" for="tipo_pessoaF">Pessoa Física</label>
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <input name="tipo_pessoa" type="radio" id="tipo_pessoaJ" value="J" onClick="AtualizaJanela('tipo-cliente.php?tipo=juridica&id=<?=$row_rs_dados_cliente['id'];?>', 'tipoPessoa')" <?php if($row_rs_dados_cliente['tipo_pessoa'] == 'J') { echo 'checked'; } ?>>
      <label style="padding-top:8px; margin-bottom:0px;" for="tipo_pessoaJ">Pessoa Jurídica</label>
    </div>
    <div id="janela_tipoPessoa">
      <?php
              $_GET['tipo'] = ($row_rs_dados_cliente['tipo_pessoa'] == 'F') ? 'fisica' : 'juridica';
			  include('tipo-cliente.php');
			  ?>
    </div>
    <div class="input-one form-list col-sm-6">
      <label class="required"> Sexo <em>*</em> </label>
      <select class="email s-email" name="sexo" style="padding:5px">
        <option value="<?php echo $row_rs_dados_cliente['sexo'] ?>"<?php if (!(strcmp("F", $row_rs_dados_cliente['sexo']))) {echo "selected=\"selected\"";} ?>>Feminino</option>
        <option value="<?php echo $row_rs_dados_cliente['sexo'] ?>"<?php if (!(strcmp("M", $row_rs_dados_cliente['sexo']))) {echo "selected=\"selected\"";} ?>>Masculino</option>
      </select>
    </div>
    <div class="input-one form-list col-sm-6">
      <label class="required"> Telefone(celular) <em>*</em> </label>
      <input class="email" type="text" required="" name="telefone" id="telefone" value="<?php echo $row_rs_dados_cliente['telefone'] ?>">
    </div>
    <div class="input-one form-list col-sm-6">
      <label class="required"> E=mail <em>*</em> </label>
      <input class="email" type="text" required="" name="email" id="email" value="<?php echo $row_rs_dados_cliente['email']  ?>">
    </div>
    <div class="input-one form-list col-sm-6">
      <label class="required"> Senha </label>
      <input class="email" type="password" name="senha" id="senha" value="<?php echo $row_rs_dados_cliente['senha']  ?>" >
    </div>
    <div class="input-one form-list col-sm-6">
      <label class="required"> Endereço <em>*</em> </label>
      <input class="email" type="text" required="" name="endereco" id="endereco" value="<?php echo utf8_encode($row_rs_dados_cliente['endereco']) ?>">
    </div>
    <div class="input-one form-list col-sm-6">
      <label class="required"> CEP <em>*</em> </label>
      <input class="email" type="text" required="" name="cep" id="cep" value="<?php echo $row_rs_dados_cliente['cep'] ?>">
    </div>
    <div class="input-one form-list col-sm-6">
      <label class="required"> Bairro <em>*</em> </label>
      <input class="email" type="text" required="" name="bairro" id="bairro" value="<?php echo utf8_encode($row_rs_dados_cliente['bairro']) ?>">
    </div>
    <div class="input-one form-list col-sm-6">
      <label class="required"> Estado <em>*</em> </label>
      <?php echo $estados->selectEstados('id_estado', '', $row_rs_dados_cliente['id_estado'], 'nome', 'S');
		?> </div>
    <div class="input-one form-listcol col-sm-6">
      <div class="country-select">
        <label class="required"> Cidade <em>*</em> </label>
        <div id="janela_Cidades">
          <?php 
					if($row_rs_dados_cliente['id_estado'] == '' or $row_rs_dados_cliente['id_cidade'] == '') { ?>
          <select name="" id="" class="form-control">
            <option value="">Primeiro - Selecione um Estado</option>
          </select>
          <?php 
					} else { 
						$_GET['id_estado'] = $row_rs_dados_cliente['id_estado'];
						$_GET['id_cidade'] = $row_rs_dados_cliente['id_cidade'];
						include('cidades.php');
					}
					?>
        </div>
      </div>
    </div>
	  <div class="input-one form-list col-sm-6">
       <label class="required"> Data de contratação <em>*</em></label>
		<input class="email" type="text" name="data_contratacao" value="<?php echo formataData($row_rs_dados_cliente['data_contratacao']);?>" readonly/>
	</div>
    <div class="input-one form-list col-sm-12">
      <label class="required"> Complemento <em>*</em> </label>
      <input class="email" type="text" required="" name="complemento" id="complemento" value="<?php echo $row_rs_dados_cliente['complemento'] ?>">
    </div>
    <div class="form-group col-sm-12">
      <div class="block-button-left">
        <button class="button2 get" type="submit" title="" style="margin-top:30px;"> <span>Atualizar Cadastro!</span> </button>
      </div>
    </div>
  </div>
  <input type="hidden" name="ativo" value="<?php echo $row_rs_dados_cliente['ativo'] ?>" />
  <input type="hidden" name="id" value="<?php echo $row_rs_dados_cliente['id'] ?>" />
  <input type="hidden" name="acao" value="editarClientes" />
</form>
