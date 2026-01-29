<?php
// Incluir arquivos necessários
include('restrito.php');
include('Connections/conexao.php');
include('funcoes.php');

// Verificar se o ID do fornecedor foi passado
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>alert('ID do fornecedor não informado!'); window.location.href='fornecedores.php';</script>";
    exit;
}

$id_fornecedor = (int)$_GET['id'];

// Verificar se o fornecedor existe e está ativo
mysql_select_db($database_conexao, $conexao);
$query_verificar = "SELECT id, nome, status FROM tbl_fornecedores WHERE id = $id_fornecedor";
$rs_verificar = mysql_query($query_verificar, $conexao) or die(mysql_error());

if (mysql_num_rows($rs_verificar) == 0) {
    echo "<script>alert('Fornecedor não encontrado!'); window.location.href='fornecedores.php';</script>";
    exit;
}

$row_fornecedor = mysql_fetch_assoc($rs_verificar);

// Verificar se o fornecedor já está inativo
if ($row_fornecedor['status'] == 'I') {
    echo "<script>alert('Este fornecedor já está inativo!'); window.location.href='fornecedores.php';</script>";
    exit;
}

// Atualizar o status do fornecedor para Inativo (I)
$query_atualizar = "UPDATE tbl_fornecedores SET status = 'I' WHERE id = $id_fornecedor";
$rs_atualizar = mysql_query($query_atualizar, $conexao) or die(mysql_error());

if ($rs_atualizar) {
    // Log da ação (opcional)
    $data_hora = date('Y-m-d H:i:s');
    $usuario = $_SESSION['usuario']; // Assumindo que você tem o usuário na sessão
    $log_query = "INSERT INTO tbl_log (acao, tabela, id_registro, usuario, data_hora) 
                  VALUES ('DESATIVAR', 'tbl_fornecedores', $id_fornecedor, '$usuario', '$data_hora')";
    @mysql_query($log_query, $conexao); // @ para ignorar erro se a tabela não existir
    
    echo "<script>alert('Fornecedor \"{$row_produto['nome']}\" desativado com sucesso!'); window.location.href='fornecedores.php';</script>";
} else {
    echo "<script>alert('Erro ao desativar o fornecedor!'); window.location.href='fornecedores.php';</script>";
}

// Fechar conexão
mysql_close($conexao);
?>