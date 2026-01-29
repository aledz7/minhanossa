<?php require_once('../Connections/conexao.php'); ?><?php

if (!function_exists("GetSQLValueString")) {

function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 

{

  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;



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

      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";

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



if ((isset($_POST['id'])) && ($_POST['id'] != "")) {

  $deleteSQL = sprintf("DELETE FROM $_POST[tbl] WHERE id=%s",
                       GetSQLValueString($_POST['id'], "int"));

unlink("../galerias/$_POST[foto]");

  mysql_select_db($database_conexao, $conexao);
  $Result1 = mysql_query($deleteSQL, $conexao) or die(mysql_error());

?>

<script>
window.opener.location='controle-de-fotos.php?tipo=<?=$_POST[volta];?>&id=<?=$_POST[idGaleria];?>';
window.opener.focus();
self.close();
</script>
<?

}

?><link href="../css.css" rel="stylesheet" type="text/css">

<script type="text/javascript">

<!--

function MM_goToURL() { //v3.0

  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;

  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");

}

//-->

</script>

<link href="css.css" rel="stylesheet" type="text/css" />
<span class="azul12bold"><br>

</span>
<div align="center" class="preto_arial_12"><span class="azul12bold"><strong>Tem certeza que deseja excluir este registro?</strong></span><br>

  <form name="form1" method="post" action="">
    <br />


    <input name="idGaleria" type="hidden" id="idGaleria" value="<?=$_GET[idGaleria];?>" />
    <input name="foto" type="hidden" id="foto" value="<?=$_GET[foto];?>" />
    <input name="volta" type="hidden" id="volta" value="<?=$_GET[volta];?>">

    <input name="tbl" type="hidden" id="tbl" value="<?=$_GET[tbl];?>">

    <input name="id" type="hidden" id="id" value="<?=$_GET[id];?>">

    <input name="button" type="submit" class="style_botao_preto" id="button" value="  Sim  ">

    <input name="button2" type="button" class="style_botao_preto" id="button2" onClick="MM_goToURL('parent','javascript:self.close()');return document.MM_returnValue" value="  N&atilde;o  ">

        </form>

</div>

