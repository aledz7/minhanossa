<?php 
if(file_exists('Connections/conexao.php')) {
	include('Connections/conexao.php');
} else {
	require_once('../Connections/conexao.php');
}?>
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

mysql_select_db($database_conexao, $conexao);
$query_rs_config = "SELECT * FROM tbl_config";
$rs_config = mysql_query($query_rs_config, $conexao) or die(mysql_error());
$row_rs_config = mysql_fetch_assoc($rs_config);
$totalRows_rs_config = mysql_num_rows($rs_config);

mysql_select_db($database_conexao, $conexao);
$query_rs_dados = "SELECT * FROM tbl_dados_cadastrais";
$rs_dados = mysql_query($query_rs_dados, $conexao) or die(mysql_error());
$row_rs_dados = mysql_fetch_assoc($rs_dados);
$totalRows_rs_dados = mysql_num_rows($rs_dados);

$dadosSite['telefone'] = $row_rs_dados['telefone'];
$dadosSite['email'] = $row_rs_dados['e_mail'];
$dadosSite['endereco'] = $row_rs_config['endereco'];
$dadosSite['nome'] = $row_rs_dados['nome_loja'];

mysql_free_result($rs_config);

mysql_free_result($rs_dados);
?>