<?php 
include('Connections/conexao.php'); 
 
if($_GET['email'] <> ''){
	$user = filter_input(INPUT_GET, 'email');
}

mysql_select_db($database_conexao, $conexao);
$query_rs_usuario = "SELECT email FROM tbl_users WHERE email = '".$user."'";
$rs_usuario = mysql_query($query_rs_usuario, $conexao) or die(mysql_error());
$row_rs_usuario = mysql_fetch_assoc($rs_usuario);
$totalRows_rs_usuario = mysql_num_rows($rs_usuario); 

if($totalRows_rs_usuario > 0 ) {//se retornar algum resultado
	echo 'Email já cadastrado!';
} else{
	echo $user;
}
  
?>