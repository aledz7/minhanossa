<?php 
include('Connections/conexao.php');
include 'PagSeguroLibrary/PagSeguroLibrary.php';
include('funcoes.php');

session_start();

mysql_select_db($database_conexao, $conexao);
$query_rs_dadosPagseguro = "SELECT * FROM tbl_config";
$rs_dadosPagseguro = mysql_query($query_rs_dadosPagseguro, $conexao) or die(mysql_error());
$row_rs_dadosPagseguro = mysql_fetch_assoc($rs_dadosPagseguro);
$totalRows_rs_dadosPagseguro = mysql_num_rows($rs_dadosPagseguro);

mysql_select_db($database_conexao, $conexao);
$query_rs_dadosPlanos = "SELECT * FROM tbl_plano WHERE id= '".$_GET['id_plano']."'" ;
$rs_dadosPlanos = mysql_query($query_rs_dadosPlanos, $conexao) or die(mysql_error());
$row_rs_dadosPlanos = mysql_fetch_assoc($rs_dadosPlanos);
$totalRows_rs_dadosPlanos = mysql_num_rows($rs_dadosPlanos);

 
/** INICIO PROCESSO PAGSEGURO */
 $paymentrequest = new PagSeguroPaymentRequest();
 
$data = Array(
	'id' => $_GET['id'], // identificador
	'description' => retira_acentos(substr($row_rs_dadosPlanos['nome'], 0, 50)), // descrição
	'quantity' => 1, // quantidade
	'amount' => number_format($row_rs_dadosPlanos['valor'],2,'.',''), // valor unitário
);
$item = new PagSeguroItem($data);
/* $paymentRequest deve ser um objeto do tipo PagSeguroPaymentRequest */
 
$paymentrequest->addItem($item);

/// Frete
if(valorCalculavel($_SESSION[total_frete]) <> '') {
	$dataFrete = Array(
		'id' => $produtos_id . '-Frete', // identificador
		'description' => 'Frete', // descrição
		'quantity' => 1, // quantidade
		'amount' => number_format(valorCalculavel($_SESSION[total_frete]),2,'.',''), 
	);
	$itemFrete = new PagSeguroItem($dataFrete);
	$paymentrequest->addItem($itemFrete);
}

//Definindo moeda
$paymentrequest->setCurrency('BRL');
 
// 1- PAC(Encomenda Normal)
// 2-SEDEX
// 3-NOT_SPECIFIED(Não especificar tipo de frete)
$paymentrequest->setShipping(3);
//Url de redirecionamento
//$paymentrequest->setRedirectURL($redirectURL);// Url de retorno
 
$credentials = PagSeguroConfig::getAccountCredentials();//credenciais do vendedor
 
//$compra_id = App_Lib_Compras::insert($produto);
//$paymentrequest->setReference($compra_id);//Referencia;
 
$url = $paymentrequest->register($credentials);
 
echo " <script> window.location='$url' </script>"
?>