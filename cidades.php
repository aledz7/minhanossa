<?php

include('class/cidades.php');
$cidades = Cidades::getInstance(Conexao::getInstance());

$cidades->selectCidades('', $_GET['id_estado'], 'id_cidade[]', $_GET['id_cidade'], 'nome', 'text-align: center; border: none;');
?>