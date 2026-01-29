<?php 
 

/*
 * success.php
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
<head><title>::Thank You::</title>
<link rel="stylesheet" type="text/css" href="styles.css">
<meta http-equiv="refresh" content="10;URL=../">

<link href="../admin/css.css" rel="stylesheet" type="text/css">
</head>

<body bgcolor="ffffff">
<br>
<br>
<table width="500" border="0" align="center" cellpadding="1" cellspacing="0">
   <tr> 
      <td align="left" valign="top" bgcolor="#333333"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr> 
               <td align="center" bgcolor="#EEEEEE"> <p>&nbsp;</p>
                  <p class="texto_preto"><strong>Seu pagamento foi realizado com sucesso.</strong></p>
              <p>&nbsp;</p></td>
            </tr>
         </table></td>
   </tr>
</table>
<br>
<table width="500" border="0" align="center" cellpadding="1" cellspacing="0">
   <tr> 
      <td align="left" valign="top" bgcolor="#333333"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr align="left" valign="top"> 
               <td width="20%" bgcolor="#EEEEEE"><table width="100%" border="0" cellspacing="3" cellpadding="3">
                     <tr align="left" valign="top"> 
                        <td width="20%" nowrap bgcolor="#EEEEEE" class="texto_preto">Order Number:</td>
                        <td width="80%" bgcolor="#EEEEEE"><?=$_GET[tx]?></td>
                     </tr>
              </table></td>
            </tr>
         </table></td>
   </tr>
</table>
<br>
</body>
</html>