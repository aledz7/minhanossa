<?php
// Incluir arquivos necessários
include('restrito.php');
include('Connections/conexao.php');
include('funcoes.php');

// Verificar se o ID do forncecedor foi passado
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>alert('ID do fornecedor não informado!'); window.location.href='fornecedores.php';</script>";
    exit;
}

$id_fornecedor = (int)$_GET['id'];

// Verificar se o fornecedor existe e está inativo
mysql_select_db($database_conexao, $conexao);
$query_verificar = "SELECT id, nome, status FROM tbl_fornecedores WHERE id = $id_fornecedor";
$rs_verificar = mysql_query($query_verificar, $conexao) or die(mysql_error());

if (mysql_num_rows($rs_verificar) == 0) {
    echo "<script>alert('Fornecedor não encontrada!'); window.location.href='fornecedores.php';</script>";
    exit;
}

$row_fornecedor = mysql_fetch_assoc($rs_verificar);

// Verificar se o fornecedor já está ativo
if ($row_fornecedor['status'] == 'A') {
    echo "<script>alert('Este Fornecedor já está ativo!'); window.location.href='fornecedores.php';</script>";
    exit;
}

// Atualizar o status do fornecedor cor para Ativo (A)
$query_atualizar = "UPDATE tbl_fornecedores SET status = 'A' WHERE id = $id_fornecedor";
$rs_atualizar = mysql_query($query_atualizar, $conexao) or die(mysql_error());

if ($rs_atualizar) {
    // Log da ação (opcional)
    $data_hora = date('Y-m-d H:i:s');
    $usuario = $_SESSION['usuario']; // Assumindo que você tem o usuário na sessão
    $log_query = "INSERT INTO tbl_log (acao, tabela, id_registro, usuario, data_hora) 
                  VALUES ('REATIVAR', 'tbl_cores', $id_fornecedor, '$usuario', '$data_hora')";
    @mysql_query($log_query, $conexao); // @ para ignorar erro se a tabela não existir
    
    echo "<script>alert('Fornecedor \"{$row_fornecedor['nome']}\" reativado com sucesso!'); window.location.href='fornecedores.php';</script>";
} else {
    echo "<script>alert('Erro ao reativar o fornecedor!'); window.location.href='fornecedor.php';</script>";
}

// Fechar conexão
mysql_close($conexao);
?> 