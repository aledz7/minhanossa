<?php
/*include('class/info-site.php');
$infoSite = InfoSite::getInstance(Conexao::getInstance())->rsDados();

$nomeRemente = $infoSite->nome;
$emailRemente = $infoSite->email;

if($_POST['acao'] == 'enviaEmail') {
	include('funcoes/enviar-email.php');
	EnviarEmail($_POST['assunto'].' '.$infoSite->nome, $_POST['nome'], $emailRemente, $emailRemente, $_POST['email'], "Nome: {$_POST['nome']}<br>
E-mail: {$_POST['email']}<br>
Telefone: {$_POST['telefone']}<br>
Mensagem: {$_POST['mensagem']}");
}
*/

if (!function_exists("EnviarEmail")) {
	function EnviarEmail($assunto, $nomeRemente, $emailRemente, $emailDestino, $emailDeResposta, $msgHTML, $alert='Solicitação enviada com sucesso.') {
		if($emailDestino <> '') {
			$remetente = "$nomeRemente <$emailRemente>"; 
			$headers = "Content-Type: text/html; charset=utf-8\n";
			$headers.="From: $remetente\n"; 
			$headers.="Reply-To: $emailDeResposta\n"; 
			$headers.="Subject: $assunto\n"; 
			$headers.="Return-Path: $remetente\n"; 
			$headers.="MIME-Version: 1.0\n"; 
			$headers.="X-Priority: 3\n"; 
			/// envia o email
			mail($emailDestino, $assunto, $msgHTML, $headers);
		}
		
		if($alert <> 'N') {
			echo "	<script>
					alert('{$alert}');
					</script>";
		}
	}
}
?>