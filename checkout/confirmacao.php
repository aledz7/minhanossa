<?php 
session_start();

include('Connections/conexao.php'); 
include('funcoes.php');

include('../class/info-site.php');
$infoSite = InfoSite::getInstance(Conexao::getInstance())->rsDados();

unset($total_prods);
unset($desconto);

if($_POST["pagamento"]) {
	$forma_pagamento = $_POST["pagamento"];
	$_SESSION['pagamento'] = $forma_pagamento;
		echo "	<script>
				alert('Compra confirmada com sucesso. Favor, verifique no seu email os dados completos!');
				window.location='confirmacao.php'
				</script>";
} /// FIM PAGAMENTO


$colname_rs_cliente = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_rs_cliente = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}

mysql_select_db($database_conexao, $conexao);
$query_rs_cliente = sprintf("SELECT * FROM tbl_users WHERE email = '%s'", $colname_rs_cliente);
$rs_cliente = mysql_query($query_rs_cliente, $conexao) or die(mysql_error());
$row_rs_cliente = mysql_fetch_assoc($rs_cliente);
$totalRows_rs_cliente = mysql_num_rows($rs_cliente);

//// PEGA ESTADO QUE O CLIENTE ESTÁ CADASTRADO.
mysql_select_db($database_conexao, $conexao);
$query_rs_estado = "SELECT * FROM dados_estados WHERE id = '$row_rs_cliente[estado]'";
$rs_estado = mysql_query($query_rs_estado, $conexao) or die(mysql_error());
$row_rs_estado = mysql_fetch_assoc($rs_estado);
$totalRows_rs_estado = mysql_num_rows($rs_estado);
$estado = $row_rs_estado['uf'];



mysql_select_db($database_conexao, $conexao);
$query_rs_banco = "SELECT * FROM tbl_pagamento_deposito_transferencia";
$rs_banco = mysql_query($query_rs_banco, $conexao) or die(mysql_error());
$row_rs_banco = mysql_fetch_assoc($rs_banco);
$totalRows_rs_banco = mysql_num_rows($rs_banco);

mysql_select_db($database_conexao, $conexao);
$query_rs_config = "SELECT * FROM tbl_config";
$rs_config = mysql_query($query_rs_config, $conexao) or die(mysql_error());
$row_rs_config = mysql_fetch_assoc($rs_config);
$totalRows_rs_config = mysql_num_rows($rs_config);

$colname_rs_pedidos = "-1";
if (isset($_SESSION['compra'])) {
  $colname_rs_pedidos = $_SESSION['compra'];
}
mysql_select_db($database_conexao, $conexao);
$query_rs_pedidos = sprintf("SELECT * FROM tbl_pedidos_por_id_compra WHERE id_compra = %s", GetSQLValueString($colname_rs_pedidos, "int"));
$rs_pedidos = mysql_query($query_rs_pedidos, $conexao) or die(mysql_error());
$row_rs_pedidos = mysql_fetch_assoc($rs_pedidos);
$totalRows_rs_pedidos = mysql_num_rows($rs_pedidos);

if($row_rs_cliente['nome'] == '') {
	  echo '<script language="javascript">';
      echo 'alert("Acesso incorreto.");';
      echo 'window.location = "login.php";';
	  echo '</script>';
	  exit; }


///////////////// ENVIA TUDO PARA O CLIENTE ///////////////
mysql_select_db($database_conexao, $conexao);

$query_rs_dados_compra = "SELECT tbl_compras.*, tbl_status.status as status FROM tbl_compras left join tbl_status on tbl_compras.status = tbl_status.id WHERE tbl_compras.id = '$_SESSION[compra]'";
$rs_dados_compra = mysql_query($query_rs_dados_compra, $conexao) or die(mysql_error());
$row_rs_dados_compra = mysql_fetch_assoc($rs_dados_compra);
$totalRows_rs_dados_compra = mysql_num_rows($rs_dados_compra);

if($_SESSION['id_endereco'] <> ''){
	
mysql_select_db($database_conexao, $conexao);
$query_rs_endereco = "SELECT * FROM tbl_endereco where id = '".$_SESSION['id_endereco']."'";
$rs_endereco = mysql_query($query_rs_endereco, $conexao) or die(mysql_error());
$row_rs_endereco = mysql_fetch_assoc($rs_endereco);
$totalRows_rs_endereco = mysql_num_rows($rs_endereco);
	
	}
mysql_select_db($database_conexao, $conexao);
$query_rs_email = "SELECT 
tbl_pedidos_por_id_compra.*,
tbl_compras.*,
tbl_produtos.id,
tbl_produtos.nome,
tbl_produtos.preco_por
 FROM 
tbl_pedidos_por_id_compra 
 LEFT JOIN
tbl_compras ON tbl_pedidos_por_id_compra.id_compra = tbl_compras.id
 LEFT JOIN
tbl_produtos ON tbl_produtos.id = tbl_pedidos_por_id_compra.produto 
 WHERE 
  tbl_pedidos_por_id_compra.id_compra = '".$_SESSION['compra']."'";
$rs_email = mysql_query($query_rs_email, $conexao) or die(mysql_error());
$row_rs_email = mysql_fetch_assoc($rs_email);
$totalRows_rs_email = mysql_num_rows($rs_email);

    $mensagem = "<b>NOVO PEDIDO FEITO ATRAVÉS DO SITE {$infoSite->nome}</b> <br /> <br />";
	$mensagem.= "NOVO PEDIDO ATRAVÉS DO SITE: <br />";
	$mensagem.= "<b>Produto:</b> ".$row_rs_email['nome']." <br />";
	$mensagem.= "<b>Valor Produto:</b> R$".number_format($row_rs_email['preco_por'],2,',','.')." <br />";
	$mensagem.= "<b>Valor Total:</b> R$".number_format($row_rs_email['subtotal'],2,',','.')." <br />";
	$mensagem.= "<b>Endereco de Entrega:</b><br/> ";
	$mensagem.= "<b>Cidade:</b><br/> ".$row_rs_endereco['cidade']." <br />";
	$mensagem.= "<b>Bairro:</b><br/> ".$row_rs_endereco['bairro']." <br />";
	$mensagem.= "<b>Endereço:</b><br/> ".$row_rs_endereco['endereco']." <br />";
	$mensagem.= "<b>CEP:</b><br/> ".$row_rs_endereco['cep']." <br />";
	$mensagem.= "<b>Celular:</b><br/> ".$row_rs_endereco['tel_celular']." <br />";
 if($row_rs_email['mensagem'] <> ''){
	$mensagem.= "<b>Dedicatória:</b><br/>";
    $mensagem.= "<b>De:</b><br/> ".$row_rs_email['remetente']." <br />";
	$mensagem.= "<b>Para:</b><br/> ".$row_rs_email['destinatario']." <br />";
	$mensagem.= "<b>Mensagem:</b><br/> ".$row_rs_email['mensagem']." <br />";
 }
	
	EnviarEmail('Contato via site', $infoSite->nome, $infoSite->email, $infoSite->email, $infoSite->email, $mensagem);

?>
<!DOCTYPE html>
<html lang="en" class="no-js">
   <? include('head.php'); ?>
    <body>
        <!-- Header-->
        <? include('header.php');?>
        <!-- End header -->
                
        <section>
            <div class="block2">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 ">
                            <div class="block-form box-border wow fadeInLeft animated" data-wow-duration="1s">
                              <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:10px;">
                               <tr>
                                <td width="47%" height="32" style="background:url(img/categorias_loja.gif); background-repeat:no-repeat;">
                                 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                  <span class="titulo_verde">
                                   <h4><strong>Confirma&ccedil;&atilde;o de Pedido - <?=$_SESSION[compra];?></strong></h4>
                                  </span>
                                 </td>
    <td width="53%" style="background:url(img/categorias_loja-fundo.gif);">&nbsp;</td>
  </tr>
</table>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
  <td width="95%" valign="top" bgcolor="<? echo $fundo_meio; ?>"><table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><table width="100%" cellpadding="0" cellspacing="0">
        <tr>
          <td ><table width="99%" border="0" cellpadding="2" cellspacing="1">
            <tbody>
              <tr>
                <td valign="top" width="100%"><table 
      width="100%" border=1 cellpadding=2 cellspacing=0  bordercolor=#eeeeee class="texto_preto">
                  <tbody>
                    <tr style="FONT-WEIGHT: bold; BACKGROUND-COLOR: whitesmoke" 
        valign=center>
                      <td width="65%" 
          nowrap style="CURSOR: hand; padding:3px;"><b>Produtos solicitados</b></td>
                      <td width="15%" 
          nowrap style="CURSOR: hand"><div align="center">Pre&ccedil;o R$</div></td>
                      <td width="7%" align="center" 
          nowrap style="CURSOR: hand">Qtd.</td>
                      <td width="13%"><div align="center">Total R$</div></td>
                      </tr>
                    </tbody>
                  </table>
                  <?php do { ?>
                    <?
$id_prod = $row_rs_pedidos['produto'];

mysql_select_db($database_conexao, $conexao);
$query_rs_dados_produto = "SELECT * FROM tbl_produtos WHERE id = '$id_prod'";
$rs_dados_produto = mysql_query($query_rs_dados_produto, $conexao) or die(mysql_error());
$row_rs_dados_produto = mysql_fetch_assoc($rs_dados_produto);
$totalRows_rs_dados_produto = mysql_num_rows($rs_dados_produto);

$produtos_nomes .= $row_rs_dados_produto['nome'].', ';

?>
                    <table 
      width="100%" border=1 cellpadding=2 cellspacing=0  bordercolor=#eeeeee class="texto_preto">
                      <tbody>
                        <form name="form1" id="form1">
                          <tr class=exibe_registros 
        onMouseOver="this.style.backgroundColor='whitesmoke';" 
        onMouseOut="this.style.backgroundColor='';">
                            <td width="65%"  style="padding:3px;"><span class="style15"><strong><?php echo $row_rs_dados_produto['nome']; if($row_rs_pedidos['variacao'] <> '') { echo " ($row_rs_pedidos[variacao])"; }?></strong></span></td>
                            <td width="15%"><div align="center" class="arial_12_cinza style12 style15">
                              <?php
	  echo number_format($row_rs_pedidos['valor_c_acrecimo'],2,',','.');
      $total = $row_rs_pedidos['valor_c_acrecimo']*$row_rs_pedidos['qtd'];
      $total_prods = $total+$total_prods; ?>
                              </div></td>
                            <td width="7%" align="center"><?=$row_rs_pedidos['qtd'];?></td>
                            <td width="13%"><div align="center" class="style15"><strong>
                              <?=number_format($total,2,',','.');?>
                              </strong></div></td>
                            </tr>
                          </form>
                      </table>
                    <?php } while ($row_rs_pedidos = mysql_fetch_assoc($rs_pedidos)); ?></td>
                </tr>
              </tbody>
            </table></td>
          </tr>
        <tr>
          <td><hr style="margin-bottom:7px; margin-top:7px;"></td>
          </tr>
        <tr class="SB_Style_design_logo">
          <td height="20"><table width="100%" border="0" cellpadding="2" cellspacing="1" class="SB_Style_design_logo">
            <tbody>
              <tr>
                <td valign="top" width="37%"><table cellspacing="0" cellpadding="2" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td><div align="left"><strong class="texto_preto">Informa&ccedil;&otilde;es de pagamento</strong></div></td>
                      </tr>
                    <tr>
                      <td ><div align="left" class="texto_nav style12"><? echo $_SESSION['pagamento'];?></div><br/>
                      <? if(substr($_SESSION['pagamento'],0,8) == 'Depósito'){?>
                      Dep&oacute;sito banc&aacute;rio tem 5% de desconto no produto!
                      <? }?>
                      </td>
                      </tr>
                    </tbody>
                  </table></td>
                <td valign="top" align="right" width="63%"><table width="100%" border="0">
                  <tbody>
                  
                    <tr>
                      <td width="91%" align="right" class="texto_nav style13"><div align="right"><strong>Total - Produtos:&nbsp;</strong></div></td>
                      <td width="9%" nowrap class="texto_nav">R$
                        <?=number_format($total_prods,2,',','.');?>
                        </td>
                      </tr>
                      
                      
                      <tr>
                      <td width="91%" align="right" class="texto_nav style13"><div align="right"><strong>Total Frete:&nbsp;</strong></div></td>
                      <td width="9%" nowrap class="texto_nav">R$
                        <?=number_format(valorCalculavel($_SESSION[total_frete]),2,',','.');?></td>
                      </tr>
                      
                      <?php      /// calcula desconto
if($_SESSION[tipoDesconto] == 'valor') {
	$desconto = number_format($_SESSION[desconto],2,',','.'); 
} else { 
	$desconto = number_format($total_prods/100*$_SESSION[desconto],2,',','.'); 
}

if($row_rs_dados_compra['desconto'] <> '' and $row_rs_dados_compra['desconto'] <> 0) {
	$desconto = $row_rs_dados_compra['desconto'];
}
 ?>
                      <?php if($row_rs_config['vale_desconto'] == 'S') { ?>
                    <tr>
                      <td align="right" class="style13 texto_nav"><strong>Desconto</strong>:&nbsp;</td>
                      <td align="left" nowrap class="texto_nav">R$ <?=$desconto;?></td>
                    </tr>
                    <?php } ?>
                   <?php /*?> <? if(substr($_SESSION['pagamento'],0,8) == 'Depósito'){?>
                    <? $porcentagem = 5 /100;
						$valorTotal2 = $total_prods - ($porcentagem*$total_prods);
					?>
                    <tr>
                      <td align="right" class="style13 texto_nav"><strong>Total:</strong></td>
                      <td nowrap class="texto_nav">R$
                        <?=number_format(($_SESSION[total_frete]+$valorTotal2)-valorCalculavel($desconto),2,',','.');?></td>
                      </tr>
					<? }else{?><?php */?>
                    
                    <tr>
                      <td align="right" class="style13 texto_nav"><strong>Total:&nbsp;</strong></td>
                      <td nowrap class="texto_nav">R$
                        <?=number_format((valorCalculavel($_SESSION[total_frete])+$total_prods)-valorCalculavel($desconto),2,',','.');?></td>
                      </tr>
                      <? // }?>
                    </tbody>
                  </table></td>
                </tr>
              </tbody>
            </table></td>
          </tr>
        <tr>
          <td class="style2">&nbsp;</td>
          </tr>
        <tr>
          <td><table width="100%" border="0" align="right" cellpadding="0" cellspacing="0">
            <tbody>
              <tr>
                <td><table width="100%" border="0" cellpadding="2" cellspacing="0" class="SB_Style_design_logo">
                  <tbody>
                    <tr>
                      <td colspan="4"><div align="center" class="texto_preto"><span class="texto_nav style11">Seu 
                        pedido ser&aacute; enviado quando confirmado 
                        o pagamento. Para agilizar o processo, 
                        envie o comprovante por email: <a href="mailto:<?=$infoSite->email;?>" >
                          <?=$infoSite->email;?>
                          </a> ou ligue: <?php echo $infoSite->telefone; ?>  </span><br />
                        </div>
                        <hr style="margin-bottom:7px; margin-top:7px;">                        <div align="left"><strong class="texto_preto">Dados para  
                          pagamento: </strong></div></td>
                      </tr>
                    <tr>
                      <td colspan="4" class="texto_preco style14">


<?php  
if($_SESSION['pagamento'] == 'pagseguro') { 
	$produtos_id = $row_rs_dados_compra['id'];
	include('pagseguro.php'); 
} 

include('pay-pal.php');
include('boleto.php');

mysql_select_db($database_conexao, $conexao);
$query_rs_forma_pagamento = "SELECT * FROM tbl_pagamento_deposito_transferencia";
$rs_forma_pagamento = mysql_query($query_rs_forma_pagamento, $conexao) or die(mysql_error());
$row_rs_forma_pagamento = mysql_fetch_assoc($rs_forma_pagamento);
$totalRows_rs_forma_pagamento = mysql_num_rows($rs_forma_pagamento);

$pag = substr($_SESSION['pagamento'],0,8);

if($_SESSION['pagamento'] == 'Banco do Brasil') {
	$forma_de_pagamento = "<style type='text/css'>
	<!--
	.style26 {
		font-family: Arial, Helvetica, sans-serif;
		font-weight: bold;
		font-size: 12px;
		color: #000000;
	}
	.style27 {
		font-family: Arial, Helvetica, sans-serif;
		font-size: 12px;
		color: #000000;
	}
	-->
	</style>
	<table width='100%' border='0'>
	  <tr>
		<td colspan='2'><span class='style26'>Banco do Brasil</span></td>
	  </tr>
	  <tr>
		<td width='6%' nowrap><div align='right' class='style26'>Ag&ecirc;ncia:&nbsp;</div></td>
		<td width='94%' class='style27'>36056</td>
	  </tr>
	  <tr>
		<td nowrap class='style26'><div align='right'>Conta corrente:&nbsp;</div></td>
		<td class='style27'>83305</td>
	  </tr>
	  <tr>
		<td nowrap class='style26'><div align='right'>Cedente:&nbsp;</div></td>
		<td class='style27'>$row_rs_forma_pagamento[cedente]</td>
	  </tr>
	  <tr>
		<td nowrap class='style26'><div align='right'>Total a pagar:&nbsp;</div></td>
		<td class='style27'>R$ ".number_format(($_SESSION[total_frete]+$total_prods)-valorCalculavel($desconto),2,',','.')."</td>
	  </tr>
	</table>
	"; 
}
if(strpos($_SESSION['pagamento'], 'Caixa') == true) {

$forma_de_pagamento1 = "<style type='text/css'>
<!--
.style26 {
	font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
	font-size: 12px;
	color: #000000;
}
.style27 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000000;
}
-->
</style>
<table width='100%' border='0'>
  <tr>
    <td colspan='2'><span class='style26'>Caixa Econ&ocirc;mica Federal</span></td>
  </tr>
  <tr>
    <td width='6%' nowrap><div align='right' class='style26'>Ag&ecirc;ncia:</div></td>
    <td width='94%' class='style27'>$row_rs_forma_pagamento[agencia]</td>
  </tr>
  <tr>
    <td nowrap class='style26'><div align='right'>Conta corrente:</div></td>
    <td class='style27'>$row_rs_forma_pagamento[conta]</td>
  </tr>
  <tr>
    <td nowrap class='style26'><div align='right'>Cedente:</div></td>
    <td class='style27'>$row_rs_forma_pagamento[cedente]</td>
  </tr>
  <tr>
    <td nowrap class='style26'><div align='right'>Total a pagar:</div></td>
	<td class='style27'>R$ ".number_format(($row_rs_cidades[valor]+$total_prods)-valorCalculavel($desconto),2,',','.')."
	</td>
  </tr>
</table>
"; } else {
$forma_de_pagamento1 = "<div class='style26'>Aten&ccedil;&atilde;o:<br>
Entraremos em contato em breve para lhe enviar o seu pedido.</div>"; }

echo $forma_de_pagamento1; 

if($pag == 'Depósito' and !strpos($_SESSION['pagamento'], 'Caixa') == true) {

$forma_de_pagamento = "<style type='text/css'>
<!--
.style26 {
	font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
	font-size: 12px;
	color: #000000;
}
.style27 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000000;
}
-->
</style>
<table width='100%' border='0'>
  <tr>
    <td colspan='2'><span class='style26'>$row_rs_forma_pagamento[banco]</span></td>
  </tr>
  <tr>
    <td width='6%' nowrap><div align='right' class='style26'>Ag&ecirc;ncia:</div></td>
    <td width='94%' class='style27'>$row_rs_forma_pagamento[agencia]</td>
  </tr>
  <tr>
    <td nowrap class='style26'><div align='right'>Conta corrente:</div></td>
    <td class='style27'>$row_rs_forma_pagamento[conta]</td>
  </tr>
  <tr>
    <td nowrap class='style26'><div align='right'>Cedente:</div></td>
    <td class='style27'>$row_rs_forma_pagamento[cedente]</td>
  </tr>
  <tr>
    <td nowrap class='style26'><div align='right'>Total a pagar:</div></td>
	
    
	<td class='style27'>R$ ".number_format(($_SESSION[total_frete]+$valorTotal2)-valorCalculavel($desconto),2,',','.')."
	</td>
  </tr>
</table>
"; } /*else {
$forma_de_pagamento = "<div class='style26'>Aten&ccedil;&atilde;o:<br>
Entraremos em contato em breve para lhe enviar o seu $row_rs_dados_compra[formas_de_pagamento].</div>"; }*/

echo $forma_de_pagamento; ?>
</td>
                      </tr>
                    </tbody>
                  </table></td>
                </tr>
              </tbody>
            </table></td>
          </tr>
        <tr>
          <td><table cellspacing="0" cellpadding="0" width="100%" border="0">
            <tbody>
              <tr>
                <td colspan="2" align="right" class="style2"><hr style="margin-bottom:7px; margin-top:7px;"></td>
                </tr>
              <tr>
                <td width="35%" align="right"><div align="left">
                  <input name="Submit2" type="submit" class="form_campos3" onClick="MM_openBrWindow('confirmacao.php','confirmacao','scrollbars=yes,resizable=yes,width=520,height=430')" value=" Imprimir Confirma&ccedil;&atilde;o " style="cursor:pointer" />
                  
                  
                  
                  
                  </div></td>
                <td width="65%" align="right"><a href="resposta_confirmacao.php"><img src="img/bt_sair_senha.gif" width="58" height="20" border="0"></a></td>
                </tr>
              </tbody>
            </table></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
</tr>
<tr>
  <td height="18">&nbsp;</td>
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

<?php

/*mail("alessandro@dfinformatica.com.br","$assunto",$msg);
echo '>>'.$headers;

EnviarEmail($assunto, 'Ciclo Dandi', 'danilo@ciclodandi.com.br', 'alessandro@dfinformatica.com.br', 'danilo@ciclodandi.com.br', $msg);
echo '>>';
*/
///////////////////////////////////////////////////////////
if($_SESSION[compra] <> '' and $_SESSION[ok] <> 1) {

	$subtotal = $row_rs_cidades['valor']+$total_prods;
	
	$updateSQL = "UPDATE tbl_compras SET fechado='S', forma_de_envio='$_SESSION[forma_envio]', formas_de_pagamento='$_SESSION[pagamento]', subtotal='$subtotal', total_frete='$_SESSION[total_frete]', id_cliente='$row_rs_cliente[id]' WHERE id='$_SESSION[compra]'";
	mysql_select_db($database_conexao, $conexao);
	$Result1 = mysql_query($updateSQL, $conexao) or die(mysql_error());

	/// ALTERA ESTOQUE DOS PRODUTOS
	mysql_select_db($database_conexao, $conexao);
	$query_rs_pedidos_ESTOQUE = sprintf("SELECT * FROM tbl_pedidos_por_id_compra WHERE id_compra = '$_SESSION[compra]'", GetSQLValueString($colname_rs_pedidos_ESTOQUE, "int"));
	$rs_pedidos_ESTOQUE = mysql_query($query_rs_pedidos_ESTOQUE, $conexao) or die(mysql_error());
	$row_rs_pedidos_ESTOQUE = mysql_fetch_assoc($rs_pedidos_ESTOQUE);
	$totalRows_rs_pedidos_ESTOQUE = mysql_num_rows($rs_pedidos_ESTOQUE);

	// ELIMITA RECONTAGEM EM MAIS DE UM PRODUTO
	unset($estoque);

	do {
		/// VERIFICA QUAL É O PRODUTO
		mysql_select_db($database_conexao, $conexao);
		$query_rs_dados_produto = "SELECT * FROM tbl_produtos WHERE id = '$row_rs_pedidos_ESTOQUE[produto]'";
		$rs_dados_produto = mysql_query($query_rs_dados_produto, $conexao) or die(mysql_error());
		$row_rs_dados_produto = mysql_fetch_assoc($rs_dados_produto);
		$totalRows_rs_dados_produto = mysql_num_rows($rs_dados_produto);
		
		/// PEGA ESTOQUE - QUANTIDADE COMPRADA E JOGA NA VARIAVEL
		$estoque = $row_rs_dados_produto[estoque]-$row_rs_pedidos_ESTOQUE[qtd];
		
		// SQL ALTERANDO PRODUTOS
		$updateSQL = "UPDATE tbl_produtos SET estoque='$estoque' WHERE id='$row_rs_dados_produto[id]'";
		mysql_select_db($database_conexao, $conexao);
		$Result1 = mysql_query($updateSQL, $conexao) or die(mysql_error());
		
		/// FIM WHILE
	} while($row_rs_pedidos_ESTOQUE = mysql_fetch_assoc($rs_pedidos_ESTOQUE));
	//// ALTERAÇAO DE ESTOQUE
	/////////////////////////////////////////////////////////////////////////////////////////

	if(!$_SESSION[ok]) {
	$_SESSION[ok] = 1;
	echo "	<script>
			window.location='./confirmacao.php'
			</script>";

	$assunto = "Pedido No $_SESSION[compra] confirmado!";
	$mail = $row_rs_cliente['email'];
	$remetente = "$titulo <$infoSite->email>";
	$headers = "Content-Type: text/html; charset=iso-8859-1\n";  
	$headers.="From: $remetente\n"; 

	mysql_select_db($database_conexao, $conexao);
	$query_rs_pedidos = sprintf("SELECT * FROM tbl_pedidos_por_id_compra WHERE id_compra = '$_SESSION[compra]'", GetSQLValueString($colname_rs_pedidos, "int"));
	$rs_pedidos = mysql_query($query_rs_pedidos, $conexao) or die(mysql_error());
	$row_rs_pedidos = mysql_fetch_assoc($rs_pedidos);
	$totalRows_rs_pedidos = mysql_num_rows($rs_pedidos);

$subtotal = 0;

unset($total_prods);

do {
$id_prod = $row_rs_pedidos['produto'];

mysql_select_db($database_conexao, $conexao);
$query_rs_dados_produto = "SELECT * FROM tbl_produtos WHERE id = '$id_prod'";
$rs_dados_produto = mysql_query($query_rs_dados_produto, $conexao) or die(mysql_error());
$row_rs_dados_produto = mysql_fetch_assoc($rs_dados_produto);
$totalRows_rs_dados_produto = mysql_num_rows($rs_dados_produto);

$total = $row_rs_pedidos['valor_c_acrecimo']*$row_rs_pedidos['qtd'];
$total_prods = $total+$total_prods;
$qtds = $qtds+$row_rs_pedidos['qtd'];

unset($variacao);
if($row_rs_pedidos['variacao'] <> '') { $variacao = " ($row_rs_pedidos[variacao])"; }

///////// LAYOUT
$dados_pedidos .= "
	<TABLE  borderColor=#eeeeee cellSpacing=0 cellPadding=2 
      width='100%' border=1>
          <TBODY>
            <TR class=exibe_registros>
              <TD width='8%' class='style11'><div align='center'>$row_rs_pedidos[produto]</div></TD>
              <TD width='60%' class='style11'><div align='left'><a href='$endereco_virtual_loja/?pg=detalhes&id_produto=$row_rs_pedidos[produto]' class='style11'>$row_rs_dados_produto[nome] $variacao</a></div></TD>
              <TD width='7%' class='style11'><div align='center'>$row_rs_pedidos[qtd]</div></TD>
              <TD width='13%' class='style11'><div align='center'>R$: ".number_format($row_rs_pedidos[valor_c_acrecimo],2,',','.')."</div></TD>
              <TD width='12%'><div align='center' class='style11'>R$: ".number_format($total,2,',','.')."</div></TD>
            </TR>
        </TABLE>
";
} while ($row_rs_pedidos = mysql_fetch_assoc($rs_pedidos));

$pagamento = strpos($_SESSION['pagamento'], 'Caixa') == true ? $forma_de_pagamento1 : $forma_de_pagamento;

$msg = "<style type='text/css'>
<!--
.arial_12_vermelho {font-family: Arial; font-size: 12px; color: #FF0000; font-weight: bold; }
.style11 {FONT-SIZE: 12px; COLOR: #3e6497; FONT-FAMILY: Arial; font-weight: bold; }
.style15 {font-family: tahoma; font-size: 11px; color: #003366; font-weight: bold; }
.style16 {color: #000000}
.style25 {color: #CC0000;
	font-size: 11px;
}
.style8 {color: #FF0000}
.texto {	FONT-SIZE: 12px; COLOR: #60707f; FONT-FAMILY: Arial
}
.texto_pagina {font-family: Arial;
font-size: 12px;
color: dimgray;
}
.titulo_campos {font-family: Arial;
font-size: 12px;
color: dimgray;
font-weight: bold;
}
.style26 {font-family: tahoma; font-size: 11px; color: #990000; font-weight: bold; }
-->
</style>
$topo_email_confim
<table width='99%' border='0' align='center' cellpadding='10' cellspacing='0' bgcolor='white' class='' style='border: 5px solid #DFDFDF'>
  <tr>
    <td height='59' valign='top'><p><span class='arial_12_vermelho'>Identifica&ccedil;&atilde;o do   pedido</span><strong><BR>
              <BR>
    </strong><span class='texto_pagina'>Pedido N&ordm; <STRONG>$_SESSION[compra]</STRONG> realizado em <STRONG>".date('d/m/Y')."</STRONG></span></p>
        <p class='titulo_campos'><span class='style8'><strong class='titulo_campos'>Status: </strong>$row_rs_dados_compra[status]</span></p></td>
  </tr>
</table>
<br>
<table width='99%' border='0' align='center' cellpadding='10' cellspacing='0' bgcolor='white' class='' style='border: 5px solid #DFDFDF'>
  <tr>
    <td height='59' valign='top'><strong><span class='titulo_campos'>Seus dados:</span><BR>
          <BR>
      </strong>
        <TABLE width='100%' align='center' border='0'>
          <TBODY>
            <TR vAlign='top'>
              <TD width='50%' class='texto_pagina'><strong>$row_rs_cliente[nome] $row_rs_cliente[sobrenome]</strong><BR>
                  <span class='style16'>Data/Nascimento:</span> $row_rs_cliente[data_de_nascimento]<BR>
                  <span class='style16'>CPF:</span> $row_rs_cliente[cpf]<BR>
                  <span class='style16'>RG:</span> $row_rs_cliente[rg]<BR>
                  <span class='style16'>Sexo: </span>$row_rs_cliente[sexo]<BR>
                  <span class='style16'><BR>
                    Telefone: </span>($row_rs_cliente[ddd_telefone]) $row_rs_cliente[telefone]<br>
                <span class='style16'>Celular:</span> ($row_rs_cliente[ddd_celular]) $row_rs_cliente[celular]<BR>
                <span class='style16'>E-mail:</span> <A href='mailto:$row_rs_cliente[email]'>$row_rs_cliente[email]</A> </TD>
              <TD width='50%' class='texto_pagina'>".ucwords($row_rs_cliente[endereco]).", $row_rs_cliente[complemento]<BR>
                  $row_rs_cliente[bairro], ".ucwords($row_rs_cliente[cidade])." / $estado<BR>
                  <span class='style16'>CEP:</span> $row_rs_cliente[cep]<BR>
                  <span class='style16'>Pa&iacute;s:</span>$row_rs_cliente[pais]</TD>
            </TR>
          </TBODY>
      </TABLE></td>
  </tr>
</table>
<br>
<table width='99%' border='0' align='center' cellpadding='10' cellspacing='0' bgcolor='white' class='' style='border: 5px solid #DFDFDF'>
  <tr>
    <td height='59' valign='top'><p class='arial_12_vermelho'><strong>Dados da compra</strong></p>
		<TABLE  borderColor=#eeeeee cellSpacing=0 cellPadding=2 
      width='100%' border=1>
          <TBODY>
            <TR style='FONT-WEIGHT: bold; BACKGROUND-COLOR: whitesmoke' 
        vAlign=center>
              <TD width='8%' ><div align='center'>
                  <p>Cod</p>
              </div></TD>
              <TD width='60%' ><div align='left'>Nome</div></TD>
              <TD width='7%' ><div align='center'>QTD</div></TD>
              <TD width='13%' ><div align='center'>Valor</div></TD>
              <TD width='12%'><div align='center'>Total</div></TD>
            </TR>
          </TBODY>
        </TABLE>
$dados_pedidos
      <br>
      <table width='100%' border='1' cellpadding='0' cellspacing='0' bordercolor='#EEEEEE'>
          <tr>
            <td bgcolor='#F5F5F5'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
                <tr>
                  <td><div align='left' class='texto'><strong>&nbsp;Total de produtos solicitados: <span class='style25'> $qtds </span></strong></div></td>
                  <td><div align='right' class='texto'><strong>Total de Produtos R$ ".number_format($total_prods,2,',','.')."</strong></div></td>
                </tr>
            </table></td>
          </tr>
      </table>
    <br>
    </td>
  </tr>
</table>
<br>
<table width='99%' border='0' align='center' cellpadding='10' cellspacing='0' bgcolor='white' class='' style='border: 5px solid #DFDFDF'>
  <tr>
    <td height='59' valign='top'><p class='arial_12_vermelho'><strong>Dados da entrega </strong></p>
        <TABLE width='100%' align='center' border='0'>
          <TBODY>
            <TR vAlign='top'>
              <TD width='50%'><STRONG class='titulo_campos'>Forma de entrega escolhida</STRONG></TD>
              <TD width='50%'><STRONG class='titulo_campos'>Endere&ccedil;o de entrega</STRONG></TD>
            </TR>
            <TR vAlign='top'>
              <TD width='50%' class='texto_pagina'>".ucwords($_SESSION[forma_envio])."</TD>
              <TD width='50%' class='texto_pagina'>".ucwords($row_rs_cliente[endereco]).", ".ucwords($row_rs_cliente[complemento])."<BR>
                  ".ucwords($row_rs_cliente[bairro]).", ".ucwords($row_rs_cliente[cidade])." / $estado<BR>
                CEP: $row_rs_cliente[cep]</TD>
            </TR>
          </TBODY>
      </TABLE></td>
  </tr>
</table>
<br>
<table width='99%' border='0' align='center' cellpadding='10' cellspacing='0' bgcolor='white' style='border: 5px solid #DFDFDF'>
  <tr>
    <td height='59' valign='top'><p class='arial_12_vermelho'><strong>Situa&ccedil;&atilde;o do pedido</strong>: Aguardando confirma&ccedil;&atilde;o de pagamento!</p>
        <TABLE width='100%' align='center' border='0'>
          <TBODY>
            <TR vAlign='top'>
              <TD width='100%'><STRONG class='titulo_campos'>Forma de pagamento:</STRONG></TD>
            </TR>
            <TR vAlign='top'>
              <TD><br>
 ".$pagamento." 
              </TD>
            </TR>
          </TBODY>
      </TABLE></td>
  </tr>
</table>
<br>
<table width='99%' border='0' align='center' cellpadding='10' cellspacing='0' bgcolor='white' class='' style='border: 5px solid #DFDFDF'>
  <tr>
    <td height='59' valign='top'><p class='arial_12_vermelho'><strong>Informa&ccedil;&otilde;es importantes sobre o processo de entrega na ".$nome_da_loja.":</strong></p>
      <p class='texto'>        - Se seu pedido for  composto com mais de um item, as entregas poder&atilde;o ser realizadas em prazos  diferentes, seguindo as informa&ccedil;&otilde;es de disponibilidade constantes junto ao  produto solicitado. Ou seja, os itens ser&atilde;o liberados para entrega, seguindo  sua disponibilidade imediata nos nossos estoques. O prazo para envio destes  itens foi apresentado em sua compra e e-mail de confirma&ccedil;&atilde;o de pedido.<br>
        - N&atilde;o h&aacute; possibilidade de agendamento da entrega. <br>
  - O recebimento poder&aacute; ser feito por porteiros, secret&aacute;rias, familiares ou  qualquer respons&aacute;vel por recebimento de mercadorias no endere&ccedil;o indicado,  mediante assinatura do comprovante de entrega e apresenta&ccedil;&atilde;o de documento. <br>
  - Havendo dificuldade de entrega na 1&ordf; tentativa (destinat&aacute;rio ausente,  dificuldade na localiza&ccedil;&atilde;o do endere&ccedil;o, etc.), ser&atilde;o realizadas mais 02 tentativas com intervalo de ate 48 horas &uacute;teis entre elas.<br>
  - N&atilde;o sendo concretizada a entrega nestas novas tentativas, o produto  voltar&aacute; para nosso estoque e para qualquer uma das situa&ccedil;&otilde;es, voc&ecirc; ser&aacute;  notificado por e-mail.</p>
    </td>
  </tr>
</table>
<br>
<table width='99%' border='0' align='center' cellpadding='10' cellspacing='0' bgcolor='white' class='' style='border: 5px solid #DFDFDF'>
  <tr>
    <td height='59' valign='top'><p class='style15'>Qualquer d&uacute;vida voc&ecirc; tamb&eacute;m pode est&aacute; visitando nosso chat<br>
        <a href='http://$chat'>$chat</a> <br>
        <br>
        Obrigado por comprar na ".$nome_da_loja."!<br>
Atenciosamente,<br>
Atendimento ".$nome_da_loja."<br>
".$endereco_virtual_loja."<br>
</p>
    </td>
  </tr>
</table>";

/*mail($mail,"$assunto",$msg,"$headers");*/
	EnviarEmail($assunto, $infoSite->nome, $infoSite->email, $mail, $msg);

////////
///////////////// ENVIA TUDO PARA O LOJISTA ///////////////
$assunto = "Pedido No $_SESSION[compra] confirmado!";
$mailLoja = $infoSite->email;
$remetente = "$titulo <{$infoSite->email}>";
$headers = "Content-Type: text/html; charset=iso-8859-1\n";  
$headers.="From: $remetente\n"; 
/*mail("$mailLoja", "$assunto", $msg, "$headers");*/
	EnviarEmail($assunto, $infoSite->nome, $infoSite->email, $mailLoja, $msg);

 }
}

mysql_free_result($rs_cliente);
mysql_free_result($rs_contato);
mysql_free_result($rs_dados);
@ mysql_free_result($rs_status);
mysql_free_result($rs_empresa);
mysql_free_result($rs_banco);
mysql_free_result($rs_pedidos);
mysql_free_result($rs_dados_produto);
@ mysql_free_result($rs_forma_pagamento);
@ mysql_free_result($rs_dados_compra);

//exit;
?>
<meta http-equiv="refresh" content="900; URL=resposta_confirmacao.php" />