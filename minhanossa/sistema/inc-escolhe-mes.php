<?php

$timestamp1 = strtotime(date('Y-m-d'));

if($_SESSION[deDia] == '' and $_GET[deDia] == '') {
	if(date('d') < 8) {
		$_GET[deDia] = date('01/m/Y'); 
	} else {
		$_GET[deDia] = date('d/m/Y', time() - (7*86400)); 
	}
}

if($_SESSION[ateDia] == '' and $_GET[ateDia] == '') {
	$_GET[ateDia] = date('d/m/Y'); 
}

if($_GET[deDia] <> '' and $_GET[ateDia] <> '') {
	$_SESSION[deDia] = $_GET[deDia];
	$_SESSION[ateDia] = $_GET[ateDia]; 
}


$dia = "01";
$mes = date('m');
$ano = date('Y');

$dia2 = "31";
$mes2 = date('m');
$ano2 = date('Y');

if($_GET[ano] <> '') {
	$ano = $_GET[ano];
	$ano2 = $_GET[ano]; 
}


if($_GET[mes] <> '') {
	$mes = $_GET[mes];
	$mes2 = $_GET[mes];
	unset($_SESSION[deDia]);
	unset($_SESSION[ateDia]); 
}

if($_SESSION[deDia] <> '' and $_SESSION[ateDia] <> '') {
	$dia = substr($_SESSION[deDia],0,2);
	$mes = substr($_SESSION[deDia],3,2);
	$ano = substr($_SESSION[deDia],6,4);
	
	$dia2 = substr($_SESSION[ateDia],0,2);
	$mes2 = substr($_SESSION[ateDia],3,2);
	$ano2 = substr($_SESSION[ateDia],6,4);
}
?>