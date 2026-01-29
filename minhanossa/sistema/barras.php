<?php
require_once('barcode.inc.php'); 
$code_number = $_GET['codigoBarra'];
$nomeGif = $_GET['nomeGif'];
#new barCodeGenrator($code_number,0,'hello.gif'); 
new barCodeGenrator($code_number,0,$nomeGif, 190, 100, true);
?> 