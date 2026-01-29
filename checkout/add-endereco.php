<? 
include('Connections/conexao.php');
include('funcoes.php');

if($_POST['tipo'] == 'novoEndereco') {

$insertSQL = sprintf("INSERT INTO tbl_endereco (estado, cidade, bairro, endereco, cep, tel_fixo, tel_celular, id_cliente) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_estado'], "int"),
                       GetSQLValueString($_POST['id_cidade'], "int"),
                       GetSQLValueString($_POST['bairro'], "text"),
                       GetSQLValueString($_POST['endereco'], "text"),
                       GetSQLValueString($_POST['cep'], "text"),
                       GetSQLValueString($_POST['telefone'], "text"),
                       GetSQLValueString($_POST['celular'], "text"),
                       GetSQLValueString($_POST['id_cliente'], "int"));

  mysql_select_db($database_conexao, $conexao);
  $Result1 = mysql_query($insertSQL, $conexao) or die(mysql_error());

	echo "<script type='text/javascript'>
			 alert('Novo endereço cadastrado!');
			 window.location='area-cliente.php';
           </script>";
}
if($_POST['tipo'] == 'editarEndereco'){
	$updateSQL = sprintf("UPDATE tbl_users SET estado=%s, cidade=%s, bairro=%s, endereco=%s, cep=%s, tel_fixo=%s, tel_celular=%s, id_cliente=%s, WHERE id=%s",
                       GetSQLValueString($_POST['estado'], "int"),
                       GetSQLValueString($_POST['cidade'], "int"),
                       GetSQLValueString($_POST['bairro'], "text"),
                       GetSQLValueString($_POST['endereco'], "text"),
                       GetSQLValueString($_POST['cep'], "text"),
                       GetSQLValueString($_POST['tel_fixo'], "text"),
                       GetSQLValueString($_POST['tel_celular'], "text"),
                       GetSQLValueString($_POST['id_cliente'], "int"),
                       GetSQLValueString($_POST['id'], "int")); 
	mysql_select_db($database_conexao, $conexao);
	$Result1 = mysql_query($updateSQL, $conexao) or die(mysql_error());

	echo "<script type='text/javascript'>
			 alert('Cadastro Atualizado!');
			 window.location='area-cliente.php';
           </script>";
}

?>