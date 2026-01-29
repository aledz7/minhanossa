<?php
/*
 * process.php
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

//Configuration File
include_once('includes/config.inc.php'); 

//Global Configuration File
include_once('includes/global_config.inc.php');

?> 

<html>
<head><title>:: PayPal::</title>
<link href="../pousada/css.css" rel="stylesheet" type="text/css">
</head>
<body onLoad="document.paypal_form.submit();">
<form method="post" name="paypal_form" action="<?=$paypal[url]?>">

<p>
  <?php 
//show paypal hidden variables

showVariables(); 

?>
  
  <br>
  <br>
  <br>
</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<table width="500" border="0" align="center" cellpadding="1" cellspacing="0">
  <tr> 
      <td align="left" valign="top" bgcolor="#333333"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr> 
               <td align="center" bgcolor="#EEEEEE"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
                 <tr>
                   <td width="20%" align="center"><img src="../images/paypal-verified.png" width="66" height="61"></td>
                   <td width="80%" valign="middle"> <br>
                     Voc&ecirc; est&aacute; sendo redirecionado  para o <img src="../images/paypal_png.png" width="57" height="20" align="absmiddle">.<br>
&quot;L&iacute;der  mundial em pagamentos pela internet&quot;. <br>
<br></td>
                 </tr>
               </table></td>
            </tr>
         </table></td>
   </tr>
</table>

</form>
</body>   
</html>
