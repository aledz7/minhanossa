<?php 
if(file_exists('Connections/conexao.php')) {
	include('Connections/conexao.php');
} else {
	require_once('../Connections/conexao.php');
}

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

// *** Validate request to login to this site.
if(!isset($_SESSION)) {
	session_start();
}

/*
Requisições / POST
acao = login;
Post $campoLogin
Post $campoSenha
*/

function login($campoLogin='email', $campoSenha='senha', $pgSucesso='cliente.php') {
	if($_POST['acao'] == 'login') {
		global $database_conexao, $conexao;

		if($_SESSION['pgRetonaLogin'] <> '') {
			$pgSucesso = $_SESSION['pgRetonaLogin'];
		}
		
		$loginUsername=$_POST[$campoLogin];
		$password=$_POST[$campoSenha];
		
		mysql_select_db($database_conexao, $conexao);
		$LoginRS__query=sprintf("SELECT * FROM tbl_users WHERE $campoLogin=%s AND $campoSenha=%s",
		GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
		$LoginRS = mysql_query($LoginRS__query, $conexao) or die(mysql_error());
		$_SESSION['dadosUser'] = mysql_fetch_assoc($LoginRS);
		$loginFoundUser = mysql_num_rows($LoginRS);
		
		if($loginFoundUser) {
			
			if(PHP_VERSION >= 5.1) {
				session_regenerate_id(true);
			} else {
				session_regenerate_id();
			}
			
			//declare two session variables and assign them
			$_SESSION['MM_Username'] = $loginUsername;
			$_SESSION['MM_UserGroup'] = 'LoginSite';	      
			
			echo "	<script>
					parent.window.location='$pgSucesso';
					</script>";
					exit;
		} else {
			echo "	<script>
					alert('Dados incorretos. Por favor verifique.');
					history.back();
					</script>";
					exit;
		}
	}
}

?>