<?php
session_start();

include('../class/produtos.php');
$produtos = Produtos::getInstance(Conexao::getInstance());

$produtos->add_lista_desejos();
?>