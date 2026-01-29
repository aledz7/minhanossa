<?php 
require_once('Connections/conexao.php');
include('restrito.php');
include('funcoes.php');
if(isset($_GET['id_categoria']) && !empty($_GET['id_categoria'])){
    mysql_select_db($database_conexao, $conexao);
    $query_rs_categoria = "SELECT * FROM tbl_subcategorias WHERE id_categoria = {$_GET['id_categoria']} ORDER BY nome ASC";
    $rs_categoria = mysql_query($query_rs_categoria, $conexao) or die(mysql_error());
    $row_rs_categoria = mysql_fetch_assoc($rs_categoria);
    $totalRows_rs_categoria = mysql_num_rows($rs_categoria);

    while($row_rs_categoria = mysql_fetch_assoc($rs_categoria)) {
        $rows[] = $row_rs_categoria;
    }

    echo json_encode($rows);
}
?>