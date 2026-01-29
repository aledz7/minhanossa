<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2" />
<title>Esqueci minha senha!</title>
<link href="css.css" rel="stylesheet" type="text/css" />
<script src="ajax_framework.js" type="text/javascript"></script>
</head>
<body>

<div style="margin-top:5px; text-align:center; display:none;" id="sucessoSenha"></div>

<div id="formSenha">
<form id="formSenha" name="formSenha" method="post" action="envia.php" style="width:370px;">
      <table width="350" border="0" align="center">
        <tr>
          <td width="9%" align="right" nowrap="nowrap" class="texto_preto">Seu e-mail:&nbsp;</td>
          <td width="91%"><span id="sprytextfield1">
            <input name="email" type="text" class="txtbox2" id="email" /></span></td>
        </tr>
        <tr>
          <td align="right" nowrap="nowrap" class="texto"><input name="acao" type="hidden" id="acao" value="senha" /></td>
          <td align="left"><a href="javascript:;" class="bt86px" style="float:left;" onclick="javascript: document.formSenha.submit();">Confirmar</a>&nbsp;&nbsp;<span id="Loading"><img src=images/loading2.gif width="0" height="0" /></span></td>
        </tr>
      </table>
</form>
</div>

</body>
</html>