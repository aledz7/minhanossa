<?php 
if (!isset($_SESSION)) { session_start(); }

include('Connections/conexao.php');
include('funcoes.php');

include('../class/pedidos.php');
$pedidos = Pedidos::getInstance(Conexao::getInstance());

include('../class/estados.php');
$estados = Estados::getInstance(Conexao::getInstance());

$currentPage = $_SERVER["PHP_SELF"];

$colname_rs_dados_cliente = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_rs_dados_cliente = $_SESSION['MM_Username'];
}
mysql_select_db($database_conexao, $conexao);
$query_rs_dados_cliente = sprintf("SELECT * FROM tbl_cliente WHERE email = %s", GetSQLValueString($colname_rs_dados_cliente, "text"));
$rs_dados_cliente = mysql_query($query_rs_dados_cliente, $conexao) or die(mysql_error());
$row_rs_dados_cliente = mysql_fetch_assoc($rs_dados_cliente);
$totalRows_rs_dados_cliente = mysql_num_rows($rs_dados_cliente);;

if($row_rs_dados_cliente['email'] == '') {
	echo "	<script>
			window.location='login.php'
			</script>";
			exit; 
}

$maxRows_rs_minhas_compras = 30;
$pageNum_rs_minhas_compras = 0;
if (isset($_GET['pageNum_rs_minhas_compras'])) {
  $pageNum_rs_minhas_compras = $_GET['pageNum_rs_minhas_compras'];
}
$startRow_rs_minhas_compras = $pageNum_rs_minhas_compras * $maxRows_rs_minhas_compras;

mysql_select_db($database_conexao, $conexao);
$query_rs_minhas_compras = "SELECT * FROM tbl_compras WHERE id_cliente = '$row_rs_dados_cliente[id]' and fechado = 'S' ORDER BY id DESC";
$query_limit_rs_minhas_compras = sprintf("%s LIMIT %d, %d", $query_rs_minhas_compras, $startRow_rs_minhas_compras, $maxRows_rs_minhas_compras);
$rs_minhas_compras = mysql_query($query_limit_rs_minhas_compras, $conexao) or die(mysql_error());
$row_rs_minhas_compras = mysql_fetch_assoc($rs_minhas_compras);

if (isset($_GET['totalRows_rs_minhas_compras'])) {
  $totalRows_rs_minhas_compras = $_GET['totalRows_rs_minhas_compras'];
} else {
  $all_rs_minhas_compras = mysql_query($query_rs_minhas_compras);
  $totalRows_rs_minhas_compras = mysql_num_rows($all_rs_minhas_compras);
}
$totalPages_rs_minhas_compras = ceil($totalRows_rs_minhas_compras/$maxRows_rs_minhas_compras)-1;

$queryString_rs_minhas_compras = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rs_minhas_compras") == false && 
        stristr($param, "totalRows_rs_minhas_compras") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rs_minhas_compras = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rs_minhas_compras = sprintf("&totalRows_rs_minhas_compras=%d%s", $totalRows_rs_minhas_compras, $queryString_rs_minhas_compras);

/////////////////////////////////////////////// COMPRAS FINALIZADAS /////////////////////////////////////////////////////////////

$maxRows_rs_minhas_compras_nao_finalizadas = 30;
$pageNum_rs_minhas_compras_nao_finalizadas = 0;
if (isset($_GET['pageNum_rs_minhas_compras'])) {
  $pageNum_rs_minhas_compras_nao_finalizadas = $_GET['pageNum_rs_minhas_compras'];
}
$startRow_rs_minhas_compras_nao_finalizadas = $pageNum_rs_minhas_compras_nao_finalizadas * $maxRows_rs_minhas_compras_nao_finalizadas;

mysql_select_db($database_conexao, $conexao);
$query_rs_minhas_compras_nao_finalizadas = "SELECT * FROM tbl_compras WHERE id_cliente = '$row_rs_dados_cliente[id]' and fechado = 'N' ORDER BY id DESC";
$query_limit_rs_minhas_compras_nao_finalizadas = sprintf("%s LIMIT %d, %d", $query_rs_minhas_compras_nao_finalizadas, $startRow_rs_minhas_compras_nao_finalizadas, $maxRows_rs_minhas_compras_nao_finalizadas);
$rs_minhas_compras_nao_finalizadas = mysql_query($query_limit_rs_minhas_compras_nao_finalizadas, $conexao) or die(mysql_error());
$row_rs_minhas_compras_nao_finalizadas = mysql_fetch_assoc($rs_minhas_compras_nao_finalizadas);

if (isset($_GET['totalRows_rs_minhas_compras'])) {
  $totalRows_rs_minhas_compras_nao_finalizadas = $_GET['totalRows_rs_minhas_compras_nao_finalizadas'];
} else {
  $all_rs_minhas_compras_nao_finalizadas = mysql_query($query_rs_minhas_compras_nao_finalizadas);
  $totalRows_rs_minhas_compras_nao_finalizadas = mysql_num_rows($all_rs_minhas_compras_nao_finalizadas);
}
$totalPages_rs_minhas_compras_nao_finalizadas = ceil($totalRows_rs_minhas_compras_nao_finalizadas/$maxRows_rs_minhas_compras_nao_finalizadas)-1;

$queryString_rs_minhas_compras_nao_finalizadas = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rs_minhas_compras_nao_finalizadas") == false && 
        stristr($param, "totalRows_rs_minhas_compras_nao_finalizadas") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rs_minhas_compras_nao_finalizadas = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rs_minhas_compras_nao_finalizadas = sprintf("&totalRows_rs_minhas_compras_nao_finalizadas=%d%s", $totalRows_rs_minhas_compras_nao_finalizadas, $queryString_rs_minhas_compras_nao_finalizadas);

mysql_select_db($database_conexao, $conexao);
$query_rs_estados = "SELECT * FROM dados_estados";
$rs_estados = mysql_query($query_rs_estados, $conexao) or die(mysql_error());
$row_rs_estados = mysql_fetch_assoc($rs_estados);
$totalRows_rs_estados = mysql_num_rows($rs_estados);

$currentPage = substr($_SERVER['PHP_SELF'],strpos($_SERVER['PHP_SELF'],'admin')+6);

$maxRows_rs_endereco = 10;
$pageNum_rs_endereco = 0;
if (isset($_GET['pageNum_rs_endereco'])) {
  $pageNum_rs_endereco = $_GET['pageNum_rs_endereco'];
}
$startRow_rs_endereco = $pageNum_rs_endereco * $maxRows_rs_endereco;

mysql_select_db($database_conexao, $conexao);
$query_rs_endereco = "
 SELECT  
  tbl_endereco.*,
  dados_estados.uf AS ufEndereco,
  dados_cidades.nome AS nomeEndereco
 FROM 
  tbl_endereco
 LEFT JOIN
  dados_estados ON tbl_endereco.estado = dados_estados.id
 LEFT JOIN
  dados_cidades ON tbl_endereco.cidade = dados_cidades.id
 WHERE 
 tbl_endereco.id_cliente = '$row_rs_dados_cliente[id]' ORDER BY id DESC";
$query_limit_rs_endereco = sprintf("%s LIMIT %d, %d", $query_rs_endereco, $startRow_rs_endereco, $maxRows_rs_endereco);
$rs_endereco = mysql_query($query_limit_rs_endereco, $conexao) or die(mysql_error());
$row_rs_endereco = mysql_fetch_assoc($rs_endereco);

if (isset($_GET['totalRows_rs_endereco'])) {
  $totalRows_rs_endereco = $_GET['totalRows_rs_endereco'];
} else {
  $all_rs_endereco = mysql_query($query_rs_endereco);
  $totalRows_rs_endereco = mysql_num_rows($all_rs_endereco);
}
$totalPages_rs_endereco = ceil($totalRows_rs_endereco/$maxRows_rs_endereco)-1;

$queryString_rs_endereco = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rs_endereco") == false && 
        stristr($param, "totalRows_rs_endereco") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rs_endereco = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rs_endereco = sprintf("&totalRows_rs_endereco=%d%s", $totalRows_rs_endereco, $queryString_rs_endereco);

?>
<!doctype html>
<html class="no-js" lang="">
    <?php include('head.php'); ?>
    <body>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <!-- Add your site or application content here -->
        <!-- start header_area
		============================================ -->
        <?php include('header.php'); ?>
        <!-- end header_area
		============================================ -->
		<style>
		.panel {
    		margin-bottom: 5px;
			}
		.panel-group {
				margin-bottom: 5px;
			}
		</style>
        <section class="collapse_area">
         <div class="container">
          <div class="row">
			   <div class="col-md-12 col-sm-12">
				<div class="check">
				 <h1>Minha Conta</h1>
				</div>
				<div class="faq-accordion">
				 <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
			 <!-- <div class="panel panel-default">
				   <div class="panel-heading" role="tab" id="headingOne">
					<h4 class="panel-title">
					 <a class="collapsed method" role="button" data-parent="#accordion" href="info-pagamento.php">
					  <span class="number"><i class="fa fa-hand-o-right" aria-hidden="true"></i></span>
					   Continuar Compra
					 </a>
					</h4>
				   </div> 
				  </div> -->
				 <div class="panel panel-default">
				   <div class="panel-heading" role="tab" id="headingOne">
					<h4 class="panel-title">
					 <a class="collapsed method" role="button" data-parent="#accordion" href="lista-de-desejos.php">
					  <span class="number"><i class="fa fa-hand-o-right" aria-hidden="true"></i></span>
					   Lista de desejos
					 </a>
					</h4>
				   </div> 
				  </div>
				  <?php if($totalRows_rs_minhas_compras > 0) { ?>
				  <div class="panel panel-default">
				   <div class="panel-heading" role="tab" id="headingTwo">
					<h4 class="panel-title">
					 <a class="" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="<?php if($_GET['acao'] == 'compraFinalizada' ){ echo 'true'; } else { echo 'false'; } ?>" aria-controls="collapseTwo">
					  <span class="number"><i class="fa fa-check" aria-hidden="true"></i></span>
					   Histórico de Compras Finalizadas
					 </a>
					</h4>
				   </div>
				   <?php if($_GET['acao'] == 'compraFinalizada' ){  ?>
				   <div id="collapseTwo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo" aria-expanded="true" >
				   <?php } else { ?>
				   	<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo" aria-expanded="false" style="height: 0px;">  
					<?php } ?>
				   	 <div class="easy">
					  <div class="order-review">
					   <div class="table-responsive">
						<table class="table">
						 <thead>
						  <tr>
						   <th class="width-1">Produto</th>
						   <th class="width-2">Status</th>
						   <th class="width-3">Total</th>
						   <th class="width-4">Ações</th>
						  </tr>
						 </thead>
						 <tbody>
						 <?php do { ?>
						  <tr>
						   <td width="20%" style="vertical-align:middle">
							<?php
							 $rsPedidos = $pedidos->rsItens($row_rs_minhas_compras[id]);
						 foreach($rsPedidos as $pedido) {
						 ?>
							<div class="o-pro-dec">
							<?php echo $pedido->nomeProduto; 
							   $total = $pedido->valor_c_acrecimo;
							  ?>
							</div>
							<?php } ?>

						   </td>
						   <td style="vertical-align:middle">
							<div class="o-pro-qty">
							  <?php echo descStatus($row_rs_minhas_compras['status']); ?>
							</div>
						   </td>
						   <td style="vertical-align:middle">
							<div class="o-pro-price">
							  R$<?php echo number_format($total, 2, ',', '.'); ?>
							</div>
						   </td>
						   <td style="text-align:center ">

							  <button class="button2 get" type="submit" title="" style="margin-bottom:0px; float:inherit !important; display:inherit" />
							   <span>Pagar</span>
							  </button>&nbsp;<button class="button2 get" type="button" title="" style="margin-bottom:0px; float:inherit !important; display:inherit;" onclick="MM_goToURL('parent','detalhes-minhas-compras.php?id=<?php echo $row_rs_minhas_compras['id'] ?>');return document.MM_returnValue">
							   <span>Detalhes</span>
							  </button>

						   </td>
						  </tr>
						 <?php } while ($row_rs_minhas_compras = mysql_fetch_assoc($rs_minhas_compras)); ?>
						 </tbody>
						</table>
					   </div>
					  </div>
					 </div>
				   	</div>
				   </div>
			   <?php } ?>

			   <?php if($totalRows_rs_minhas_compras_nao_finalizadas > 0) { ?>
				<div class="panel panel-default">
				 <div class="panel-heading" role="tab" id="headingThree">
				  <h4 class="panel-title">
				   <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseTwo">
					<span class="number"><i class="fa fa-times" aria-hidden="true"></i></span>
					 Histórico de Compras Não Finalizadas
				   </a>
				  </h4>
				 </div>
				 <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree" aria-expanded="false" style="height: 0px;">
				  <div class="row">
				   <div class="easy">
					<div class="order-review">
					 <div class="table-responsive">
					  <table class="table">
					   <thead>
						<tr>
						 <th class="width-1">Produtos</th>
						 <th class="width-2">Total</th>
						 <th class="width-3">Ações</th>
						</tr>
					   </thead>
					   <tbody>
						<?php do { 

						 mysql_select_db($database_conexao, $conexao);
						 $query_rs_produtos_nao = "SELECT * FROM tbl_pedidos_por_id_compra WHERE id_compra = '$row_rs_minhas_compras_nao_finalizadas[id]'";
						 $rs_produtos_nao = mysql_query($query_rs_produtos_nao, $conexao) or die(mysql_error());
						 $row_rs_produtos_nao = mysql_fetch_assoc($rs_produtos_nao);
						 $totalRows_rs_produtos_nao = mysql_num_rows($rs_produtos_nao);

						?>
						<tr>
						 <td width="20%">
						  <div class="o-pro-dec">
							<?php do { 
							 mysql_select_db($database_conexao, $conexao);
							 $query_rs_detalhes_produtos_nao = "SELECT * FROM tbl_produtos WHERE id = '$row_rs_produtos_nao[produto]'";
							 $rs_detalhes_produtos_nao = mysql_query($query_rs_detalhes_produtos_nao, $conexao) or die(mysql_error());
							 $row_rs_detalhes_produtos_nao = mysql_fetch_assoc($rs_detalhes_produtos_nao);
							 $totalRows_rs_detalhes_produtos_nao = mysql_num_rows($rs_produtos_nao);
							?>
						   <p>
							  <?php echo $row_rs_detalhes_produtos_nao['nome']; 
							   $total = $total+$row_rs_produtos_nao['valor_c_acrecimo'];
							  ?>
							 </p>
							<?php } while($row_rs_produtos_nao = mysql_fetch_assoc($rs_produtos_nao)); ?>
						  </div>
						 </td>
						 <td>
						  <div class="o-pro-price">
						   <p>
							<?php echo number_format($total, 2, ',', '.') ?>
						   </p>
						  </div>
						 </td>
						 <td width="10%">
						  <div class="o-pro-qty">
						   <p>
							  <button class="button2 get" type="submit" title="" onClick="MM_goToURL('parent','');return document.MM_returnValue" />
							   <span>Cancelar</span>
							  </button>
							  <button class="button2 get" type="button" title="" onClick="MM_goToURL('parent','');return document.MM_returnValue">
							   <span>Realizar Pedido!</span>
							  </button>
						   </p>
						  </div>
						 </td>
						</tr>
					   </tbody>
					   <?php } while ($row_rs_minhas_compras_nao_finalizadas = mysql_fetch_assoc($rs_minhas_compras_nao_finalizadas)); ?>
					  </table>
					 </div>
					</div>
				   </div>
				  </div>
				 </div>
			  </div>
			 <?php } ?>

			  <div class="panel panel-default">
			   <div class="panel-heading" role="tab" id="headingFour">
				<h4 class="panel-title">
				 <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
				  <span class="number"><i class="fa fa-file-text-o" aria-hidden="true"></i></span>
				   Meus Dados
				 </a>
				</h4>
			   </div>
			  </div>
			  <div>
			   <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour" aria-expanded="false" style="height: 0px;">
				<div class="easy" style="padding-top:0px;">
				 <?php include('form-meus-dados.php');?>
				</div>
			   </div>
			  </div>
			  <!--<div class="panel panel-default">
			   <div class="panel-heading" role="tab" id="headingFive">
				<h4 class="panel-title">

				 <a class="" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="<?php if($_GET['acao'] == 'endEntrega' ){ echo 'true'; } else { echo 'false'; } ?>" id="endEntrega" aria-controls="collapseFive">
				  <span class="number"><i class="fa fa-truck" aria-hidden="true"></i></span>
				   Meus Dados (Endereço de entrega)
				 </a>

				</h4>
			   </div> -->
			   <?php if($_GET['acao'] == 'endEntrega' ){?>
			   <div id="collapseFive" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingFive" aria-expanded="true" >
			   <?php } else { ?>
			   <div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFive" aria-expanded="false" style="height: 0px;">
			   <?php } ?>
				<a href="javascript:;" onclick="chamaForm()" class="btn-a">
				 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cadastrar Novo Endereço
				</a>
				 <div class="easy" style="display:none;" id="easy">
				 <form name="formAtualizaCliente" id="formAtualizaCliente" action="add-endereco.php" method="POST">
				 <div class="billing-info">
				  <div class="input-one form-list col-sm-4">
				   <label class="required">
					Estado
					<em>*</em>
				   </label>
				   <select class="email s-email" name="id_estado" id="id_estado" onchange="buscar_cidade()">
					  <?php do { ?>
					   <option value="<?php echo $row_rs_estados['id']?>" title="<?php echo texto($row_rs_estados['nome']); ?>">
						<?php echo $row_rs_estados['uf']?>
					   </option>
					   <?php
						 } while ($row_rs_estados = mysql_fetch_assoc($rs_estados));
								  $rows = mysql_num_rows($rs_estados);
								  if($rows > 0) {
								  mysql_data_seek($rs_estados, 0);
								  $row_rs_estados = mysql_fetch_assoc($rs_estados);
								 }
					   ?>
				  </select>   
				  </div>
				  <div class="input-one form-list col-sm-4">
				   <label class="required">
					Cidade
					<em>*</em>
				   </label>
				   <div id="load_cidade">
				   <select name="id_cidade" id="id_cidade" class="email s-email">
					<option value="">Cidade</option>
				   </select> 
				   </div>
				  </div>
				  <div class="input-one form-list col-sm-4">
				   <label class="required">
					CEP
					<em>*</em>
				   </label>
				   <input class="email" type="text" required="" name="cep" id="cep" >
				  </div>
				  <div class="input-one form-list col-sm-12">
				   <label class="required">
					Endereço
					<em>*</em>
				   </label>
				   <input class="email" type="text" required="" name="endereco" id="endereco">
				  </div>
				  <div class="input-one form-list col-sm-12">
				   <label class="required">
					Bairro
					<em>*</em>
				   </label>
				   <input class="email" type="text" required="" name="bairro" id="bairro" >
				  </div>
				  <div class="input-one form-list col-sm-6">
				   <label class="required">
					Telefone
				   </label>
				   <input class="email" type="text" name="telefone" id="telefone">
				  </div>
				  <div class="input-one form-list col-sm-6">
				   <label class="required">
					Celular
				   </label>
				   <input class="email" type="text" name="celular" id="celular" >
				  </div>

				  <div class="form-group col-sm-12">
				   <div class="block-right">
					<span>
					 Para ver os endereços já cadasrados clique
					 <a class="o-back-to" href="javascript:;" onclick="chamaTabela()">aqui</a>!
					</span>
				   </div>
				   <div class="block-button-left">
					<button class="button2 get" type="submit" title="" style="margin-top:30px;">
					 <span>Cadastrar novo endereço!</span>
					</button>
				   </div>
				  </div>
				 </div>
				 <input type="hidden" name="id_cliente" value="<?php echo $row_rs_dados_cliente['id'] ?>" />
				 <input type="hidden" name="tipo" value="novoEndereco" />
				</form>
				</div>  
				<div class="easy" style="display:block;" id="easy2">
				  <div class="order-review">
				   <div class="table-responsive">
					<table class="table">
					 <thead>
					  <tr>
					   <th class="width-4">Estado</th>
					   <th class="width-3">Cidade</th>
					   <th class="width-1">Endereço</th>
					   <th class="width-4">Bairro</th>
					   <th class="width-2">Opção de Entrega</th>
					  </tr>
					 </thead>
					 <?php do { ?>
					 <tbody>
					  <tr>
					   <td>
						<div class="o-pro-dec" align="center">
						 <p>
						  <?php echo $row_rs_endereco['ufEndereco'] ?>
						 </p>
						</div>
					   </td>
					   <td>
						<div class="o-pro-price">
						 <p>
						  <?php echo $row_rs_endereco['nomeEndereco'] ?>
						 </p>
						</div>
					   </td>
					   <td>
						<div class="o-pro-qty">
						 <p><?php echo $row_rs_endereco['endereco'] ?></p>
						</div>
					   </td>
					   <td>
						<div class="o-pro-subtotal">
						 <p><?php echo $row_rs_endereco['bairro'] ?></p>
						</div>
					   </td>
					   <td width="30%">
						<div class="o-pro-subtotal">
						 <p>
						  <button class="button2 get" type="submit" title="" onclick="javascript:window.location='editar-endereco.php?id=<?php echo $row_rs_endereco['id']; ?>&id_cliente=<?php echo $row_rs_dados_cliente['id'];?>';" />
						   <span>Gerenciar</span>
						  </button>

						  <button class="button2 get" type="button" title="" onclick="javascript:window.location='info-pagamento.php?id=<?php echo $row_rs_endereco['id']; ?>';">
						   <span>Entregar Neste</span>
						  </button>
						 </p>
						</div>
					   </td>
					  </tr>
					 </tbody>
					 <?php } while($row_rs_endereco = mysql_fetch_assoc($rs_endereco)); ?>
					</table>
				   </div>
				  </div>
				 </div>                           
			   </div>   
			   </div>
				<div class="panel panel-default">
			   <div class="panel-heading" role="tab" id="headingSix">
				<h4 class="panel-title">
				 <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
				  <span class="number"><i class="fa fa-lock" aria-hidden="true"></i></span>
				   Minha Senha
				 </a>
				</h4>
			   </div>
			   <div id="collapseSix" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSix" aria-expanded="false" style="height: 0px;">
				<div class="row">
				 <div class="easy">
				  <div class=" col-md-offset-3 col-sm-6">
				   <p class="log">Você sempre poderá recuperar sua senha através do seu e-mail.</p>
				   <form action="altera-senha.php" method="POST" name="formSenha" id="formSenha">
				  <div class="input-one form-list">
				   <label class="required">
					Nova Senha
					<em>*</em>
				   </label>
				   <input class="email" type="password" required="" name="senha" id="senha">
				 </div>
				 <br/>
				 <br/>
				 <button class="button2 get" type="submit" title="" >
				  <span>Trocar Senha</span>
				 </button>
				 <input type="hidden" name="id" id="id" value="<?php echo $row_rs_dados_cliente['id'] ?>" />
				 <input type="hidden" name="tipo" id="tipo" value="altera_senha" />
				 <input type="hidden" name="email" id="email" value="<?php echo $row_rs_dados_cliente['email'] ?>" />
				</form>
			   </div>
			  </div>
			 </div>
			</div>
			</div>


			<div class="panel panel-default">
			   <div class="panel-heading" role="tab" id="headingSix">
				<h4 class="panel-title">
				 <a class="collapsed" href="logout.php" >
				  <span class="number"><i class="fa fa-lock" aria-hidden="true"></i></span>
				   Sair (Fazer Logout)
				 </a>
				</h4>
			   </div>
			</div>



			</div>
			</div>

				</div> 
			   </div>
		  </div>
		</section>
        
        <?php include('footer.php'); ?>
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
        <script src="load.js"></script>
    </body>
</html>

<script>
   function buscar_cidade(){
     var estado = $('#id_estado').val();
     if(estado){
       var url = 'buscar_cidade.php?estado='+estado;
       $.get(url, function(dataReturn) {
         $('#load_cidade').html(dataReturn);
       });
     }
   }
</script>