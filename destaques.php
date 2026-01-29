<?php

mysql_select_db($database_conexao, $conexao);
$query_rs_fotoss = "SELECT * FROM tbl_home ORDER BY id ASC limit 3";
$rs_fotoss = mysql_query($query_rs_fotoss, $conexao) or die(mysql_error());
$row_rs_fotoss = mysql_fetch_assoc($rs_fotoss);
$totalRows_rs_fotoss = mysql_num_rows($rs_fotoss);

include('funcoes/cortar-imagem.php');
?>
<section class="slide-wrapper">
		<div class="banner" style="padding: 0px 0 0">
	<!--<img src="https://www.minhanossa.net.br/images/banner-principal-topo.gif" class="img-responsive">
		<div class="row infor">
			<div class="col-md-12">
				<p class="centro"><img class="imagem" src="images/banner-princ.gif"></p>
			</div>
		</div>-->
		<br>

		<div class="container">
			<div class="row row-centered" style="background-color: #fff; padding-top: 40px;">
				<div class="col-xs-12 col-sm-10 col-md-10 col-lg-10 col-centered">
					<div class="col-md-12 no-padding lib-item pull-right" data-category="view">
						<div class="lib-panel">
							<div class="row box-shadow">
								<div class="borda-sobre1">
									&nbsp;
									<div class="botao-termos">
										<a href="termos.php">termos & condições de uso</a>
									</div>
								</div>

								<div class="col-md-6">
									<div class="lib-row lib-header">
										<h1>como funciona</h1>
										<div class="lib-header-seperator"></div>
									</div>
									<?php $comoFunciona = $textos->rsDados(1);?>
									<div class="lib-row lib-desc">
										<?php echo $comoFunciona->textos;?>
									</div>
								</div>
								<div class="col-md-6">
									<img class="lib-img-show" src="images/loja2.jpg" style="width: 476px; margin-left: 13px;">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		</div></div>
	</section>

  <section id="planos" class="yell">
    <div class="container">
      <div class="row row-centered">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-centered"> <br>
          <!-- <h1 class="centro" style="color: #fff">MINHAS (NOSSAS!) PEÇAS</h1> -->
          <br>
            <div class="col-sm-4 foto">
            <div class="thumbnail"> <a href="javascript:;">
              <img src="images/Phyna_2025.jpg" alt="" class="img_mod"> </a>
            </div>
          </div>
          <div class="col-sm-4 foto">
            <div class="thumbnail"> <a href="javascript:;">
              <img src="images/Plena_2025.jpg" alt="" class="img_mod"> </a>
            </div>
          </div>
          <div class="col-sm-4 foto">
            <div class="thumbnail"> <a href="javascript:;">
              <img src="images/Musa_2025.jpg" alt="" class="img_mod"> </a>
            </div>
          </div>
		  <div class="col-sm-4 foto">
            <div class="thumbnail"> <a href="javascript:;">
              <img src="images/Diva_2025.jpg" alt="" class="img_mod"> </a>
            </div>
          </div>
		  <div class="col-sm-4 foto">
            <div class="thumbnail"> <a href="javascript:;">
              <img src="images/Plenissima_2025.jpg" alt="" class="img_mod"> </a>
            </div>
			
          </div>
		  <div class="col-sm-4 foto">
            <div class="thumbnail"> <a href="javascript:;">
              <img src="images/Mala_2025.jpg" alt="" class="img_mod"> </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
