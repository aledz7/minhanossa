<?php 
include('Connections/conexao.php');
include('funcoes.php');

if (!isset($_SESSION)) { session_start(); }


if (!function_exists("scriptTotalFrete")) {
	function scriptTotalFrete($valorFrete) {
		global $ocultaAcao;
		if($ocultaAcao == '') {
			
			$_SESSION['total_frete_pac'] = $valorFrete;
			
			echo "	<script>
			parent.document.getElementById('resultado_pac').value='$valorFrete';
			parent.document.getElementById('subtotal_pac').value= parent.number_format(parseFloat(".valorCalculavel($valorFrete).")+parseFloat(parent.document.getElementById('total_prods').value),2,',','.');
			</script>";
		}
	}
}

	$cepOrigem = str_replace('-','',str_replace('.','',$_GET["cep_origem"]));
	$cepDestino = str_replace('-','',str_replace('.','',$_GET["cep_destino"]));
	$peso = str_replace(',','',str_replace('.','',$_GET["peso"]));


if($peso < 300) {
	$peso = 300; 
}

	mysql_select_db($database_conexao, $conexao);
	$query_rs_valorSedex = "SELECT * FROM tbl_pac_cepacep WHERE cep_origem = '$cepOrigem' and cep_destino = '$cepDestino' and peso = '$peso'";
	$rs_valorSedex = mysql_query($query_rs_valorSedex, $conexao) or die(mysql_error());
	$row_rs_valorSedex = mysql_fetch_assoc($rs_valorSedex);
	$totalRows_rs_valorSedex = mysql_num_rows($rs_valorSedex);

if($totalRows_rs_valorSedex > 0 ) {
	$conteudo = $row_rs_valorSedex['valor'];
	scriptTotalFrete($row_rs_valorSedex['valor']); 
} else {
	/// procura e cadastra um novocep:
	
	ini_set('max_execution_time','6000');
	
	$url = "http://webservice.uni5.net/web_frete.php?auth=3876ff47d70cdc2013b502de95fc9c5b&tipo=pac&formato=xml&cep_origem=$cepOrigem&cep_destino=$cepDestino&peso=$peso";

$ch = curl_init();
// informar URL e outras funções ao CURL
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// Acessar a URL e retornar a saída
$conteudo = curl_exec($ch);
// liberar
curl_close($ch);

$conteudo = substr($conteudo,strpos($conteudo,"<valor>")+7);
$conteudo = number_format(substr($conteudo,0,strpos($conteudo,"</valor>")),2,',','.');

if($conteudo == '' or $conteudo == '0' or $conteudo == '0,00') {
	echo "	<script>
			alert('Não foi possível localizar as informações de frete para PAC.');
			</script>";
			exit; 
}
			
	scriptTotalFrete($conteudo);

  $insertSQL = sprintf("INSERT INTO tbl_pac_cepacep (cep_origem, cep_destino, peso, valor ) VALUES ( %s, %s, %s, %s)",
                       GetSQLValueString($cepOrigem, "text"),
                       GetSQLValueString($cepDestino, "text"),
                       GetSQLValueString($peso, "text"),
                       GetSQLValueString($conteudo, "text"));

  mysql_select_db($database_conexao, $conexao);
  $Result1 = mysql_query($insertSQL, $conexao) or die(mysql_error());

}

mysql_free_result($rs_valorSedex);
?>
