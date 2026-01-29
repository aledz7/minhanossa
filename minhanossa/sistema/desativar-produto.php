<?php
// Incluir arquivos necessários
include('restrito.php');
include('Connections/conexao.php');
include('funcoes.php');

// Verificar se o ID do produto foi passado
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>alert('ID do produto não informado!'); window.location.href='produto.php';</script>";
    exit;
}

$id_produto = (int)$_GET['id'];

// Verificar se o produto existe e está ativo
mysql_select_db($database_conexao, $conexao);
$query_verificar = "SELECT id, nome, status FROM tbl_produto WHERE id = $id_produto";
$rs_verificar = mysql_query($query_verificar, $conexao) or die(mysql_error());

if (mysql_num_rows($rs_verificar) == 0) {
    echo "<script>alert('Produto não encontrado!'); window.location.href='produto.php';</script>";
    exit;
}

$row_produto = mysql_fetch_assoc($rs_verificar);

// Verificar se o produto já está inativo
if ($row_produto['status'] == 'I') {
    echo "<script>alert('Este produto já está inativo!'); window.location.href='produto.php';</script>";
    exit;
}

// Atualizar o status do produto para Inativo (I)
$query_atualizar = "UPDATE tbl_produto SET status = 'I' WHERE id = $id_produto";
$rs_atualizar = mysql_query($query_atualizar, $conexao) or die(mysql_error());

if ($rs_atualizar) {
    // Log da ação (opcional)
    $data_hora = date('Y-m-d H:i:s');
    $usuario = $_SESSION['usuario']; // Assumindo que você tem o usuário na sessão
    $log_query = "INSERT INTO tbl_log (acao, tabela, id_registro, usuario, data_hora) 
                  VALUES ('DESATIVAR', 'tbl_produto', $id_produto, '$usuario', '$data_hora')";
    @mysql_query($log_query, $conexao); // @ para ignorar erro se a tabela não existir
    
    echo "<script>alert('Produto \"{$row_produto['nome']}\" desativado com sucesso!'); window.location.href='produto.php';</script>";
} else {
    echo "<script>alert('Erro ao desativar o produto!'); window.location.href='produto.php';</script>";
}

// Fechar conexão
mysql_close($conexao);
?>