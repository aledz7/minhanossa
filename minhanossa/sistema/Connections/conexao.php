<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_conexao = "mysql.minhanossa.net.br";
$database_conexao = "minhanossa";
$username_conexao = "minhanossa";
$password_conexao = "Cgd6Im8947V3";
$conexao = mysql_connect($hostname_conexao, $username_conexao, $password_conexao)or trigger_error(mysql_error(),E_USER_ERROR); 

?>