<?php 
if (!isset($_SESSION)) { session_start(); }
include('../Connections/conexao.php');
include('funcoes.php');

//// EXCLUSÃO + EXCUIR FOTO PRINCIPAL + FOTOS DO CONTROLE DE FOTOS
if($_GET['acao'] == 'ExcluirRegistroFotoMaisControle') {
	// deleta foto
	unlink($_GET['foto']);

	/// deleta controle de fotos.
	mysql_select_db($database_conexao, $conexao);
	$query_rs_fotosControleProds = "SELECT foto FROM tbl_fotos WHERE id_galeria = '$_GET['id']' and tipo = '$_GET['NomeControle']'";
	$rs_fotosControleProds = mysql_query($query_rs_fotosControleProds, $conexao) or die(mysql_error());
	$row_rs_fotosControleProds = mysql_fetch_assoc($rs_fotosControleProds);
	$totalRows_rs_fotosControleProds = mysql_num_rows($rs_fotosControleProds);

	do {
		unlink("../galerias/$row_rs_fotosControleProds[foto]");
	} while ($row_rs_fotosControleProds = mysql_fetch_assoc($rs_fotosControleProds));

	/// deleta produto.
	$deleteSQL = sprintf("DELETE FROM $_GET['tbl'] WHERE id=%s",
                       GetSQLValueString($_GET['id'], "int"));
	mysql_select_db($database_conexao, $conexao);
	$Result1 = mysql_query($deleteSQL, $conexao) or die(mysql_error());	

	echo '{"erro":"N"}';
	exit;
}


if($_GET['acao'] == 'esqueciSenha') {
	mysql_select_db($database_conexao, $conexao);
	$query_rs_email = "SELECT * FROM tbl_admin WHERE email = '$_GET['email']'";
	$rs_email = mysql_query($query_rs_email, $conexao) or die(mysql_error());
	$row_rs_email = mysql_fetch_assoc($rs_email);
	$totalRows_rs_email = mysql_num_rows($rs_email);
	
	include('config.php');

	if($totalRows_rs_email == 0) {
		echo '{"erro":"S"}';
		exit;
	} else {
		/// Envia senha para o email do usuário
		@ mail($_GET['email'],"Recuperação de Senha","Olá conforme solicitado informamos que sua senha para acesso ao painel de controle é: $row_rs_email[senha]
		Qualquer dúvida nao deixe de entrar em contato conosco.
		
		
		Muito obrigado.
		Equipe $titulo
		$dominio","From: $titulo <$email_site>");
		
		echo '{"erro":"N"}';
		exit;
	}
}


if($_POST['acao'] == 'login') {
	$loginUsername=$_POST['login'];
	$password=$_POST['senha'];
	$MM_fldUserAuthorization = "";
	$MM_redirectLoginSuccess = "principal.php";
	$MM_redirectLoginFailed = "login.php";
	$MM_redirecttoReferrer = false;
	mysql_select_db($database_conexao, $conexao);
  
	$LoginRS__query=sprintf("SELECT login, senha FROM tbl_admin WHERE login=%s AND senha=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
	$LoginRS = mysql_query($LoginRS__query, $conexao) or die(mysql_error());
	$loginFoundUser = mysql_num_rows($LoginRS);
	if($loginFoundUser) {
		$loginStrGroup = "";
    
	if(PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = 'DF_administrativo';	      

    if(isset($_SESSION['PrevUrl']) && false) {
		$MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
	echo "	<script>
			window.location='.';
			</script>";
			exit;
 
	if($_POST['loginSite'] == 'ok'){
		echo "	<script>
			window.location='.';
			</script>";
			exit;
	}
 
 
  }
  else {
	echo "	<script>
			alert('Dados inválidos.');
			window.location='.';
			</script>";
			exit;
  }
}



if($_GET['acao'] <> 'Login' and $_GET['acao'] <> 'esqueciSenha') {
	//include('restrito.php');
	//// EXCLUSÃO DE REGISTROS
	if($_GET['acao'] == 'excluirRegistro') {
		mysql_select_db($database_conexao, $conexao);
		
		// deleta registro
		$deleteSQL = sprintf("DELETE FROM $_GET['tbl'] WHERE id=%s", GetSQLValueString($_GET['id'], "int"));
		$Result1 = mysql_query($deleteSQL, $conexao) or die(mysql_error());	
		
		echo '{"erro":"N"}';
		exit;
	}
}



?>