<?php
/*include('class/info-site2.php');
$infoSite = InfoSite2::getInstance(Conexao::getInstance())->rsDados();*/

include('class/newsletter.php');
$newsletter = Newsletter::getInstance(Conexao::getInstance());
$newsletter->add('index.php', 'E-mail cadastrado com sucesso!')
?>
<!-- <section id="assine">
      <div class="assine-footer">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <h1>ASSINE <strong>ONLINE</strong></h1>
                        <p>Tranforme o seu guarda-roupa em <br> um universo de possibilidades!</p>
                        <br>
                        <a href="cadastrar.php" class="assine-footer-botao">ASSINAR</a>
                        <br>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <h1>RECEBA <strong>NOVIDADES</strong></h1>
                        <form method="post" name="formnews" action="">
                            <div class="form-group">
                                <input type="text" class="form-control news" name="email" id="" placeholder="seu e-mail aqui" style="    display: inline-block; width: 71%; margin-left: 12%; border-radius: 30px; padding: 7px 23px 7px; border: 1px solid #fff;">
                                <button class="btn-default input-botao" type="submit">ENVIAR</button>
                            </div>
                            <input type="hidden" name="acao" value="addNewsletter">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
   <section id="newsletter" class="newsletter container-fluid"> 
</section> -->
<section id="footer">
      <div class="panel-footer">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                        <h3>SIGA A GENTE</h3>
                        <div>
                        <?php if($infoSite->instagram <> ''){?>
                        <a href="<?php echo $infoSite->instagram;?>" target="_blank">
                            <img src="images/insta.png" alt="">
<!--                            <i class="fa fa-instagram  social-footer"></i>-->
                        </a>
                        <?php }?>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                        <h3>FUNCIONAMENTO</h3>
                        <p> Segunda à Sexta das 10h às 19h <br>
                            Sábados 10h - 14h</p>
                    </div>
                    <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                        <h3>ONDE ESTAMOS</h3>
                        <p><?php echo utf8_decode($infoSite->logradouro);?></p>
                    </div>
                    <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                        <h3>CONTATO</h3>
                        <p><?php echo $infoSite->email;?></p>
                        <p><?php echo $infoSite->telefone;?> / <?php echo $infoSite->telefone2;?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>