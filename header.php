<?php
include('class/info-site2.php');
$infoSite = InfoSite2::getInstance(Conexao::getInstance())->rsDados();
?>

  <style>
    
    .roxo {
      background:#4155a1;
    }

    .logo-esp {
      padding-bottom: 10px;
    }

  </style>
 
 <div class="row-fluid roxo">
  
  <div class="row-fluid text-center">
	<a href="."><img src="images/logo-minhanossa.png" class="logo-esp" alt="" width="180"></a>
  </div> 
  <?php /*?> <div id="custom-search-input" class="col-sm-3 hidden-xs pull-right" style="margin: -130px 0 0;">
                <div class="input-group col-md-12">
                    <input type="text" class="form-control input-lg" placeholder="Faça sua busca aqui" />
                    <span class="input-group-btn">
                        <button class="btn btn-info btn-lg" type="button">
                            <i class="fa fa-search" style="color:#31bbac"></i>
                        </button>
                    </span>
                </div>
            </div><?php */?>

   <nav class="navbar navbar-default" role="navigation" style="border-radius: 0px !important;">
       <!-- Brand and toggle get grouped for better mobile display -->
       <div class="navbar-header">
           <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
               <span class="sr-only">Menu</span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
           </button>
           
       </div>
   
       <!-- Collect the nav links, forms, and other content for toggling -->
       <div class="collapse navbar-collapse navbar-ex1-collapse" style="text-transform: uppercase;font-size: 18px;margin-left: 290px;">
           <ul class="nav navbar-nav navbar-center">
                <li <?php if(basename($_SERVER['SCRIPT_NAME']) == 'index.php'){ echo "class='active'";}?>><a href=".">HOME</a></li>
              <!-- <li <?php if(basename($_SERVER['SCRIPT_NAME']) == 'como-funciona.php'){ echo "class='active'";}?>><a href="como-funciona.php">COMO FUNCIONA</a></li>
              <?php?> <li class="dropdown"> -->
               <?php?>
               <li <?php if(basename($_SERVER['SCRIPT_NAME']) == 'marcas.php'){ echo "class='active'";}?>><a href="marcas.php"> MARCAS</a></li>
               <?php /*?><li <?php if(basename($_SERVER['SCRIPT_NAME']) == 'blog.php'){ echo "class='active'";}?>><a href="blog.php">Blog</a></li><?php */?>
			   
<!--			   <li><a href="cadastrar.php">ASSINE</a></li>-->
			   <!-- <li <?php if(basename($_SERVER['SCRIPT_NAME']) == 'minhas-pecas.php'){ echo "class='active'";}?>><a href="minhas-pecas.php">NOSSOS EDITORIAS</a></li>
			    -->
			   <li <?php if(basename($_SERVER['SCRIPT_NAME']) == 'nosso-acervo.php'){ echo "class='active'";}?>><a href="nosso-acervo.php">NOSSO ACERVO</a></li>
			
			    <?php/* if($_SESSION['clienteLogado'] == ''){ ?>
			   <!--  <li><a href="checkout/login.php">assinante</a></li>-->
			    <?php } */?>   
			   
			   <?php if($_SESSION['clienteLogado'] <> ''){ ?>
			   <li><a href="lista-de-desejos.php">LISTA DE DESEJOS</a></li>
			   <?php } ?>
			   
			   
               <li <?php if(basename($_SERVER['SCRIPT_NAME']) == 'contato.php'){ echo "class='active'";}?>><a href="contato.php">LOJA</a></li>
               
<!--               <li class="social-topo hidden-xs"><a href="<?php echo $infoSite->facebook;?>"><i class="fa fa-facebook"></i></a></li> -->
               <li class="social-topo hidden-xs"><a href="<?php echo $infoSite->instagram;?>"><i class="fa fa-instagram"></i></a></li>
               
               <div class="col-xs-12 hidden-lg hidden-md hidden-sm text-left">
                  <a href="#">
                    &nbsp;
                  </a>
               </div>
               <div class="col-xs-6 social-topo hidden-lg hidden-md hidden-sm text-left">
<!--                  <a href="<?php echo $infoSite->facebook;?>">-->
                     <i class="fa fa-facebook"></i>
                  </a>
               </div> 
               <div class=" col-xs-6 social-topo hidden-lg hidden-md hidden-sm text-left">
                  <a href="<?php echo $infoSite->instagram;?>">
                     <i class="fa fa-instagram"></i>
                  </a>
               </div>
		   </ul>
       </div><!-- /.navbar-collapse -->
   </nav>

</div>