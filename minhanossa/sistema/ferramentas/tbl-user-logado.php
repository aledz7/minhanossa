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

if(!function_exists("exigeLogin")) {
	function exigeLogin($pgLogin='login.php') {
		global $row_rs_userLogado;
		
		if($row_rs_userLogado['nome'] == '') {
			echo "	<script>
					alert('Por favor. Realize login para continuar.');
					window.location='{$pgLogin}'
					</script>";
					exit;
		}
	}
}

$colname_rs_userLogado = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_rs_userLogado = $_SESSION['MM_Username'];
}
mysql_select_db($database_conexao, $conexao);
$query_rs_userLogado = sprintf("SELECT * FROM tbl_admin WHERE login = %s", GetSQLValueString($colname_rs_userLogado, "text"));
$rs_userLogado = mysql_query($query_rs_userLogado, $conexao) or die(mysql_error());
$row_rs_userLogado = mysql_fetch_assoc($rs_userLogado);
$totalRows_rs_userLogado = mysql_num_rows($rs_userLogado);

$_SESSION['dadosUser'] = $row_rs_userLogado;

mysql_free_result($rs_userLogado);
?>