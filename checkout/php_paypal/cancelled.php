<?php require_once('../Connections/conexao.php'); ?>
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

/*  $deleteSQL = sprintf("DELETE FROM tbl_reservas WHERE id=%s",
                       GetSQLValueString($_GET['id'], "int"));

  mysql_select_db($database_conexao, $conexao);
  $Result1 = mysql_query($deleteSQL, $conexao) or die(mysql_error());	
  
//// excluir reservas dias
  $deleteSQL = sprintf("DELETE FROM tbl_reservas_dias WHERE id_reserva=%s",
                       GetSQLValueString($_GET['id'], "int"));

  mysql_select_db($database_conexao, $conexao);
  $Result1 = mysql_query($deleteSQL, $conexao) or die(mysql_error());	
  
//// excluir conta corrente reservas dias
  $deleteSQL = sprintf("DELETE FROM tbl_contacorrente WHERE id_reserva=%s",
                       GetSQLValueString($_GET['id'], "int"));

  mysql_select_db($database_conexao, $conexao);
  $Result1 = mysql_query($deleteSQL, $conexao) or die(mysql_error());	

/*
 * cancelled.php
 *
 * PHP Toolkit for PayPal v0.51
 * http://www.paypal.com/pdn
 *
 * Copyright (c) 2004 PayPal Inc
 *
 * Released under Common Public License 1.0
 * http://opensource.org/licenses/cpl.php
 *
 */
?>

<html>
<head><title>::Cancelled Payment::</title>
<link rel="stylesheet" type="text/css" href="styles.css">
<link href="../admin/css.css" rel="stylesheet" type="text/css">
</head>

<body bgcolor="ffffff">
<table width="500" border="0" align="center" cellpadding="1" cellspacing="0">
   <tr> 
      <td align="left" valign="top" bgcolor="#333333"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr> 
               <td align="center" bgcolor="#EEEEEE"> <p>&nbsp;</p>
                  <p class="texto_preto">Desculpe, seu cart&atilde;o de cr&eacute;dito foi recusado.</p>
              <p>&nbsp;</p></td>
            </tr>
         </table></td>
   </tr>
</table>
</body>
</html>