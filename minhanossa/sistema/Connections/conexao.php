<?php
require_once(dirname(__FILE__) . '/../../../php_compat.php');

# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_conexao = "localhost";
$database_conexao = "minha_nossa";
$username_conexao = "root";
$password_conexao = "Df@123456"; 
$conexao = mysql_connect($hostname_conexao, $username_conexao, $password_conexao)or trigger_error(mysql_error(),E_USER_ERROR); 

?>