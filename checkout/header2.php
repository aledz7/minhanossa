<?php require_once('Connections/conexao.php'); 

@session_start();

mysql_select_db($database_conexao, $conexao);
$query_rs_dados_header = "SELECT * FROM tbl_dados_cadastrais WHERE id = 1";
$rs_dados_header = mysql_query($query_rs_dados_header, $conexao) or die(mysql_error());
$row_rs_dados_header = mysql_fetch_assoc($rs_dados_header);
$totalRows_rs_dados_header = mysql_num_rows($rs_dados_header);

mysql_select_db($database_conexao, $conexao);
$query_rs_menu_categoria_header = "SELECT * FROM tbl_categorias ORDER BY id ASC LIMIT 0,6";
$rs_menu_categoria_header = mysql_query($query_rs_menu_categoria_header, $conexao) or die(mysql_error());
$row_rs_menu_categoria_header = mysql_fetch_assoc($rs_menu_categoria_header);
$totalRows_rs_menu_categoria_header = mysql_num_rows($rs_menu_categoria_header);

mysql_select_db($database_conexao, $conexao);
$query_rs_categoria_header = "SELECT * FROM tbl_categorias ORDER BY id ASC";
$rs_categoria_header = mysql_query($query_rs_categoria_header, $conexao) or die(mysql_error());
$row_rs_categoria_header = mysql_fetch_assoc($rs_categoria_header);
$totalRows_rs_categoria_header = mysql_num_rows($rs_categoria_header);

$_SESSION['MM_Username'] = '';
?>
<header class="header_area">
            <div class="top-link">
                <div class="container">
                    <div class="row">


                        <div class="col-sm-5 text-left links-center">
                            <div class="content_right">
                                <div class="call_us">
                                
                                    <p>
                                        <i class="fa fa-phone"></i>
                                        Entre em Contato:
                                        <span> &nbsp;<?php echo $row_rs_dados_header['telefone'] ?></span>
                                                    &nbsp;&nbsp;
                                        <i class="fa fa-skype"></i>
                                        Estamos:
                                        <span> &nbsp;Online</span>                                        
                                    </p>

                                </div>
                            </div>
                        </div>


                        <div class="col-md-7">
                            <div class="english">
                                <ul>
                                    <li>
                                      <a href="#">
                                       <i class="fa fa-headphones"></i>&nbsp;SAC
                                      </a>
                                     </li>
                                     <?php if($_SESSION['MM_Username'] <> '') { ?>
                                     <li>
                                      <a href="#">
                                       <i class="fa fa-user"></i>&nbsp;MINHA CONTA
                                      </a>
                                     </li>
                                     <?php } else { ?>
                                     <li>
                                      <a href="#">
                                       <i class="fa fa-user"></i>&nbsp;LOGIN | CADASTRE-SE
                                      </a>
                                     </li>
                                     <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="header">
                <div class="container">
                    <div class="row">
                       <div class="col-md-2">
                                <a href="#"><img src="img/bio-logo.png" alt=""></a>
                            </div>
                        <div class="col-md-10">
                         
                            <div class="home_menu">
                                <nav>
                                    <ul>
                                        <li class="active1"><a href="#">Home</a></li>
                                        <li><a href="#">Produtos Veterinários</a></li>
                                        <li><a href="#">Fazenda</a></li>
                                        <li class="active1"><a href="#">Casa & Jardim</a></li>
                                        <li><a href="#">Pet Caes & Gatos</a></li>
                                        <li><a href="#">Pragas Urbanas</a></li>
                                        <li><a href="#">Selaria & Montaria</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="top-menu">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-3 col-md-4 col-sm-5">
                            <div class="left-category-menu hidden-xs">
                                <div class="left-product-cat">
                                    <div class="category-heading">
                                        <h2>Leia nosso Blog</h2>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-8 col-sm-7 col-xs-12">
                            <div class="site_bar">
                                <form action="resultado-busca.php" id="search_mini_form">
                                    <div class="form-search">
                                        <?php /*?><div class="select-wrapper">
                                            <select class="select" name="categoria" id="categoria">
                                             <option value="">Categorias</option>
                                              <?php do { ?>
                                              <option value="<?php echo $row_rs_categoria_header['id'] ?>">
                                               <?php echo $row_rs_categoria_header['name'] ?>
                                              </option>
                                              <?php } while($row_rs_categoria_header = mysql_fetch_assoc($rs_categoria_header)); ?>
                                              </select>
                                        </div><?php */?>
                                        <input class="input-text" type="text" id="txtProduto" name="txtProduto" placeholder="O que Você Precisa?">
                                        <button class="button" title="Search" type="submit">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </form>
                                <div class="top-cart-wrapper">
                                    <div class="top-cart-contain">
                                        <div class="block-cart">
                                            <div class="top-cart-title">
                                                <div class="my-cart">Meu Carrinho</div>
                                                <a href="#"><p>(2) item:<span>$100.00</span></p></a>
                                            </div>
                                            <div class="home">
                                                
                                            </div>

                                        </div>
                                    </div>
                                </div>
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
                                        <li><a href="#">Home</a></li>
                                        <li><a href="#">Minha Conta</a></li>
                                        <li><a href="#">Produtos Veterinários</a></li>
                                        <li><a href="#">Fazenda</a></li>
                                        <li><a href="#">Casa & Jardim</a></li>
                                        <li><a href="#">Pet Caes & Gatos</a></li>
                                        <li><a href="#">Pragas Urbanas</a></li>
                                        <li><a href="#">Selaria & Montaria</a></li>
                                    </ul>
                                </nav>
                            </div>					
                        </div>
                    </div>
                </div>
            </div>
            <!-- mobile-menu-area end -->
        </header>