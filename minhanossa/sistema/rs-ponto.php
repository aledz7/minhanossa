<?php
mysql_select_db($database_conexao, $conexao);
$query_rs_ponto = "
SELECT 
	tbl_ponto.* 
FROM 
	tbl_ponto 
WHERE 
	1=1
	and id_funcionario = '".$_GET['id_vendedor']."'
	AND date(chegada) >= '".formataDataSQL($_GET['dataInicio'])."'
	AND date(chegada) <= '".formataDataSQL($_GET['dataFim'])."' 
order by 
	chegada";
$rs_ponto = mysql_query($query_rs_ponto, $conexao) or die(mysql_error());
$row_rs_ponto = mysql_fetch_assoc($rs_ponto);
$totalRows_rs_ponto = mysql_num_rows($rs_ponto);
