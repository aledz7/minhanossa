<?php 
include('Connections/conexao.php');
include('funcoes.php');
include('../class/info-site.php');

session_start();
//print_r($_POST);

function scriptTotalFrete($valorFrete, $uf) {
	global $ocultaAcao;

	$infoSite = InfoSite::getInstance(Conexao::getInstance());
	$verifica_estado = $infoSite->rs_estados_frete_gratis('', $uf);
	
	if($valorFrete == '' or $valorFrete <= 0) {
		echo "	<script>
				alert('Erro. Frete não calculado.');
				</script>";
				exit;
	}
	
	if($verifica_estado > 0) {
		$valorFrete = 'Frete Grátis';
		$_SESSION[forma_envio] = 'Frete Grátis';
		$_SESSION[total_frete] = 0;
	} else {
		$valorFrete = 'R$ '.number_format($valorFrete,2,',','.');
	}
	
	if($ocultaAcao == '') {
		echo "	<script>
				parent.document.getElementById('valorFrete').innerHTML='{$valorFrete}';
				parent.document.getElementById('frete').innerHTML='$valorFrete';
				parent.document.getElementById('subtotal').innerHTML= parent.number_format(parseFloat(".valorCalculavel($valorFrete).")+parseFloat(parent.document.getElementById('total_prods').value),2,',','.');
				//alert('Frete calculado, confira o valor Total - Frete e clique em \"Finalizar Pedido\"');
				</script>";
		}
}

$cepOrigem = str_replace('-','',str_replace('.','',$_GET["cep_origem"]));
$cepDestino = str_replace('-','',str_replace('.','',$_GET["cep_destino"]));
$peso = str_replace(',','',str_replace('.','',$_GET["peso"]));
$altura = $_GET['altura'];
$largura = $_GET['largura'];
$comprimento = $_GET['comprimento'];

if($peso < 300) {
	$peso = 300; 
}

$peso = $peso/1000;

mysql_select_db($database_conexao, $conexao);
$query_rs_valorSedex = "SELECT * FROM tbl_sedex_cepacep WHERE cep_origem = '$cepOrigem' and cep_destino = '$cepDestino' and peso = '$peso'";
$rs_valorSedex = mysql_query($query_rs_valorSedex, $conexao) or die(mysql_error());
$row_rs_valorSedex = mysql_fetch_assoc($rs_valorSedex);
$totalRows_rs_valorSedex = mysql_num_rows($rs_valorSedex); 
//print_r($row_rs_valorSedex); exit;

if($totalRows_rs_valorSedex > 0 and $row_rs_valorSedex['valor'] > 0) {	
	$_SESSION[forma_envio] = 'Sedex';
	$_SESSION[total_frete] = $row_rs_valorSedex[valor];
	$valor = $row_rs_valorSedex[valor];
	$uf_cep_destino = $row_rs_valorSedex[uf_cep_destino];
} else {

	/// procura e cadastra um novocep:
	/*ini_set('max_execution_time','6000');
	
	$ch = curl_init();
	// informar URL e outras funções ao CURL
	$url = "http://webservice.uni5.net/web_frete.php?auth=b14a7b8059d9c055954c92674ce60032&tipo=sedex&formato=xml&cep_origem={$cepOrigem}&cep_destino={$cepDestino}&cm_altura=10&cm_largura=15&cm_comprimento=13&peso={$peso}";
	
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	// Acessar a URL e retornar a saída
	$conteudo = curl_exec($ch);
	// liberar
	curl_close($ch);
	
	$dados_frete = simplexml_load_string($conteudo);
	
	$valor = $dados_frete->valor;
	$uf_cep_destino = substr($dados_frete->cidade_destino,-2);*/
		
	//	if($valor == 0 or $valor == '0,00' or $valor == '') {
	//		$valor = '50.00';
	//	}
	
	$data['nCdEmpresa'] = '';
	$data['sDsSenha'] = '';
	$data['sCepOrigem'] = $cepOrigem;
	$data['sCepDestino'] = $cepDestino;
	$data['nVlPeso'] = $peso;
	$data['nCdFormato'] = '1';
	$data['nVlComprimento'] = '16';
	$data['nVlAltura'] = '5';
	$data['nVlLargura'] = '15';
	$data['nVlDiametro'] = '0';
	$data['sCdMaoPropria'] = 'n';
	$data['nVlValorDeclarado'] = '0';
	$data['sCdAvisoRecebimento'] = 'n';
	$data['StrRetorno'] = 'xml';
	//$data['nCdServico'] = '40010';
	$data['nCdServico'] = '40010'; // 41106 pac
	$data = http_build_query($data);
	
	$url = 'http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx';
	
	$curl = curl_init($url . '?' . $data);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	
	$result = curl_exec($curl);
	$result = simplexml_load_string($result);
	foreach($result -> cServico as $row) {
		//Os dados de cada serviço estará aqui
		if($row->Erro == 0) {
			if($row->Codigo == '40010') {
				$valor_sedex = valorCalculavel($row->Valor);
				//print_r($row); exit;
			}
		} else {
			echo $row -> MsgErro;
		}
	}
	
	$valor = $valor_sedex;
	
	//exit;	///echo $valor; exit;
	
	if($valor > 0) {
		$insertSQL = sprintf("INSERT INTO tbl_sedex_cepacep (uf_cep_destino, cep_origem, cep_destino, peso, valor ) VALUES (%s, %s, %s, %s, %s)",
						   GetSQLValueString($uf_cep_destino, "text"),
						   GetSQLValueString($cepOrigem, "text"),
						   GetSQLValueString($cepDestino, "text"),
						   GetSQLValueString($peso, "text"),
						   GetSQLValueString($valor, "text"));
		mysql_select_db($database_conexao, $conexao);
		$Result1 = mysql_query($insertSQL, $conexao) or die(mysql_error());
	
		$_SESSION[forma_envio] = 'Sedex';
		$_SESSION[total_frete] = $valor;
	}
}

scriptTotalFrete($valor, $uf_cep_destino);

mysql_free_result($rs_valorSedex);
?>