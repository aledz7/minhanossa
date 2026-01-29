<?php
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

$colname_rs_jaExisteCadastro = "-1";
if (isset($_POST['email'])) {
  $colname_rs_jaExisteCadastro = $_POST['email'];
}
mysql_select_db($database_conexao, $conexao);
$query_rs_jaExisteCadastro = sprintf("SELECT count(1) as total FROM tbl_users WHERE email = %s", GetSQLValueString($colname_rs_jaExisteCadastro, "text"));
$rs_jaExisteCadastro = mysql_query($query_rs_jaExisteCadastro, $conexao) or die(mysql_error());
$row_rs_jaExisteCadastro = mysql_fetch_assoc($rs_jaExisteCadastro);
$totalRows_rs_jaExisteCadastro = mysql_num_rows($rs_jaExisteCadastro);

if($row_rs_jaExisteCadastro['total'] > 0) {
	echo "	<script>
			alert('Já existe um cadastro com este e-mail. Por favor, faça seu login.');
			window.location='.';
			</script>";
			exit;
}

mysql_free_result($rs_jaExisteCadastro);
?>
