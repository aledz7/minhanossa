<?php require_once('Connections/conexao.php'); ?>
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

$colname_rs_conteudo = "-1";
if (isset($_GET['id'])) {
  $colname_rs_conteudo = $_GET['id'];
}
mysql_select_db($database_conexao, $conexao);
$query_rs_conteudo = sprintf("SELECT * FROM tbl_noticias WHERE id = %s", GetSQLValueString($colname_rs_conteudo, "int"));
$rs_conteudo = mysql_query($query_rs_conteudo, $conexao) or die(mysql_error());
$row_rs_conteudo = mysql_fetch_assoc($rs_conteudo);
$totalRows_rs_conteudo = mysql_num_rows($rs_conteudo);
?>