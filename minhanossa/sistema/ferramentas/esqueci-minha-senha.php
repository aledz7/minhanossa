<?php require_once('../Connections/conexao.php'); ?>
<?php
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

mysql_select_db($database_conexao, $conexao);
$query_rs_email = "SELECT * FROM tbl_users WHERE email = '$_POST['email']'";
$rs_email = mysql_query($query_rs_email, $conexao) or die(mysql_error());
$row_rs_email = mysql_fetch_assoc($rs_email);
$totalRows_rs_email = mysql_num_rows($rs_email);

include('config.php');

if($_POST['email'] <> '') {
	if($totalRows_rs_email == 0) {
		echo "	<script>
				alert('E-mail não localizado em nossa base de dados.');
				self.close()
				</script>";
	} else {
		/// Envia senha para o email do cliente
		mail($_POST['email'],"Sua senha","Olá conforme solicitado informamos que sua senha para acesso ao site é: $row_rs_email[senha]
		
		Qualquer dúvida não deixe de entrar em contato conosco utilizando nosso formulário de contato.
		Muito obrigado.
		$titulo","From: $titulo <$email_loja>");
		
		echo "	<script>
				alert('Sua senha foi enviada para o e-mail informado.')
				self.close();
				</script>";
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Esqueci minha senha!</title>
<link href="../admin/css.css" rel="stylesheet" type="text/css" />
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script type="text/javascript">
<!--
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
</script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="admin/css.css" rel="stylesheet" type="text/css" />
</head>

<body>
<fieldset class="texto_preto" style="-moz-border-radius: 8px; -webkit-border-radius: 8px;">
<legend class="texto_preto">Esqueci minha senha:</legend>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><hr /></td>
  </tr>
  <tr>
    <td><form id="form1" name="form1" method="post" action="">
      <table width="100%" border="0" class="texto_pretoClaro">
        <tr>
          <td width="7%" align="right" nowrap="nowrap" ><strong>Seu e-mail:</strong></td>
          <td width="93%"><span id="sprytextfield1">
            <input name="email" type="text" class="txtbox2" id="email" /></span></td>
        </tr>
        <tr>
          <td align="right" nowrap="nowrap" class="texto_preto" >&nbsp;</td>
          <td><input name="button" type="submit" class="style_botao_preto" id="button" value="Avan&ccedil;ar" style="padding:3px;" />
            <input name="button2" type="button" class="style_botao_preto" id="button2" onclick="MM_goToURL('parent','javascript:self.close()');return document.MM_returnValue" value="Fechar" style="padding:3px;" /></td>
        </tr>
      </table>
        </form>
    </td>
  </tr>
</table>
</fieldset>

<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
//-->
</script>
</body>
</html>
<?php
mysql_free_result($rs_email);
?>
