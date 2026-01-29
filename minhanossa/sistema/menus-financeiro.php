<? 
include('inc-escolhe-mes.php'); 
@ session_start();

if($_GET[ano] <> '') {
	$ano = $_GET[ano];
} else {
	$ano = date('Y');
}
	  
?>
<link href="css2.css" rel="stylesheet" type="text/css">

<table border="0" cellspacing="4" style="margin-left:20px; width:96%; " class="table_menus">
  <tr>
    <td align="center" class="mapaMeses" <? if($mes == 1) { ?>style="background:#0FF"<? } ?> onclick="window.location='<?="?mes=01&ano=$ano";?>'; ">Janeiro</td>
    <td align="center" class="mapaMeses" <? if($mes == 2) { ?>style="background:#0FF"<? } ?> onclick="window.location='<?="?mes=02&ano=$ano";?>';  ">Fevereiro</td>
    <td align="center" class="mapaMeses" <? if($mes == 3) { ?>style="background:#0FF"<? } ?> onclick="window.location='<?="?mes=03&ano=$ano";?>'; ">Mar&ccedil;o</td>
    <td align="center" class="mapaMeses" <? if($mes == 4) { ?>style="background:#0FF"<? } ?> onclick="window.location='<?="?mes=04&ano=$ano";?>'; ">Abril</td>
    <td align="center" class="mapaMeses" <? if($mes == 5) { ?>style="background:#0FF"<? } ?> onclick="window.location='<?="?mes=05&ano=$ano";?>'; ">Maio</td>
    <td align="center" class="mapaMeses" <? if($mes == 6) { ?>style="background:#0FF"<? } ?> onclick="window.location='<?="?mes=06&ano=$ano";?>'; ">Junho</td>
    <td align="center" class="mapaMeses" <? if($mes == 7) { ?>style="background:#0FF"<? } ?> onclick="window.location='<?="?mes=07&ano=$ano";?>'; ">Julho</td>
    <td align="center" class="mapaMeses" <? if($mes == 8) { ?>style="background:#0FF"<? } ?> onclick="window.location='<?="?mes=08&ano=$ano";?>'; ">Agosto</td>
    <td align="center" class="mapaMeses" <? if($mes == 9) { ?>style="background:#0FF"<? } ?> onclick="window.location='<?="?mes=09&ano=$ano";?>'; ">Setembro</td>
    <td align="center" class="mapaMeses" <? if($mes == 10) { ?>style="background:#0FF"<? } ?> onclick="window.location='<?="?mes=10&ano=$ano";?>'; ">Outubro</td>
    <td align="center" class="mapaMeses" <? if($mes == 11) { ?>style="background:#0FF"<? } ?> onclick="window.location='<?="?mes=11&ano=$ano";?>'; ">Novembro</td>
    <td align="center" class="mapaMeses" <? if($mes == 12) { ?>style="background:#0FF"<? } ?> onclick="window.location='<?="?mes=12&ano=$ano";?>'; ">Dezembro</td>
    <td width="80" align="center" nowrap="nowrap" class="mapaMeses"><a href="javascript:;" onclick="window.location='?acao=ocultaMapa&mes=<?=$_GET[mes];?>&ano=<?php
    if($_GET[ano] <> '') {
			echo $_GET[ano]-1;
		} else {
		 	echo date('Y', $timestamp1 + (365 * 86400));
		}
	?>'; "><img src="images/bt-menos.png" width="20" height="19" align="absbottom" style="padding-right:1px;" /></a> 
      <strong>
      <?php
      echo $ano;
	   ?>
      </strong> <a href="javascript:;" onclick="window.location='?acao=ocultaMapa&mes=<?=$_GET[mes];?>&ano=<?php 
	  	if($_GET[ano] <> '') {
			echo $_GET[ano]+1;
		} else {
		 	echo date('Y', $timestamp1 + (365 * 86400));
		}?>&';"><img src="images/bt-mais.png" width="20" height="19" align="absbottom" /></a></td>
  </tr>
</table>
