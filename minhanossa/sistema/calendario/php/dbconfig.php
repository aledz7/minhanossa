<?php
include('../../Connections/conexao.php');

class DBConnection{
	function getConnection(){
		global $hostname_conexao, $username_conexao, $password_conexao, $database_conexao;
		//change to your database server/user name/password
		$conexao = mysql_connect($hostname_conexao, $username_conexao, $password_conexao) or trigger_error(mysql_error(),E_USER_ERROR); 
		//change to your database name
		mysql_select_db($database_conexao) or die("Could not select database: " . mysql_error());
	}
}
?>