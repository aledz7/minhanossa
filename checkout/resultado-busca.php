<?php
 $pdo = new PDO("mysql:host=localhost; dbname=df_bioorganica; charset=utf8;", "root", "", $opcoes);
 $dados = $pdo->prepare("SELECT id, nome FROM tbl_produtos");
 $dados->execute();
 echo json_encode($dados->fetchAll(PDO::FETCH_ASSOC)); 
 ?>
