<?php
@ session_start();
//print_r($_SESSION);
include('../class/html.php');
$html = new HTML;

include('../class/clientes.php');
$clientes = Clientes::getInstance(Conexao::getInstance());

$descDados = $clientes->rsDados('', '', '', '', '', '', '', $_SESSION['MM_Username']);
$descDados = $descDados[0];
 
if($_GET['tipo'] == 'fisica' ) {
	?>
    
    <div class="input-one form-list col-sm-6">
       <label class="required">
        Seu Nome
        <em>*</em>
       </label>
       <input class="email" type="text" required="" name="nome" id="nome" value="<?php echo $descDados->nome ?>">
      </div>
      
      
	<div class="input-one form-list col-sm-6">
       <label class="required">
        CPF
        <em>*</em>
       </label>
       <input class="email" type="text" required="" name="cpf" id="cpf" value="<?php echo $descDados->cpf ?>">
      </div> 
      
      
      <div class="input-one form-list col-sm-6">
       <label class="required">
        RG
        <em>*</em>
       </label>
       <input class="email" type="text" required="" name="rg" id="rg" value="<?php echo $descDados->rg ?>">
      </div>      
    
    
    <div class="input-one form-list col-sm-6">
       <label class="required">
        Data de Nascimento
        <em>*</em>
       </label>
       <input class="email" type="date" required="" name="data_de_nascimento" id="data_de_nascimento" value="<?php echo $descDados->data_de_nascimento ?>">
      </div> 
  
<?php 
} 

if($_GET['tipo'] == 'juridica' ) {
	?>
    
    <div class="input-one form-list col-sm-6">
       <label class="required">
        Seu Nome
        <em>*</em>
       </label>
       <input class="email" type="text" required="" name="nome" id="nome" value="<?php echo $descDados->nome ?>">
      </div>
      
      
      <div class="input-one form-list col-sm-6">
       <label class="required">
        Nome Fantasia
        <em>*</em>
       </label>
       <input class="email" type="text" required="" name="nome_fantasia" id="nome_fantasia" value="<?php echo $descDados->nome_fantasia ?>">
      </div>
      
      
      <div class="input-one form-list col-sm-6">
       <label class="required">
        CNPJ
        <em>*</em>
       </label>
       <input class="email" type="text" required="" name="cnpj" id="cnpj" value="<?php echo $descDados->cnpj ?>">
      </div>
      

<?php 
} 
?>
