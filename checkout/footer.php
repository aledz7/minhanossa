<?php 
include('Connections/conexao.php');
include('funcoes.php');
include('config.php');

include('../class/info-site.php');
$infoSite = InfoSite::getInstance(Conexao::getInstance())->rsDados();

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1") || ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO tbl_contatos (email) VALUES (%s)",
                       GetSQLValueString($_POST['email'], "text"));

  mysql_select_db($database_conexao, $conexao);
  $Result1 = mysql_query($insertSQL, $conexao) or die(mysql_error());
  if($Result1){
	  echo "<script>alert('E-mail cadastrado com sucesso!');
	            onload='window.history.back();'
	        </script>";
			$_SESSION['email'] = $_POST['email'];
	  
	  }
}

?>
<section class="tweets_area">
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <div class="tweet-content">
          <div class="tweet-title ma-title">
            <h2>Assine  o nosso  Newsletter</h2>
          </div>
          <div class="blog-search">
            <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
              <input type="text" name="email" placeholder="  E-mail">
              <button type="submit">Assinar</button>
              <input type="hidden" name="MM_insert" value="form1" />
            </form>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="social-footer">
          <div class="ma-title">
            <h2>+
              <?=$infoSite->nome;?>
            </h2>
          </div>
          <div class="footer-static-content">
            <ul class="link-follow">
              <li class="first"> <a class="twitter fa fa-twitter" href="<?php echo $infoSite->twitter?>"> </a> </li>
              <li class="first"> <a class="google fa fa-google-plus" href="<?php echo $infoSite->gplus ?>"> </a> </li>
              <li class="first"> <a class="facebook fa fa-facebook" href="<?php echo $infoSite->facebook ?>"> </a> </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<div class="ma-footer-static ma-footer-top">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="container-inner">
          <div class="footer-static-top">
            <div class="row">
              <div class="f-col f-col1 col-md-3 col-sm-4 col-xs-12">
                <div class="static_all">
                  <div class="footer-static-title">
                    <h3>MINHA CONTA</h3>
                  </div>
                  <div class="footer-static-content">
                    <ul>
                      <?php if($_SESSION['MM_Username'] <> '') { ?>
                      <li> <a href="area-cliente.php">Meus Dados</a> </li>
                      <li> <a href="area-cliente.php">Meus Pedidos</a> </li>
                      <li> <a href="logout.php">Sair</a> </li>
                      <?php } else { ?>
                      <li> <a href="cadastrar.php">Cadastrar</a> </li>
                      <li> <a href="carrinho.php">Ver carrinho</a> </li>
                      <li> <a href="login.php">Fazer Login</a> </li>
                      <?php } ?>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="f-col f-col2 col-md-3 hidden-sm col-xs-12">
                <div class="static_all">
                  <div class="footer-static-title">
                    <h3>INSTITUCIONAL</h3>
                  </div>
                  <div class="footer-static-content">
                    <ul>
                      <li> <a href="<?=$pagQuemSomos;?>"> Sobre a
                        <?=$infoSite->nome;?>
                        </a> </li>
                      <li> <a href="<?php echo $pagSegPrivacidade;?>"> Seguran&ccedil;a e Privacidade </a> </li>
                      <li> <a href="<?php echo $pagTrocasDevolucoes;?>"> Trocas e Devolu&ccedil;&otilde;es </a> </li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="f-col f-col3 col-md-3 col-sm-4 col-xs-12">
                <div class="static_all">
                  <div class="footer-static-title">
                    <h3>SAC</h3>
                  </div>
                  <div class="footer-static-content">
                    <ul>
                      <li> <a href="comunicar-erro.php"> Comunicar Erro </a> </li>
                      <li> <a href="contato.php"> Contato </a> </li>
                      <li> <a href="#"> </a> </li>
                      <li> <a href="#"> </a> </li>
                      <li  class="last"> <a href="#"> </a> </li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="f-col f-col4 col-md-3 col-sm-4 col-xs-12">
                <div class="footer-static-title">
                  <h3><?php echo $infoSite->nome ?></h3>
                </div>
                <div class="footer-static-content">
                  <?php if($infoSite->logo <> '') { ?>
                  <img src="../img_noticias/<?php echo $infoSite->logo ?>" width="60%" alt="">
                  <?php  } ?>
                  <p class="phone"> E-mail: <?php echo $infoSite->email; ?><br>
                    Telefone: <?php echo $infoSite->telefone; ?> </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<footer class="footer-address">
  <div class="container">
    <div class="container-inner">
      <div class="row">
        <div class="col-md-6">
          <address>
          ©<?php echo $infoSite->nome ?> - Todos os Direitos Reservados
          </address>
        </div>
        <div class="col-md-6">
          <div class="footer-payment"> <a href="#"> <img alt="" src="img/footer/pagamento.png"> </a> </div>
        </div>
      </div>
    </div>
  </div>
</footer>
