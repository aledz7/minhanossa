<?php 
include('Connections/conexao.php'); 
include('funcoes.php');

session_start();

include('../class/pedidos.php');
$pedidos = Pedidos::getInstance(Conexao::getInstance());

include('../class/info-site.php');
$infoSite = InfoSite::getInstance(Conexao::getInstance())->rsDados();

if($_SESSION['MM_Username'] <> '') {
	include('../class/clientes.php');
	$clientes = Clientes::getInstance(Conexao::getInstance());
	$dadosClientes = $clientes->rsDados('', '', '', $_SESSION['MM_Username']);
}

$data = date('Y-m-d');
include('config.php');


mysql_select_db($database_conexao, $conexao);
$query_rs_dados_empresa_carrinho = "SELECT * FROM tbl_config ";
$rs_dados_empresa_carrinho = mysql_query($query_rs_dados_empresa_carrinho, $conexao) or die(mysql_error());
$row_rs_dados_empresa_carrinho = mysql_fetch_assoc($rs_dados_empresa_carrinho);
$totalRows_rs_dados_empresa_carrinho = mysql_num_rows($rs_dados_empresa_carrinho);

/////////////////////////////////////// INCLUI COMPRA /////////////////////////////////////
if($_SESSION[compra] == '') {
	
	$insertSQL = "INSERT INTO tbl_compras (data, id_cliente) VALUES ('".date('Y-m-d H:i:s')."', '$row_rs_dados_cliente_se_logado[id]')";
	mysql_select_db($database_conexao, $conexao);
	$Result1 = mysql_query($insertSQL, $conexao) or die(mysql_error());
	
	mysql_select_db($database_conexao, $conexao);
	$query_rs_compra = "SELECT * FROM tbl_compras ORDER BY id DESC";
	$rs_compra = mysql_query($query_rs_compra, $conexao) or die(mysql_error());
	$row_rs_compra = mysql_fetch_assoc($rs_compra);
	$totalRows_rs_compra = mysql_num_rows($rs_compra);
	
	$_SESSION[compra] = $row_rs_compra['id'];
	
} 

////////////////// VERIFICA SE COMPRA JA FOI FECHADA  E CRIA UMA NOVA ////////////////
mysql_select_db($database_conexao, $conexao);
$query_rs_compra_fechada = "SELECT * FROM tbl_compras WHERE id = '$_SESSION[compra]' and fechado = 'S'";
$rs_compra_fechada = mysql_query($query_rs_compra_fechada, $conexao) or die(mysql_error());
$row_rs_compra_fechada = mysql_fetch_assoc($rs_compra_fechada);
$totalRows_rs_compra_fechada = mysql_num_rows($rs_compra_fechada);

if($totalRows_rs_compra_fechada > 0 ) {

	$insertSQL = "INSERT INTO tbl_compras (data, id_cliente) VALUES ('$data', '$row_rs_dados_cliente_se_logado[id]')";
	mysql_select_db($database_conexao, $conexao);
	$Result1 = mysql_query($insertSQL, $conexao) or die(mysql_error());
	
	mysql_select_db($database_conexao, $conexao);
	$query_rs_compra = "SELECT * FROM tbl_compras ORDER BY id DESC";
	$rs_compra = mysql_query($query_rs_compra, $conexao) or die(mysql_error());
	$row_rs_compra = mysql_fetch_assoc($rs_compra);
	$totalRows_rs_compra = mysql_num_rows($rs_compra);
	
	$_SESSION[compra] = $row_rs_compra['id'];
}
mysql_select_db($database_conexao, $conexao);
	$query_rs_dados_produto1 = "SELECT * FROM tbl_produtos WHERE id = '$_POST[id]'";
	$rs_dados_produto1 = mysql_query($query_rs_dados_produto1, $conexao) or die(mysql_error());
	$row_rs_dados_produto1 = mysql_fetch_assoc($rs_dados_produto1);
	$totalRows_rs_dados_produto1 = mysql_num_rows($rs_dados_produto1);
	
	if($_POST['qtd'] > $row_rs_dados_produto1['estoque']){
		$nomeProduto = $row_rs_dados_produto1['nome'];
		$estoqueProduto = $row_rs_dados_produto1['estoque'];
		echo "
			<script>
				alert('Quantidade do produto '$nomeProduto' indisponivel no estoque. Atualmente temos $estoqueProduto em nossos estoques.');
				history.back();
			</script>
		";
	}

if($_POST[acao] == 'comprar' and $_POST[id] <> '') {
	
	if($_POST['sistema_variacao'] <> 'presente') {
		echo "	<script>
				alert('Sistema de variações não instalado. Colocar no formulário de compras o comando: ".'$produtos->selectVariacoes($_GET["id"]);'."');
				history.back();
				</script>";
				exit;
	}
	
	mysql_select_db($database_conexao, $conexao);
	$query_rs_dados_produto = "SELECT * FROM tbl_produtos WHERE id = '$_POST[id]'";
	$rs_dados_produto = mysql_query($query_rs_dados_produto, $conexao) or die(mysql_error());
	$row_rs_dados_produto = mysql_fetch_assoc($rs_dados_produto);
	$totalRows_rs_dados_produto = mysql_num_rows($rs_dados_produto);
	
	if($_POST['qtd'] > $row_rs_dados_produto['estoque']){
		$nomeProduto = $row_rs_dados_produto['nome'];
		$estoqueProduto = $row_rs_dados_produto['estoque'];
		echo "
			<script>
				alert('Quantidade do produto '$nomeProduto' indisponivel no estoque. Atualmente temos $estoqueProduto em nossos estoques.');
				history.back();
			</script>
		";
	}
	
	/*mysql_select_db($database_conexao, $conexao);
	$query_rs_variacoes = "SELECT * FROM tbl_variacoes WHERE id = '$_POST[id_variacao]'";
	$rs_variacoes = mysql_query($query_rs_variacoes, $conexao) or die(mysql_error());
	$row_rs_variacoes = mysql_fetch_assoc($rs_variacoes);
	$totalRows_rs_variacoes = mysql_num_rows($rs_variacoes);*/
	
	if($infoSite->temAtacado == 'S' and $dadosClientes->cnpj <> '') {
		$preco_com_acrecimo = $row_rs_dados_produto['preco_por_atacado'];
	} else {
		$preco_com_acrecimo = $row_rs_dados_produto['preco_por']/100*$row_rs_niveis['porcentagem']+$row_rs_dados_produto['preco_por'];
	}
	
	/*if($_POST[valorVariacao] <> '') {
		$preco_com_acrecimo = $_POST[valorVariacao]; 
	}*/
	
	///////////////// VERIFICAR SE PRODUTO JA TA NO CARRINHO ////////////
	$colname_rs_prod_existe = "-1";
	if(isset($_SESSION['compra'])) {
		$colname_rs_prod_existe = $_SESSION['compra'];
	}
	mysql_select_db($database_conexao, $conexao);
	$query_rs_prod_existe = sprintf("SELECT * FROM tbl_pedidos_por_id_compra WHERE id_compra = %s and produto = '$_POST[id]'", GetSQLValueString($colname_rs_prod_existe, "int"));
	$rs_prod_existe = mysql_query($query_rs_prod_existe, $conexao) or die(mysql_error());
	$row_rs_prod_existe = mysql_fetch_assoc($rs_prod_existe);
	$totalRows_rs_prod_existe = mysql_num_rows($rs_prod_existe);
	
	if($totalRows_rs_prod_existe > 0) { 
		echo "	<script>
				alert('Produto já está no carrinho!".'\n'."Se necessário altere a quantidade.');
				window.location='carrinho.php'
				</script>";
				exit;
	} ////// FIM VERIFICAÇÃO

	
	if($_POST[qtd] == '') { 
		$_POST[qtd] = 1;
	}
	
	if(count($_POST['id_variacao']) > 0) {
		foreach($_POST['id_variacao'] as $id_variacao) {
			mysql_select_db($database_conexao, $conexao);
			$query_rs_variacoes = "SELECT * FROM tbl_noticias WHERE id = '".intval($id_variacao)."'";
			$rs_variacoes = mysql_query($query_rs_variacoes, $conexao) or die(mysql_error());
			$row_rs_variacoes = mysql_fetch_assoc($rs_variacoes);
			$totalRows_rs_variacoes = mysql_num_rows($rs_variacoes);
			
			$variacoes .= $row_rs_variacoes['titulo'];
			if($row_rs_variacoes['por'] > 0) {
				$preco_com_acrecimo = $row_rs_variacoes['por'];
			}
		}
	}
	
	$insertSQL = "INSERT INTO tbl_pedidos_por_id_compra (variacao, produto, valor_c_acrecimo, id_compra, data, qtd) VALUES ('".$variacoes."', '$_POST[id]', '$preco_com_acrecimo', '$_SESSION[compra]', '$data', '$_POST[qtd]')";
	mysql_select_db($database_conexao, $conexao);
	$Result1 = mysql_query($insertSQL, $conexao) or die(mysql_error());
	
	echo "	<script>
			window.location='carrinho.php'
			</script>";

}

/////////////////  ALTERAR QUANTIDADE ////////////


if($_POST[acao] == 'alterar' and $_POST[id] <> '') {

	$updateSQL = "UPDATE tbl_pedidos_por_id_compra SET qtd='$_POST[qtd]' WHERE id='$_POST[id]'";
	mysql_select_db($database_conexao, $conexao);
	$Result1 = mysql_query($updateSQL, $conexao) or die(mysql_error());

	echo "	<script>
			window.location='carrinho.php?tipo_entrega=$_POST[tipo_entrega]'
			</script>";
} //// FIM ALTERAR QUANTIDADE.



////////////////  EXCLUIR PRODUTO ///////////////

if($_GET[acao] == 'excluir' and $_GET[id] <> '') {

$deleteSQL = "DELETE FROM tbl_pedidos_por_id_compra WHERE id='$_GET[id]'";

  mysql_select_db($database_conexao, $conexao);
  $Result1 = mysql_query($deleteSQL, $conexao) or die(mysql_error());

echo "	<script>
		window.location='carrinho.php'
		</script>";
}

/////////////// LIMPAR CARRINHO /////////////////////

if($_GET[acao] == 'limpar' and $_SESSION[compra] <> '') {
	$deleteSQL = "DELETE FROM tbl_pedidos_por_id_compra WHERE id_compra='$_SESSION[compra]'";
	mysql_select_db($database_conexao, $conexao);
	$Result1 = mysql_query($deleteSQL, $conexao) or die(mysql_error());
  
	$deleteSQL = "DELETE FROM tbl_compras WHERE id='$_SESSION[compra]'";
	mysql_select_db($database_conexao, $conexao);
	$Result1 = mysql_query($deleteSQL, $conexao) or die(mysql_error());
  
	unset($_SESSION[compra]);
	
	echo "	<script>
			window.location='index.php'
			</script>";
} /// FIM LIMPA CARRINHO.




/// GRAVA VALOR DO FRETE NA SESSÃO PARA CONFIRMAR PEDIDO.
if($_GET[total_prods] <> '') {
	/// se frete gratis
	if($_GET[acao] == "freteGratis") {
		$_SESSION[total_frete] = "Grátis";
		$_SESSION[forma_envio] = 'Frete Grátis';
		
		echo "	<script>
				parent.window.location='area-cliente.php'
				</script>";
				exit;
	}
}
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
        <? include('header.php'); ?>

        <div class="shopping-cart-area">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-xs-12">
                        <div class="s-cart-all">
                            <div class="page-title">
                                <h1>Carrinho de Compras</h1>
                            </div>
                            <?php 
							$rsItensPedido = $pedidos->rsItens($_SESSION['compra']);
							
							if (count($rsItensPedido) > 0) { ?>
                            <div class="cart-form table-responsive">
                                <table id="shopping-cart-table" class="data-table cart-table">
                                    <tr>
                                        <th>Remover</th>
                                        <th>Foto</th>
                                        <th>Produto</th>
                                        <th>Preço Unitário</th>
                                        <th>Qtd</th>
                                        <th>Subtotal</th>
                                    </tr>
<?php
		unset($total_frete);
		unset($_SESSION[total_prods]);
		unset($total_prods);

		foreach($rsItensPedido as $itensPedido) {
			
			$id_produto = $itensPedido->produto;
			
			if($itensPedido->peso < 5) {
				$itensPedido->peso = $itensPedido->peso*1000;
			}
			
			$peso += valorCalculavel($itensPedido->peso) * $itensPedido->qtd;
			$altura = str_replace(',','',$itensPedido->altura) * $itensPedido->qtd + $altura;
			$largura = str_replace(',','',$itensPedido->largura) * $itensPedido->qtd + $largura;
			$comprimento = str_replace(',','',$itensPedido->comprimento) * $itensPedido->qtd + $comprimento;

?>
<form name="formCarrinho<?php echo $itensPedido->id ?>" id="formCarrinho<?php echo $itensPedido->id; ?>" method="POST" action="">
                                    <tr>
                                     <td class="sop-icon">
                                      <a href="carrinho.php?acao=excluir&id=<?php echo $itensPedido->id?>">
                                       <i class="fa fa-times"></i>
                                      </a>
                                     </td>
                                     <td class="sop-cart">
                                      <a href="<?php echo str_replace(array('[id]', '[nome]'),array($itensPedido->produto, $itensPedido->nomeProduto),$pagProdutos);?>">
                                       <img class="primary-image" alt="" src="../img_noticias/<?php echo $itensPedido->foto ?>" style="height:100px;">
                                      </a>
                                     </td>
                                     <td class="sop-cart">
                                      <a href="<?php echo str_replace(array('[id]', '[nome]'),array($itensPedido->produto, $itensPedido->nomeProduto),$pagProdutos);?>">
                                       <?php echo $itensPedido->nomeProduto;
									   
									   if($itensPedido->variacao <> '') {
									   	echo ' ('.$itensPedido->variacao.')';
									   }?>
                                      </a>
                                     </td>
                                     <td class="sop-cart">
                                      R$ <?php echo number_format($itensPedido->valor_c_acrecimo, 2, ',', '.') ?>
                                     </td>
                                     <td>
                                     <input name="tipo_entrega" type="hidden" id="tipo_entrega" value="<?=$_GET[tipo_entrega];?>" />
                                     <input name="acao" type="hidden" id="acao" value="alterar" />
                                     <input name="id" type="hidden" id="id" value="<?php echo $itensPedido->id; ?>" />
                                      <select  name="qtd" class="styler" id="qtd" style="padding:3px;" onchange="javascript:document.formCarrinho<?php echo $itensPedido->id; ?>.submit(); qdtEstoque(this.value);">
                                      <? for ($i=1; $i< 100; $i++) { ?> 
                                       <option value="<?=$i;?>" <?php if($itensPedido->qtd == $i) { ?>selected="selected"<? } ?> >
               							<? echo $i; ?>
                                       </option>
                                     <? } ?>
                                     <input type="hidden" name="qdtestoque" id="qdtestoque" value="" >
                                     <input type="hidden" name="qdtestoque3" id="qdtestoque3" value="<? echo $itensPedido->estoque;?>" >
                                     </select>
                                     </td>
                                     <td class="sop-cart">
                                      <?php 
										$total = $itensPedido->valor_c_acrecimo*$itensPedido->qtd;
										$total_prods = $total+$total_prods;
										echo "R$".number_format($total,2,',','.');
										$qtds = $itensPedido->qtd+$qtds; ?>
                                     </td>
                                    </tr>
</form>
<?php } ?>

                                  </table>
                                  <div class="a-all ">
                                   <div class="a-left">
                                    <button class="button2  notice" title="" type="button" onclick="location.href='../';">
                                     <span>Continuar Comprando</span>
                                    </button>
                                   </div>
                                   <div class="a-right">
                                   <!-- <button class="button2 notice Estimate" title="" type="button">
                                     <span>Atualizar Carrinho</span>
                                    </button>-->
                                    <button class="button2 notice " title="" type="button" onclick="location.href='carrinho.php?acao=limpar'">
                                     <span>Limpar Carrinho</span>
                                    </button>
                                   </div>
                                  </div>
                                 
                                 </div>
                          <? } else { ?>
                           <p>Você não colocou produtos em seu carrinho!</p>
                          <? } ?>
                        </div>
                    </div>
                </div>
                <div class="cart-collaterals row">
               
                    <div class="col-md-offset-4 col-md-4 col-sm-6">
                     <?php if($temFrete == 'S') { ?>
                        <div class="ma-title ma-cart">
                            <h2>
                             Calcular Frete
                            </h2>
                        </div>
                        <form action="calcula.php" target="enviaCarrinho" method="get">
                         <input name="total_prods" type="hidden" id="total_prods" value="<?=$total_prods;?>" />
                        <div class="shipping-zip-form">
                         <div class="shipping-form1">
                          <p>Informe seu CEP abaixo</p>
                           <div class="input-one form-list">
                            <label class="required get">
                             CEP
                             <a href="http://www.buscacep.correios.com.br/sistemas/buscacep/default.cfm" target="_blank" style="margin-left: 164px; color: #62B353;">
                              Não sabe seu CEP? Clique aqui
                             </a>
                            </label>
                            <input class="email" name="cep_destino" id="cep_destino" type="text" required>
                            <input type="hidden" name="cep_origem" value="<?php echo $row_rs_dados_empresa_carrinho['cep_loja'] ?>">
                            <input type="hidden" name="peso" value="<?=$peso;?>">
                           </div>
                           <div id="valorFrete"></div>
                           <button class="button2 get" title="" type="submit">
                            <span>Calcular</span>
                           </button>
                          </div>
                         </div>
                        </form>
                     <? } ?>
                     </div>
                     
<script>
function fecha_pedido() {
	if(document.getElementById('cep_destino').value == '') {
		alert('Por favor. Preencha o CEP de destino e clique em calcular frete.');
	} else {
		parent.window.location='info-pagamento.php';
		return false;
	}
	<? 
	if($total_prods > $row_rs_dados_empresa_carrinho['frete_gratis_acimade']) { 
	?>
	//window.location='?acao=freteGratis&total_prods=<?=$total_prods;?>';
	//return false;
	<? } ?>
	/// VERIFICA SE PEDIDO TA NO VALOR MINIMO
	if(document.getElementById('total_prods').value > <?php echo valorCalculavel($row_rs_dados_empresa_carrinho['venda_minima']); if(valorCalculavel($row_rs_dados_empresa_carrinho['venda_minima']) == '') { echo 0; } ?>) { 
	/// SE ESTIVER FAZ O SUBMIT
	document.fechar_frete.submit(); 
} else {
/// SE NÃO ESTIVE DA O ALERTA
alert('Desculpe. Aceitamos pedidos somente acima de R$ <?php echo number_format($row_rs_dados_empresa_carrinho['venda_minima'],2,',','.'); ?>'); }
// FIM
}
</script>
                     
                    <div class="col-md-4 col-sm-12">
                        <div class="totals">
                            <div class="subtotal">
                                <p>Subtotal R$<span>
                                 <? echo number_format($total_prods,2,',','.');
									$_SESSION[total_prods] = $total_prods; ?>
                                </span></p>
                                <p>Valor do Frete <span id="frete"> R$ 0.00</span></p>
                                <p>Total R$ <span id="subtotal">0.00</span></p>
                            </div>
                            <button class="button2 get" style="background:hsla(106,93%,24%,1.00)" title="" type="button" onclick="javascript:fecha_pedido()" >
                                <span>Finalizar Compra</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<div style="padding-top:30px"></div>

		<iframe src="" frameborder="0" name="enviaCarrinho" id="enviaCarrinho" style="display:none;"></iframe>
       
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
        <script src="js/vendor/jquery-1.11.3.min.js"></script>
        <script src="js/jquery-ui.js"></script>
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
        <script src="js/number_format.js"></script>
    </body>
</html>

