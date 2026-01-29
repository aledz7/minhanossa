<?php 
include('Connections/conexao.php'); 
include('config.php'); 

include('../class/info-site.php');
$infoSite = InfoSite::getInstance(Conexao::getInstance())->rsDados();

mysql_select_db($database_conexao, $conexao);
$query_rs_menu_categoria_header = "SELECT tbl_noticias.id, tbl_noticias.titulo as name FROM tbl_noticias where idMenu = 1 LIMIT 0,6";
$rs_menu_categoria_header = mysql_query($query_rs_menu_categoria_header, $conexao) or die(mysql_error());
$row_rs_menu_categoria_header = mysql_fetch_assoc($rs_menu_categoria_header);
$totalRows_rs_menu_categoria_header = mysql_num_rows($rs_menu_categoria_header);

mysql_select_db($database_conexao, $conexao);
$query_rs_categoria_header = "SELECT tbl_noticias.id, tbl_noticias.titulo as name FROM tbl_noticias where idMenu = 1";
$rs_categoria_header = mysql_query($query_rs_categoria_header, $conexao) or die(mysql_error());
$row_rs_categoria_header = mysql_fetch_assoc($rs_categoria_header);
$totalRows_rs_categoria_header = mysql_num_rows($rs_categoria_header);

$colname_rs_pedidos_header = "-1";
if (isset($_SESSION['compra'])) {
  $colname_rs_pedidos_header = $_SESSION['compra'];
}
mysql_select_db($database_conexao, $conexao);
$query_rs_pedidos_header = sprintf("SELECT COUNT(id) as total, SUM(valor_c_acrecimo) as soma FROM tbl_pedidos_por_id_compra WHERE id_compra = %s ORDER BY produto ASC", GetSQLValueString($colname_rs_pedidos_header, "int"));
$rs_pedidos_header = mysql_query($query_rs_pedidos_header, $conexao) or die(mysql_error());
$row_rs_pedidos_header = mysql_fetch_assoc($rs_pedidos_header);
$totalRows_rs_pedidos_header = mysql_num_rows($rs_pedidos_header);

?>
<header class="header_area">
  <div class="top-link">
    <div class="container">
      <div class="row">
        <div class="col-sm-5 text-left links-center">
          <div class="content_right">
            <div class="call_us">
              <p> <i class="fa fa-phone"></i> Entre em Contato: <span> &nbsp;<?php echo $infoSite->telefone; ?></span>  </p>
            </div>
          </div>
        </div>
        <div class="col-md-7">
          <div class="english">
            <ul>
              <li> <a href="contato.php"> <i class="fa fa-headphones"></i>&nbsp;SAC </a> </li>
              <? if($_SESSION['MM_Username'] <> '') { ?>
              <li> <a href="area-cliente.php"> <i class="fa fa-user"></i>&nbsp;MINHA CONTA </a> </li>
              <? } else { ?>
              <li> <a href="login.php"> <i class="fa fa-user"></i>&nbsp;LOGIN | CADASTRE-SE </a> </li>
              <? } ?>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php if($mostraTopo == 'S') { ?>
  <div class="header">
    <div class="container">
      <div class="row">
        <div class="col-md-2"> <a href="../"><img src="../img_noticias/<?php echo $infoSite->logo ?>" alt="" style="margin-top:10px;" ></a> </div>
        <div class="col-md-10">
          <div class="home_menu">
            <nav>
              <ul>
                <li class="active1"> <a href="../">Home</a> </li>
                <? do { ?>
                  <li > <a href="<?php echo str_replace(array('[id]', '[nome]'),array($row_rs_menu_categoria_header['id'], $row_rs_menu_categoria_header['name']),$pagCategorias);?>" style="text-transform:none !important;"> <?php echo utf8_encode($row_rs_menu_categoria_header['name']) ?> </a> </li>
                  <? } while($row_rs_menu_categoria_header = mysql_fetch_assoc($rs_menu_categoria_header)); ?>
              </ul>
            </nav>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php } ?>
  <div class="top-menu" >
    <div class="container">
      <div class="row">
        <div class="col-lg-3 col-md-4 col-sm-5">
          <div class="left-category-menu hidden-xs">
            <div class="left-product-cat">
              <div class="category-heading">
                <h2><a href="../minhas-pecas.php" style="color:white;">Continuar escolhendo</a></h2>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-9 col-md-8 col-sm-7 col-xs-12">
          <div class="site_bar">
            <form action="<?php echo $pagCategorias;?>" name="search_mini_form" id="search_mini_form" method="get">
              <div class="form-search">
                <?php /*?><div class="select-wrapper">
                                            <select class="select" name="categoria" id="categoria">
                                             <option value="">Categorias</option>
                                              <? do { ?>
                                              <option value="<?php echo $row_rs_categoria_header['id'] ?>">
                                               <?php echo $row_rs_categoria_header['name'] ?>
                                              </option>
                                              <? } while($row_rs_categoria_header = mysql_fetch_assoc($rs_categoria_header)); ?>
                                              </select>
                                        </div><?php */?>
                <input class="input-text" type="text" id="busca" name="busca" placeholder="O que Você Precisa?" onKeyPress="return submitenter(this,event)">
                <button class="button" title="pesquisar" type="submit"> <i class="fa fa-search"></i> </button>
              </div>
            </form>
         <!--<div class="top-cart-wrapper">
              <div class="top-cart-contain">
                <div class="block-cart">
                  <div class="top-cart-title"> <a href="carrinho.php">
                    <div class="my-cart"> <i class="fa fa-shopping-cart" aria-hidden="true"></i> Meu Carrinho </div>
                    </a> </div>
                </div>
              </div>
            </div> -->
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- mobile-menu-area start -->
  <div class="mobile-menu-area">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="mobile-menu">
            <nav id="dropdown">
              <ul>
                <li><a href="../index.php">Home</a></li>
                <li><a href="login.php">Minha Conta</a></li>
                <li><a href="../marcas.php">Marcas</a></li>
                <li><a href="../minhas-pecas.php">Minhas peças</a></li> 
              </ul>
            </nav>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- mobile-menu-area end --> 
</header>
