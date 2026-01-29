<?php
/*include('class/info-site2.php');
$infoSite = InfoSite2::getInstance(Conexao::getInstance())->rsDados();*/
?>

<section id="footer">
      <div class="panel-footer">
            
            <div class="container">
                
                <div class="row">
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <div>Acompanhe nossas redes:</div>
                        <div>
                        <a href="<?php echo $infoSite->facebook;?>"><i class="fa fa-facebook  social-footer"></i></a>
                        <a href="<?php echo $infoSite->instagram;?>"><i class="fa fa-instagram  social-footer"></i></a>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <div class="icon-chat">
                        <i class="fa fa-comment-o" aria-hidden="true"></i>
                        </div>
                        <div>Mande um alô para a Minha Nossa!</div>
                        <div><strong><?php echo $infoSite->email;?></strong></div>
                        <div><strong><?php echo $infoSite->telefone;?></strong></div>
                        <div><strong><?php echo $infoSite->telefone2;?></strong></div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <div class="icon-local">
                        <i class="fa fa-map-marker" aria-hidden="true"></i>
                        </div>
                        <div class="clearfix">&nbsp;</div>
                        <div><strong><?php echo utf8_decode($infoSite->logradouro);?></strong></div>
                        <div><strong>CEP: <?php echo $infoSite->cep;?></strong></div>
                    </div>
                </div>
                
            </div>
            
        </div>
    </section>