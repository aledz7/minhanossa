<? 
include('Connections/conexao.php');
include('funcoes.php');

include('class/clientes.php');
$clientes = Clientes::getInstance(Conexao::getInstance());

$clientes->editar("area-cliente.php");

if($_POST[tipo] == 'clientes') {
	
	$insertSQL = sprintf("INSERT INTO tbl_cliente (nome, sexo, cpf, data_de_nascimento, telefone, email, senha, endereco, cep, bairro, id_cidade, id_estado, complemento, ativo) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['nome'], "text"),
                       GetSQLValueString($_POST['sexo'], "text"),
                       GetSQLValueString($_POST['cpf'], "text"),
                       GetSQLValueString(formataDataSQL($_POST['data_nascimento']), "text"),
                       GetSQLValueString($_POST['telefone'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['senha'], "text"),
                       GetSQLValueString($_POST['endereco'], "text"),
                       GetSQLValueString($_POST['cep'], "text"),
                       GetSQLValueString($_POST['bairro'], "text"),
                       GetSQLValueString($_POST['id_cidade'], "text"),
                       GetSQLValueString($_POST['id_estado'], "text"),
                       GetSQLValueString($_POST['complemento'], "text"),
                       GetSQLValueString($_POST['ativo'], "text")); 
	mysql_select_db($database_conexao, $conexao);
	$Result1 = mysql_query($insertSQL, $conexao) or die(mysql_error());
  
	echo "	<script type='text/javascript'>
			alert('Obrigado por se cadastrar em nossa loja! Por favor realize seu login.');
			window.location='login.php';
           	</script>";
			exit;
}



?>