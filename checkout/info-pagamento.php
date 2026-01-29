<?php require_once('Connections/conexao.php'); ?>
<? @session_start();

include('funcoes.php');

if($_POST[acao] == 'continuar_compra') {
	$_SESSION[compra] = $_POST[id_compra];
	$_SESSION[total_frete] = $_POST[valor_frete];
	$_SESSION[forma_envio] = $_POST[tipo_frete];
	
	echo "	<script>
			window.location='info-pagamento.php'
			</script>";
			exit;
}

mysql_select_db($database_conexao, $conexao);
$query_rs_endereco = "SELECT *, tbl_endereco.id as idEnde, dados_estados.nome as nomeEstado, dados_cidades.nome as nomeCidade FROM tbl_endereco left join dados_estados on tbl_endereco.estado = dados_estados.id left join dados_cidades on tbl_endereco.cidade = dados_cidades.id where tbl_endereco.id = '$_GET[id]' ORDER BY tbl_endereco.id DESC";
$rs_endereco = mysql_query($query_rs_endereco, $conexao) or die(mysql_error());
$row_rs_endereco = mysql_fetch_assoc($rs_endereco);
$totalRows_rs_endereco = mysql_num_rows($rs_endereco);

$_SESSION['id_endereco'] = $row_rs_endereco[idEnde];

if($_SESSION[compra] <> '' and $totalRows_rs_endereco > 0){
	
	$updateSQL = "UPDATE tbl_compras SET id_endereco='$row_rs_endereco[idEnde]' WHERE id='$_SESSION[compra]'";
	mysql_select_db($database_conexao, $conexao);
    $Result1 = mysql_query($updateSQL, $conexao) or die(mysql_error());	
}

$colname_rs_user = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_rs_user = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_conexao, $conexao);
$query_rs_user = sprintf("SELECT * FROM tbl_users WHERE email = '%s'", $colname_rs_user);
$rs_user = mysql_query($query_rs_user, $conexao) or die(mysql_error());
$row_rs_user = mysql_fetch_assoc($rs_user);
$totalRows_rs_user = mysql_num_rows($rs_user);



if($_SESSION[compra] <> '') {
	$updateSQL = "UPDATE tbl_compras SET id_cliente='$row_rs_user[id]' WHERE id='$_SESSION[compra]'";
  mysql_select_db($database_conexao, $conexao);
  $Result1 = mysql_query($updateSQL, $conexao) or die(mysql_error());

}

mysql_select_db($database_conexao, $conexao);
$query_rs_deposito = "SELECT * FROM tbl_pagamento_deposito_transferencia";
$rs_deposito = mysql_query($query_rs_deposito, $conexao) or die(mysql_error());
$row_rs_deposito = mysql_fetch_assoc($rs_deposito);
$totalRows_rs_deposito = mysql_num_rows($rs_deposito);

/// VERIFICA ESTADO
mysql_select_db($database_conexao, $conexao);
$query_rs_estado = "SELECT * FROM dados_estados WHERE id = '$row_rs_user[estado]'";
$rs_estado = mysql_query($query_rs_estado, $conexao) or die(mysql_error());
$row_rs_estado = mysql_fetch_assoc($rs_estado);
$totalRows_rs_estado = mysql_num_rows($rs_estado);

mysql_select_db($database_conexao, $conexao);
$query_rs_faturamento = "SELECT * FROM tbl_config";
$rs_faturamento = mysql_query($query_rs_faturamento, $conexao) or die(mysql_error());
$row_rs_faturamento = mysql_fetch_assoc($rs_faturamento);
$totalRows_rs_faturamento = mysql_num_rows($rs_faturamento);


// verifica login
if($row_rs_user['email'] == '') {
	echo '<script>';
	echo "window.location='login.php?volta=info-pagamento.php'";
	echo "</script>";
	exit;
}
	  

/// verifica endereço
if($row_rs_user['endereco'] == '' or $row_rs_user['id_cidade'] == '') {
	echo "	<script>
			alert('Por favor, complete seu endereço para efetuar um pedido em nossa loja.');
			window.location='mudar-endereco.php';
			</script>";
			exit; }
?>
<!DOCTYPE html>
<html lang="en" class="no-js">
   <? include('head.php'); ?>
    <body>
        <!-- Header-->
        <? include('header.php');?>
        <!-- End header -->

        <!-- ===========================================
        =====        Login page header section               ====
        ============================================ -->
        <section>
            <div class="top-header-m-bg dark"></div>
        </section>

        <section>
         <div class="block2">
          <div class="container">
           <div class="row">
            <div class="col-md-12 " style="margin-top:30px;">
             <div class="block-form box-border wow fadeInLeft" data-wow-duration="1s">
              <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
			   <tr> 
                <td width="95%">
                 <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:10px;">
                  <tr>
                   <td width="50%" height="32" style="background:url(images/categorias_loja.gif); background-repeat:no-repeat;">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                     <span>
                      <b>Dados de Entrega e Pagamento</b>
                     </span>
                    </td>
                    <td width="50%" style="background:url(images/categorias_loja-fundo.gif);">&nbsp;
                     
                    </td>
                   </tr>
                  </table>
                 </td>
                </tr>
                <tr> 
                 <td valign="top" bgcolor="<? echo $fundo_meio; ?>">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                   <tr> 
                    <td>
                     <form id="form2" name="form2" method="post" action="confirmacao.php">
                      <table width="100%" cellpadding="0" cellspacing="0">
                       <tr> 
                        <td>
                         <div align="left">
                          <table cellspacing="0" cellpadding="2" width="100%" border="0">
                           <tbody>
                            <tr> 
                             <td>
                              <b>Endere&ccedil;o de entrega</b>
                             </td>
                            </tr>
                           </tbody>
                          </table>
                         </div>
                        </td>
                       </tr>
                       <tr> 
                        <td>
                         <div align="left">
                          <table width="100%" border="0" cellpadding="2" cellspacing="1" class="SB_Style_design_logo">
                            <tbody>
                              <tr> 
                                <td>
                                 <table cellspacing="0" cellpadding="2" width="100%" border="0">
                                  <tbody>
                                   <tr> 
                                    <td width="3%">&nbsp;</td>
                                    <td valign="top" width="47%">
                                     <table style="margin-top:7px;" width="80%" border="0" cellspacing="0" cellpadding="0">
                                      <tr>
                                       <td>
                                        <div align="center">
                                         <span class="texto_detalhes">Caso 
                                            queira alterar o endere&ccedil;o da 
                                            entrega do produto, basta clicar no bot&atilde;o logo abaixo
                                          </span>
                                          <br />
                                          <a href="area-cliente.php?acao=endEntrega"><br />
                                          <input name="endereco" class="style_bt_vermelho" type="button" value="Selecionar endereço de entrega" />
                                          </a> 
                                         </div>
                                        </td>
                                       </tr>
                                      </table>
                                     </td>
                                     <td valign="top" align="right" width="50%"><table width="100%" border="0" align="left" cellpadding="2" cellspacing="0">
                                      <tbody>
                                       <tr> 
                                        <td width="71" align="middle" valign="top">
                                         <div align="center">
                                          <strong class="texto_menus">&nbsp;
                                           <span class="style7">
                                            Endere&ccedil;o de entrega:
                                           </span>
                                          </strong>
                                          <br />
                                          <img height="31" alt="" src="img/arrow_south_east.gif" width="50" border="0" class="top-img"/>
                                         </div>
                                        </td>
                                        <td width="373" valign="top" class="valor">
                                         <? if($totalRows_rs_endereco > 0){?>
                                         <div align="right" class="texto_nav style2">
                                          <strong>
										   <?php echo $row_rs_user['nome']; ?> 
                                           <?php echo $row_rs_user['sobrenome']; ?><br /> 
                                           <?php echo $row_rs_endereco['endereco']; ?> 
                                           <?php echo $row_rs_endereco['bairro']; ?><br /> 
                                           <?php echo $row_rs_endereco['nomeCidade']; ?> - 
                                           <?php echo $row_rs_endereco['cep']; ?><br /> 
                                           <?php echo $row_rs_endereco['nomeEstado']; ?>, 
                                           <?php echo $row_rs_user['pais']; ?></strong></div>
                                               
                                         <? }else{ ?>    
                                         <div align="right" class="texto_nav style2">
                                          <strong>
										   <?php echo $row_rs_user['nome']; ?>                        
										   <?php echo $row_rs_user['sobrenome']; ?><br /> 
                                           <?php echo $row_rs_user['endereco']; ?> 
                                           <?php echo $row_rs_user['complemento']; ?><br /> 
                                           <?php echo $row_rs_user['bairro']; ?><br /> 
                                           <?php echo $row_rs_user['cidade']; ?>, 
                                           <?php echo $row_rs_user['cep']; ?><br /> 
                                           <?php echo $row_rs_estado['nome']; ?>, 
                                           <?php echo $row_rs_user['pais']; ?>
                                          </strong>
                                         </div>
                                               
                                       <? } ?>
                                      </td>
                                     </tr>
                                     <tr>
                                      <td align="middle" valign="top">&nbsp;</td>
                                      <td valign="top" class="valor">&nbsp;</td>
                                     </tr>
                                    </tbody>
                                   </table>
                                  </td>
                                 </tr>
                                </tbody>
                               </table>
                              </td>
                             </tr>
                            </tbody>
                           </table>
                          </div>
                         </td>
                        </tr>
                        <tr> 
                        <td>
                         <div align="left">
                          <hr>
                         </div>
                        </td>
                       </tr>
                       <tr> 
                        <td><div align="left">
                          <table cellspacing="0" cellpadding="2" width="95%" border="0">
                            <tbody>
                              <tr> 
                                <td style="padding-top:3px; padding-left:2px; padding-bottom:3px;">
                                 <b>M&eacute;todos de pagamento</b>
                               </td>
                              </tr>
                              </tbody>
                          </table>
                        </div></td>
                      </tr>
                      <tr> 
                        <td><div align="left">
                          <table cellspacing="0" cellpadding="2" width="100%" border="0">
                            <tbody>
                              <tr> 
                                <td><hr style="margin-bottom:10px;">
                                <table width="100%" border="0" class="SB_Style_design_logo">
                                  <tbody>                                                             
                                  
                                  <tr id="defaultSelected">
                                   <td width="17%" bgcolor="#F3F3F3" class="texto_detalhes">
                                    <div align="center">
                                     <span style="padding:5px;">
                                      <img src="img/pagseguro.jpg"  class="ico-pagseguro"/>
                                     </span>
                                    </div>
                                   </td> 
                                   <hr>
                                   <td width="81%" style="padding:3px;" bgcolor="#F3F3F3" class="texto_detalhes">
                                    <span style="padding:5px;">
                                    A forma mais segura de comprar.<br/>
                                    Compre com tranquilidade, se tiver algum imprevisto com sua compra,
                                    o PagSeguro pode te ajudar a resolver.
                                    </span>
                                   </td>
                                   <td width="2%" align="center" bgcolor="#F3F3F3">
                                    <input name="pagamento" type="radio" value="pagseguro" checked />
                                   </td>
                                  </tr>
                              
                                    
                                    

                                    <?php if($row_rs_faturamento['faturamento_S_ou_N'] == "S") { ?>
                                    <tr>
                                      <td style="padding:5px;" align="center" bgcolor="#F3F3F3"><img src="img/faturamento.gif" width="82" height="99" /></td>
                                      <td style="padding-left:5px;" align="left" bgcolor="#F3F3F3" class="texto_nav">Faturamento.<br />
                                      Pedido ser&aacute; analizado pela nossa equipe antes da libera&ccedil;&atilde;o.</td>
                                      <td align="center" bgcolor="#F3F3F3"><input name="pagamento" type="radio" value="Faturamento" /></td>
                                    </tr>
                                    <? } ?>
                                  </tbody>
                                </table></td>
                              </tr>
                              </tbody>
                          </table>
                        </div></td>
                      </tr>
                      <tr> 
                        <td class="style16 style17"><div align="left">
                          <hr>
                        </div></td>
                      </tr>
                      <tr> 
                        <td><div align="left">
                          <table width="100%" border="0" cellpadding="2" cellspacing="1" class="SB_Style_design_logo">
                            <tbody>
                              <tr> 
                                <td><table cellspacing="0" style="padding-top:10px;" cellpadding="2" width="100%" border="0">
                                  <tbody>
                                    <tr> 
                                      <td width="19">&nbsp;</td>
                                      <td width="425"><strong class="texto_preco style1">Continuar 
                                        o pedido</strong><br /> 
                                            <span class="texto_detalhes">Para 
                                      confirmar o seu pedido, clique em Continuar.</span></td>
                                      <td width="450" align="right"><div align="right">
                                        <input name="image" type="submit" title=" Continuar " value="Continuar" alt="Continuar" border="0" />
                                    </div></td>
                                    </tr>
                                  </tbody>
                                  </table></td>
                              </tr>
                              </tbody>
                          </table>
                        </div></td>
                      </tr>
                      <tr> 
                        <td><div align="left"></div></td>
                      </tr>
                    </table>
                  </form></td>
              </tr>
            </table></td>
        </tr>
        <tr> 
          <td>&nbsp;</td>
        </tr>
      </table>
                                
                                
                              
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===========================================
        =====        footer section               ====
        ============================================ -->        
        <? include('footer.php');?>
        <!-- End Section footer -->
        <script src="js/vendor/jquery.js"></script>
        <script src="js/vendor/jquery.easing.1.3.js"></script>
        <script src="js/vendor/bootstrap.js"></script>

        <script src="js/vendor/jquery.flexisel.js"></script>
        <script src="js/vendor/wow.min.js"></script>
        <script src="js/vendor/jquery.transit.js"></script>
        <script src="js/vendor/jquery.jcountdown.js"></script>
        <script src="js/vendor/jquery.appear.js"></script>        <script src="js/vendor/owl.carousel.js"></script>
        <script src="js/vendor/jquery.ticker.js"></script>

        <script src="js/vendor/responsiveslides.min.js"></script>
        <script src="js/vendor/jquery.elevateZoom-3.0.8.min.js"></script>
        <script src="js/vendor/jquery-ui.js"></script>
        <!-- jQuery REVOLUTION Slider  -->
        <script type="text/javascript" src="js/vendor/jquery.themepunch.plugins.min.js"></script>
        <script type="text/javascript" src="js/vendor/jquery.themepunch.revolution.min.js"></script>
        <script type="text/javascript" src="js/vendor/jquery.scrollTo-1.4.2-min.js"></script>

        <!-- Custome Slider  -->
        <script src="js/main.js"></script>

        <!--Here will be Google Analytics code from BoilerPlate-->
    </body>
</html>