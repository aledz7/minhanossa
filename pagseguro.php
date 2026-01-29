<?php 
include('Connections/conexao.php');

session_start();
include('PagSeguroLibrary/PagSeguroLibrary.php');
include('funcoes.php');

mysql_select_db($database_conexao, $conexao);
$query_rs_dadosPagseguro = "SELECT * FROM tbl_config";
$rs_dadosPagseguro = mysql_query($query_rs_dadosPagseguro, $conexao) or die(mysql_error());
$row_rs_dadosPagseguro = mysql_fetch_assoc($rs_dadosPagseguro);
$totalRows_rs_dadosPagseguro = mysql_num_rows($rs_dadosPagseguro);
 
/** INICIO PROCESSO PAGSEGURO */
 $paymentrequest = new PagSeguroPaymentRequest();

//echo $_SESSION['compra']; exit;

$paymentrequest->setReference($_SESSION['compra']);
$paymentrequest->setRedirectUrl("http://www.minhanossa.net.br");  
$paymentrequest->addParameter('notificationURL', 'http://www.minhanossa.com.br/retorno-pagseguro.php');  

if($desconto > 0) { 
	$totalPagSeguro = number_format(valorCalculavel($totalValorDe)-valorCalculavel($desconto),2,',','');
} else {
	$totalPagSeguro = number_format($row_rs_cidades[valor]+$_SESSION['total_frete']+$total_prods-$desconto,2,',','');
}

$data = Array(
 'id' => $_SESSION['compra'], // identificador da compra
 'description' => substr($produtos_nomes,0,50).'...', // descrição
 'quantity' => 1, // quantidade
 'amount' => $totalPagSeguro, // valor unitário
);


$item = new PagSeguroItem($data);
/* $paymentRequest deve ser um objeto do tipo PagSeguroPaymentRequest */
 
$paymentrequest->addItem($item);
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