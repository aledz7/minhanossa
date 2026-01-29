<?php
// Incluir arquivos necessários
include('restrito.php');
include('Connections/conexao.php');
include('funcoes.php');

// Verificar se o ID da cor foi passado
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>alert('ID da cor não informado!'); window.location.href='cores.php';</script>";
    exit;
}

$id_cor = (int)$_GET['id'];

// Verificar se a cor existe e está inativo
mysql_select_db($database_conexao, $conexao);
$query_verificar = "SELECT id, nome, status FROM tbl_cores WHERE id = $id_cor";
$rs_verificar = mysql_query($query_verificar, $conexao) or die(mysql_error());

if (mysql_num_rows($rs_verificar) == 0) {
    echo "<script>alert('Cora não encontrada!'); window.location.href='cores.php';</script>";
    exit;
}

$row_cor = mysql_fetch_assoc($rs_verificar);

// Verificar se a cor já está ativo
if ($row_cor['status'] == 'A') {
    echo "<script>alert('Esta cor já está ativo!'); window.location.href='cores.php';</script>";
    exit;
}

// Atualizar o status da cor para Ativo (A)
$query_atualizar = "UPDATE tbl_cores SET status = 'A' WHERE id = $id_cor";
$rs_atualizar = mysql_query($query_atualizar, $conexao) or die(mysql_error());

if ($rs_atualizar) {
    // Log da ação (opcional)
    $data_hora = date('Y-m-d H:i:s');
    $usuario = $_SESSION['usuario']; // Assumindo que você tem o usuário na sessão
    $log_query = "INSERT INTO tbl_log (acao, tabela, id_registro, usuario, data_hora) 
                  VALUES ('REATIVAR', 'tbl_cores', $id_cor, '$usuario', '$data_hora')";
    @mysql_query($log_query, $conexao); // @ para ignorar erro se a tabela não existir
    
    echo "<script>alert('Cor \"{$row_cor['nome']}\" reativada com sucesso!'); window.location.href='cores.php';</script>";
} else {
    echo "<script>alert('Erro ao reativar a cor!'); window.location.href='cores.php';</script>";
}

// Fechar conexão
mysql_close($conexao);
?> 