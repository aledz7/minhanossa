<?php require_once('Connections/conexao.php'); ?>
<?php

include('funcoes.php');

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

mysql_select_db($database_conexao, $conexao);
$query_rs_endereco = "SELECT * FROM tbl_endereco WHERE id = '".$_GET['id']."' AND id_cliente = '".$_GET['id_cliente']."'";
$rs_endereco = mysql_query($query_rs_endereco, $conexao) or die(mysql_error());
$row_rs_endereco = mysql_fetch_assoc($rs_endereco);
$totalRows_rs_endereco = mysql_num_rows($rs_endereco);

mysql_select_db($database_conexao, $conexao);
$query_rs_dados_estados = "SELECT * FROM dados_estados";
$rs_dados_estados = mysql_query($query_rs_dados_estados, $conexao) or die(mysql_error());
$row_rs_dados_estados = mysql_fetch_assoc($rs_dados_estados);
$totalRows_rs_dados_estados = mysql_num_rows($rs_dados_estados);

mysql_select_db($database_conexao, $conexao);
$query_rs_dados_cidades = "SELECT * FROM dados_cidades WHERE id = '".$row_rs_endereco['cidade']."'";
$rs_dados_cidades = mysql_query($query_rs_dados_cidades, $conexao) or die(mysql_error());
$row_rs_dados_cidades = mysql_fetch_assoc($rs_dados_cidades);
$totalRows_rs_dados_cidades = mysql_num_rows($rs_dados_cidades);

?>
<!doctype html>
<html class="no-js" lang="">
    <? include('head.php'); ?>
    <body>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <!-- Add your site or application content here -->
        <!-- start header_area
		============================================ -->
        <? include('header.php') ?>
        <!-- end header_area
		============================================ -->
        <section class="collapse_area">
         <div class="container">
          <div class="row">
           <div class="col-md-12 col-sm-12">
            <div class="check">
             <h1>Dados do Endereço</h1>
            </div>
            <div class="faq-accordion">
             <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
              <div class="panel panel-default" style="border-color: #FFF;">
               <div id="collapseTwo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo" aria-expanded="true">
                <div class="row">
                 <form name="formAtualizaCliente" id="formAtualizaCliente" action="add-endereco.php" method="POST">
                   <div class="billing-info">
                    <div class="input-one form-list col-sm-4">
                     <label class="required">
                      Estado
                      <em>*</em>
                     </label>
                     <select class="email s-email" name="id_estado" id="id_estado" onchange="buscar_cidade()">
                      <?php do { ?>
                       <option value="<?php echo $row_rs_dados_estados['id']?>"<?php if(!(strcmp($row_rs_dados_estados['id'], $row_rs_endereco['estado']))) { echo "selected=\"selected\""; } ?> title="<?php echo texto($row_rs_dados_estados['nome']); ?>">
                        <?php echo $row_rs_dados_estados['uf']?>
                       </option>
                       <?php
                        } while ($row_rs_dados_estados = mysql_fetch_assoc($rs_dados_estados));
                                 $rows = mysql_num_rows($rs_dados_estados);
                                 if($rows > 0) {
                                  mysql_data_seek($rs_dados_estados, 0);
                                  $row_rs_dados_estados = mysql_fetch_assoc($rs_dados_estados);
                        }
                       ?>
                      </select>   
                        
                    </div>
                    <div class="input-one form-list col-sm-4">
                     <label class="required">
                      Cidade
                      <em>*</em>
                     </label>
                     <div id="load_cidade">
                     <select name="id_cidade" id="id_cidade" class="email s-email">
                        <option value="<?php echo $row_rs_dados_cidades['id'] ?>" title="<?php echo $row_rs_dados_cidades['nome']?>">
                         <?php echo $row_rs_dados_cidades['nome'] ?>
                        </option>
                     </select> 
                     </div>
                    </div>
                    <div class="input-one form-list col-sm-4">
                     <label class="required">
                      CEP
                      <em>*</em>
                     </label>
                     <input class="email" type="text" required="" name="cep" id="cep" value="<?php echo $row_rs_endereco['cep'] ?>" >
                    </div>
                    <div class="input-one form-list col-sm-12">
                     <label class="required">
                      Endereço
                      <em>*</em>
                     </label>
                     <input class="email" type="text" required="" name="endereco" id="endereco" value="<?php echo $row_rs_endereco['endereco'] ?>">
                    </div>
                    <div class="input-one form-list col-sm-12">
                     <label class="required">
                      Bairro
                      <em>*</em>
                     </label>
                     <input class="email" type="text" required="" name="bairro" id="bairro" value="<?php echo $row_rs_endereco['bairro'] ?>" >
                    </div>
                    <div class="input-one form-list col-sm-6">
                     <label class="required">
                      Telefone
                     </label>
                     <input class="email" type="text" name="telefone" id="telefone" value="<?php echo $row_rs_endereco['tel_fixo'] ?>">
                    </div>
                    <div class="input-one form-list col-sm-6">
                     <label class="required">
                      Celular
                     </label>
                     <input class="email" type="text" name="celular" id="celular" value="<?php echo $row_rs_endereco['tel_celular'] ?>">
                    </div>
                    
                    <div class="form-group col-sm-12">
                     <div class="block-right">
                      <span>
                       Para voltar clique
                       <a class="o-back-to" href="javascript:history.back()">aqui</a>!
                      </span>
                     </div>
                     <div class="block-button-left">
                      <button class="button2 get" type="submit" title="" style="margin-top:30px;">
                       <span>Cadastrar novo endereço!</span>
                      </button>
                     </div>
                    </div>
                   </div>
                   <input type="hidden" name="id_cliente" value="<?php echo $row_rs_dados_cliente['id'] ?>" />
                   <input type="hidden" name="tipo" value="novoEndereco" />
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
        
        <? include('footer.php'); ?>
        
        <!-- end footer-address
		============================================ -->
        <!-- start scrollUp
		============================================ -->
        <div id="toTop">
            <i class="fa fa-chevron-up"></i>
        </div>
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
    </body>
</html>
<?php
mysql_free_result($rs_estados);
?>
<!-- VERIFICA SE USUÁRIO JÁ EXISTE -->
      
<script>
   function buscar_cidade(){
     var estado = $('#id_estado').val();
     if(estado){
       var url = 'buscar_cidade.php?estado='+estado;
       $.get(url, function(dataReturn) {
         $('#load_cidade').html(dataReturn);
       });
     }
   }
</script>